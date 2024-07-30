<?php
/**
 * Theme mods settings Config.
 *
 * Defines the default theme mods for the theme. Child themes can overwrite this
 * with a `config/settings-mod.php` file for changing the defaults.
 *
 * Configs are loaded early in the load process. If a default value requires PHP
 * code to execute, use a closure. It will be invoked at an appropriate time when
 * all functions/variables are set up and available for use.
 *
 * @package   Amicable
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2024 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/amicable
 */

use function Backdrop\Theme\is_classicpress;

return [

	# ----------------------------------------------------------------------
	# Header.
	# ----------------------------------------------------------------------
	#
	# Handles various header mods.

	'theme_header_custom_logo' => false,

	// Branding separator (see `config/character-entities.php` for options).
	'branding_sep' => '&#183;',


	# ----------------------------------------------------------------------
	# Footer.
	# ----------------------------------------------------------------------
	#
	# Handles various footer mods.

	// Whether to show a random powered by quote by default. If set to `false`,
	// the `footer_credit` value will be used.
	'theme_footer_powered_by' => false,

	// Default footer credit text.
	'theme_footer_custom_credit' => function() {
		if ( is_classicpress() ) {
            return sprintf( __( 'Powered by %s.', 'amicable' ), Backdrop\Theme\Site\render_cp_link() );
        } else {
            return sprintf( __( 'Powered by %s.', 'amicable' ), Backdrop\Theme\Site\render_wp_link() );
        }
	},
];
