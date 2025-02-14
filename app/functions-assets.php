<?php
/**
 * Amicable ( functions-scripts.php )
 *
 * @package   Amicable
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2024 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/amicable
 */

/**
 * Define namespace
 */
namespace Amicable;

use function Backdrop\Mix\asset;

/**
 * Enqueue Scripts and Styles
 *
 * @since  1.0.0
 * @access public
 * @return void
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */
add_action( 'wp_enqueue_scripts', function() {

	// Rather than enqueue the main style.css stylesheet, we are going to enqueue screen.css.
	wp_enqueue_style( 'amicable-screen', asset( 'css/screen.css' ), null, null );

	// Enqueue theme scripts
	wp_enqueue_script( 'amicable-app', asset( 'js/app.js' ), [ 'jquery' ], null, true );

	// Enqueue Navigation.
	wp_enqueue_script( 'amicable-navigation', asset( 'js/navigation.js' ), null, null, true );
	wp_localize_script( 'amicable-navigation', 'amicableScreenReaderText', [
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'amicable' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'amicable' ) . '</span>',
	] );

	// Loads ClassicPress' comment-reply script where appropriate.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

add_action( 'wp_enqueue_scripts', function() {
	$global_layout = get_theme_mod( 'theme_global_layout', 'full' );

	$images = get_theme_mod( 'theme_content_feature_image', 'amicable-landscape-medium' );
	$custom_css = "
		.layout-wide .site-header .branding-navigation {
			margin: 0 auto;
			max-width: 1170px;
		}
	";

    switch ($images) {
        case 'amicable-landscape-medium':
            $custom_css = "
                .post-thumbnail .size-amicable-landscape-medium {
					border-radius: 0.5rem;
					box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
					display: block;
					margin: 1.125rem auto;
					max-width: 100%;
                }
            ";
            break;
        case 'amicable-landscape-large':
            $custom_css = "
                .post-thumbnail .size-amicable-landscape-large {
					border-radius: 0.5rem;
					box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
					display: block;
					margin: 1.125rem auto;
					max-width: 100%;
                }
            ";
            break;
        case 'amicable-landscape-extra-large':
            $custom_css = "
                .post-thumbnail .size-amicable-landscape-extra-large {
					border-radius: 0.5rem;
					box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
					display: block;
					margin: 1.125rem auto;
					max-width: 100%;
                }
            ";
            break;
        default:
            $custom_css = "
                .post-thumbnail .size-amicable-landscape-medium {
					border-radius: 0.5rem;
					box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
					display: block;
					margin: 1.125rem auto;
					max-width: 100%;
                }
            ";
            break;
    }

	wp_add_inline_style( 'amicable-screen', $custom_css );

} );
