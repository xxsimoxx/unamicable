<?php

namespace Amicable\Customize\FeatureImage;
use Amicable\Customize\Customizable;
use WP_Customize_Manager;
use Amicable\Tools\Collection;
use Amicable\Tools\Config;
use Amicable\Tools\Mod;

class Customize extends Customizable {

	/**
	 * Registers customizer sections.
	 *
	 * @since  2.1.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerSections( WP_Customize_Manager $manager ) {

	}

	/**
	 * Registers customizer settings.
	 *
	 * @since  2.1.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerSettings( WP_Customize_Manager $manager ) {

        // Add a setting for the feature image size.
        $manager->add_setting( 'theme_content_feature_image', array(
        'default'   => Mod::fallback( 'featured_image_size' ),
        ) );
	}

	/**
	 * Registers customizer controls.
	 *
	 * @since  2.1.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerControls( WP_Customize_Manager $manager ) {

           // Prepare choices array.
    $choices = Config::get( 'image-sizes' );
    foreach ( $choices as $size_name => $size_attrs ) {
        $choices[ $size_name ] = $size_attrs['label'];
    }

            // Add a control for the feature image size.
    $manager->add_control( 'theme_content_feature_image', array(
        'label'    => __( 'Feature Image Size', 'amicable' ),
        'section'  => 'theme_content_feature_image',
        'settings' => 'theme_content_feature_image',
        'type'     => 'select',
        'choices'  => $choices,
    ) );
	}

	/**
	 * Registers customizer partials.
	 *
	 * @since  2.1.0
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerPartials( WP_Customize_Manager $manager ) {

	}

	/**
	* Registers JSON for the customize controls script via `wp_localize_script()`.
	*
	* @since  2.1.0
	* @access public
	* @param  Collection  $json
	* @return void
	*/
	public function controlsJson( Collection $json ) {

	}

	/**
	* Registers JSON for the customize preview script via `wp_localize_script()`.
	*
	* @since  2.1.0
	* @access public
	* @param  Collection  $json
	* @return void
	*/
	public function previewJson( Collection $json ) {

	}
}
