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
		return __( 'General', 'amicable' );
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
		add_action( 'exhale/settings/admin/view/general/register', [ $this, 'registerDefaultSections' ] );
		add_action( 'exhale/settings/admin/view/general/register', [ $this, 'registerDefaultFields'   ] );
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
		do_action( 'exhale/settings/admin/view/general/register' );
	}

	/**
	 * Validates the settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validateSettings( $settings ) {

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

		$sections = [
			'reading' => [
				'label'    => __( 'Reading', 'amicable' ),
				'callback' => 'sectionReading'
			],
			'clean_wp' => [
				'label'    => __( 'Clean WordPress', 'amicable' ),
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
				'section'  => 'clean_wp',
			],
			'toolbar' => [
				'label'    => __( 'Toolbar', 'amicable' ),
				'callback' => 'fieldToolbar',
				'section'  => 'clean_wp'
			],
			'embeds' => [
				'label'    => __( 'Embeds', 'amicable' ),
				'callback' => 'fieldEmbeds',
				'section'  => 'clean_wp'
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
			<?php esc_html_e( 'Alter the output for specific views on the front end.', 'amicable' ) ?>
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
			'show_option_none'  => '-',
			'option_none_value' => 0,
			'selected'          => Options::get( 'error_page' ),
			'post_status'       => [ 'private' ],
			'echo'              => false
		] ); ?>

		<p>
			<label>
				<?php if ( $dropdown ) : ?>

					<?= $dropdown ?>

				<?php else : ?>

					<select name="amicable_settings[error_page]">
						<option value="0" selected="selected"><?php esc_html_e( 'No Private Pages', 'amicable' ) ?></option>
					</select>

					<?php if ( current_user_can( 'publish_pages' ) ) : ?>

						<a href="<?= esc_url( add_query_arg( 'post_type', 'page', admin_url( 'post-new.php' ) ) ) ?>"><?php esc_html_e( 'Add New Page', 'amicable' ) ?></a>

					<?php endif ?>

				<?php endif ?>
			</label>
		</p>

		<p class="description">
			<?php esc_html_e( 'Select a page to display when a user visits a 404 error page on your site. The page must be set to private so that it will not appear on the front end.', 'amicable' ) ?>
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
	public function fieldEmbeds() { ?>

		<p>
			<label>
				<input type="checkbox" name="amicable_settings[disable_wp_embed]" value="true" <?php checked( Options::get( 'disable_wp_embed' ) ) ?> />
				<?php esc_html_e( 'Disable WordPress Embeds', 'amicable' ) ?>
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
