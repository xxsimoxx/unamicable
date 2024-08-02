<?php
/**
 * General Settings View.
 *
 * Displays the general theme settings view (tab) on the settings page.
 *
 * @package   Amicable
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2024 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/amicable
 */

namespace Amicable\Settings\Admin\Views;

use Amicable\Settings\Options;
use function Backdrop\Theme\is_classicpress;

/**
 * General settings view class.
 *
 * @since  1.0.0
 * @access public
 */
class General extends View {

	/**
	 * Returns the view name/ID.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function name() {
		return 'general';
	}

	/**
	 * Returns the internationalized, human-readable view label.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function label() {

		return esc_html__( 'General', 'amicable' );
	}

	/**
	 * Called on the `admin_init` hook and should be used to register theme
	 * settings via the Settings API.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		// Get the current plugin settings w/o the defaults.
		$this->settings = get_option( 'amicable_settings' );

		// Register the setting.
		register_setting( 'amicable_settings', 'amicable_settings', [ $this, 'validateSettings' ] );

		// Register sections and fields.
		add_action( 'amicable/settings/admin/view/general/register', [ $this, 'registerDefaultSections' ] );
		add_action( 'amicable/settings/admin/view/general/register', [ $this, 'registerDefaultFields'   ] );
	}

	/**
	 * Called on the `load-{$page}` hook when the view is booted. Use this
	 * to add any actions or filters needed.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		do_action( 'amicable/settings/admin/view/general/register' );
	}

	/**
	 * Validates the settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validateSettings( $settings ) { // phpcs:ignore

		// Checkboxes.
		$settings['disable_emoji']    = ! empty( $settings['disable_emoji']    );
		$settings['disable_toolbar']  = ! empty( $settings['disable_toolbar']  );
		$settings['disable_wp_embed'] = ! empty( $settings['disable_wp_embed'] );

		// Integers.
		$settings['error_page'] = absint( $settings['error_page']           );

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * Registers default settings sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function registerDefaultSections() {

		$label = is_classicpress() ? __( 'Clean ClassicPress', 'amicable' ) : __( 'Clean WordPress', 'amicable' );

		$sections = [
			'reading' => [
				'label'    => __( 'Reading', 'amicable' ),
				'callback' => 'sectionReading'
			],
			'clean_cp' => [
				'label'    => $label,
				'callback' => 'sectionCleanCP'
			]
		];

		array_map( function( $name, $section ) {

			add_settings_section(
				$name,
				$section['label'],
				[ $this, $section['callback'] ],
				'amicable_settings'
			);

		}, array_keys( $sections ), $sections );
	}

	/**
	 * Registers default settings fields.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function registerDefaultFields() {

		$fields = [

			// Reading fields.
			'error_page' => [
				'label'    => __( '404 Page', 'amicable' ),
				'callback' => 'fieldErrorPage',
				'section'  => 'reading'
			],

			// Clean WP fields.
			'emoji' => [
				'label'    => __( 'Emoji', 'amicable' ),
				'callback' => 'fieldEmoji',
				'section'  => 'clean_cp',
			],
			'toolbar' => [
				'label'    => __( 'Toolbar', 'amicable' ),
				'callback' => 'fieldToolbar',
				'section'  => 'clean_cp'
			],
			'embeds' => [
				'label'    => __( 'Embeds', 'amicable' ),
				'callback' => 'fieldEmbeds',
				'section'  => 'clean_cp'
			]
		];

		array_map( function( $name, $field ) {

			add_settings_field(
				$name,
				$field['label'],
				[ $this, $field['callback'] ],
				'amicable_settings',
				$field['section']
			);

		}, array_keys( $fields ), $fields );
	}

	/**
	 * Displays the reading section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function sectionReading() { ?>
		<p>
			<?php esc_html_e( 'Settings related to reading and display options for your site, including the 404 error page.', 'amicable' ) ?>
		</p>

	<?php }

	/**
	 * Displays the clean WP section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function sectionCleanCP() { ?>

		<p>
			<?php esc_html_e( 'Clean up unnecessary items on the front end of your site for speed improvements.', 'amicable' ) ?>
		</p>

	<?php }

	/**
	 * Displays the 404 error page field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function fieldErrorPage() {

		$dropdown = wp_dropdown_pages( [
			'name'              => 'amicable_settings[error_page]',
			'option_none_value' => 0,
			'selected'          => Options::get( 'error_page' ), // phpcs:ignore
			'post_status'       => [ 'private' ],
			'echo'              => false
		] ); ?>

		<p>
			<label>
				<?php if ( $dropdown ) : ?>

					<?php echo wp_kses( $dropdown, [
                    'select' => [
                        'name' => true,
                        'id' => true
                    ],
                    'option' => [
                        'value' => true,
                        'selected' => true
                    ]
                ] ); ?>

				<?php else : ?>

					<?php if ( current_user_can( 'publish_pages' ) ) : ?>

						<a href="<?php echo esc_url( add_query_arg( 'post_type', 'page', admin_url( 'post-new.php' ) ) ) ?>"><?php esc_html_e( 'Add New Page', 'amicable' ) ?></a>

					<?php endif ?>

				<?php endif ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'Select a page to display when users visit a 404 error on your site. Ensure the page is set to private so it does not appear on the front end.', 'amicable' ) ?>
		</p>

	<?php }

	/**
	 * Displays the emoji field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function fieldEmoji() { ?>

		<p>
			<label>
				<input type="checkbox" name="amicable_settings[disable_emoji]" value="true" <?php checked( Options::get( 'disable_emoji' ) ) ?> />
				<?php esc_html_e( 'Disable Emoji Scripts', 'amicable' ) ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'All modern browsers support emoji natively. Disabling emoji scripts removes the JavaScript loaded on every page of your site for a small percentage of users on outdated browsers.', 'amicable' ) ?>
		</p>

	<?php }

	/**
	 * Displays the toolbar field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function fieldToolbar() { ?>

		<p>
			<label>
				<input type="checkbox" name="amicable_settings[disable_toolbar]" value="true" <?php checked( Options::get( 'disable_toolbar' ) ) ?> />
				<?php esc_html_e( 'Disable Toolbar', 'amicable' ) ?>
			</label>
		</p>
		<p class="description">
			<?php esc_html_e( 'Disables the toolbar on the front end of the site, which loads additional JavaScript and CSS on every page load.', 'amicable' ) ?>
		</p>

	<?php }

	/**
	 * Displays the embeds field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function fieldEmbeds() {
		$label = is_classicpress() ? __( 'Disable ClassicPress Embeds', 'amicable' ) : __( 'Disable WordPress Embeds', 'amicable' );
		?>

		<p>
			<label>
				<input type="checkbox" name="amicable_settings[disable_wp_embed]" value="true" <?php checked( Options::get( 'disable_wp_embed' ) ) ?> />
				<?php echo esc_html( $label ); ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'Removes the JavaScript that allows other sites to embed your posts.', 'amicable' ) ?>
		</p>

	<?php }

	/**
	 * Renders the settings page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function template() { ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'amicable_settings' ); ?>
			<?php do_settings_sections( 'amicable_settings' ); ?>
			<?php submit_button( esc_attr__( 'Update Settings', 'amicable' ), 'primary' ); ?>
		</form>

	<?php }

	/**
	 * Displays the home posts number field.
	 *
	 * @since      1.0.0
	 * @deprecated 2.1.0
	 * @access     public
	 * @return     void
	 */
	public function fieldHomePostsNumber() {}

	/**
	 * Displays the archive posts number field.
	 *
	 * @since      1.0.0
	 * @deprecated 2.1.0
	 * @access     public
	 * @return     void
	 */
	public function fieldArchivePostsNumber() {}

}
