<?php

namespace Amicable\PluginManager;

class Plugin {

    protected $name;
    protected $label;
    protected $download_url = '';
    protected $file;
    protected $description = ''; // New property for the description

    public function __construct( $name, array $options = [] ) {
        // Ensure the plugins_api() function is available
        if ( ! function_exists( 'plugins_api' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        }

        foreach ( array_keys( get_object_vars( $this ) ) as $key ) {
            if ( isset( $options[ $key ] ) ) {
                $this->$key = $options[ $key ];
            }
        }

        $this->name = $name;
        $this->file = $options['file'] ?? '';

        // If the plugin is locally installed
        if ( empty( $this->label ) && is_file( WP_PLUGIN_DIR . '/' . $this->file ) ) {
            $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $this->file );
            $this->label = $plugin_data['Name'];
            $this->description = $plugin_data['Description']; // Get the description from the local plugin
        } elseif ( empty( $this->label ) ) {
            // Attempt to fetch data from the WordPress Plugin Directory
            $this->fetchPluginDirectoryData($name);
            $this->label = $options['label'] ?? $name;
        }
    }

    protected function fetchPluginDirectoryData($slug) {
        $api = plugins_api(
            'plugin_information',
            array(
                'slug'   => $slug,
                'fields' => array(
                    'short_description' => true,
                    'download_link' => true,
                ),
            )
        );

        if ( ! is_wp_error( $api ) ) {
            $this->label = $api->name;

            // Safely check if download_link exists
            if ( isset( $api->download_link ) ) {
                $this->download_url = $api->download_link;
            }

            // Save the short description
            if ( isset( $api->short_description ) ) {
                $this->description = $api->short_description;
            }
        }
    }

    public function name() {
        return $this->name;
    }

    public function label() {
        return $this->label;
    }

    public function installed() {
        return is_file( WP_PLUGIN_DIR . '/' . $this->file );
    }

    public function active() {
        return is_plugin_active( $this->file );
    }

    public function downloadUrl() {
        return $this->download_url;
    }

    public function description() {
        return $this->description;
    }

    public function activateUrl() {
        if ( ! $this->installed() ) {
            return '';
        }

        return wp_nonce_url(
            add_query_arg( [
                'action' => 'activate',
                'plugin' => rawurlencode( $this->file ),
            ], admin_url( 'plugins.php' ) ),
            'activate-plugin_' . $this->file
        );
    }

    public function deactivateUrl() {
        if ( ! $this->active() ) {
            return '';
        }

        return wp_nonce_url(
            add_query_arg( [
                'action' => 'deactivate',
                'plugin' => rawurlencode( $this->file ),
            ], admin_url( 'plugins.php' ) ),
            'deactivate-plugin_' . $this->file
        );
    }

    public function displayCard() { 
        // Display a recommendation paragraph at the top before rendering the plugin cards.
        if ( $this->name === 'regenerate-thumbnails' ) {
            echo '<p class="plugin-recommendation">';
            echo '<h3 style="margin-bottom: 0.5rem;">' . esc_html__( 'Recommended Plugins', 'amicable' ) . '</h3>';
            echo esc_html__( 'To get the most out of your website, we recommend using the following plugins. These tools help improve performance, security, and overall functionality. They are trusted by many users and are actively maintained by reliable developers. Whether you want faster loading times or enhanced protection, these plugins are designed to meet those needs. Consider adding them to your setup to keep your site running smoothly and securely.', 'amicable' );
            echo '</p><br />';
        }

        // Skip rendering the card if the plugin is "classicpress-directory-integration".
        if ( $this->name === 'classicpress-directory-integration/classicpress-directory-integration.php' ) {
            return;
        }
        ?>

        <div class="plugin-card <?php echo $this->active() ? 'active' : '' ?>" aria-describedby="<?php echo esc_attr( sprintf( '%1$s-action %1$s-name', $this->name() ) ) ?>" data-slug="<?php echo esc_attr( $this->name() ) ?>">

            <div class="plugin-title" style="padding: 0 1rem">
                <h2 class="plugin-name" id="<?php echo esc_attr( sprintf( '%s-name', $this->name() ) ) ?>">
                    <?php if ( $this->active() ) : ?>
                        <span class="dashicons dashicons-yes"></span> <?php echo esc_html( $this->label() ) ?>
                    <?php else : ?>
                        <?php echo esc_html( $this->label() ) ?>
                    <?php endif ?>
                </h2>
            </div>

            <div class="plugin-description" style="padding: 0 1rem; margin-bottom: 1rem;">
                <p><?php echo esc_html( $this->description() ); ?></p>
            </div>

            <div class="plugin-action-buttons">
                <?php foreach ( $this->pluginActions() as $action ) : ?>
                    <?php echo $action; // phpcs:ignore ?>
                <?php endforeach; ?>
            </div>

        </div>

        <?php
    }

    private function pluginActions() {
        $actions = [];

        if ( $this->installed() ) {

            if ( $this->active() && current_user_can( 'deactivate_plugins' ) ) {
                $actions[] = sprintf(
                    '<a class="button button-secondary" href="%s">%s</a>',
                    esc_url( $this->deactivateUrl() ),
                    esc_html__( 'Deactivate', 'amicable' )
                );
            }

            if ( ! $this->active() && current_user_can( 'activate_plugins' ) ) {
                $actions[] = sprintf(
                    '<a class="button button-primary" href="%s">%s</a>',
                    esc_url( $this->activateUrl() ),
                    esc_html__( 'Activate', 'amicable' )
                );
            }

        } elseif ( $this->downloadUrl() ) {
            $actions[] = sprintf(
                '<a class="button button-primary" href="%s" target="_blank">%s</a>',
                esc_url( $this->downloadUrl() ),
                esc_html__( 'Download', 'amicable' )
            );
        }

        return $actions;
    }
}
