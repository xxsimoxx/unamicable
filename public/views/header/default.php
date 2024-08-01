<?php
/**
 * Default header template
 *
 * @package   Amicable
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2023. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/amicable
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="profile" href="https://gmpg.org/xfn/11" />
<?php wp_head(); ?>
</head>
<body <?php body_class( get_theme_mod('theme_global_layout', 'full') == 'full' ? 'layout-full' : 'layout-wide' ); ?>>
<?php wp_body_open(); ?>
<div id="container" class="site-container">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'amicable' ); ?></a>
	<header id="masthead" class="site-header">
		<div class="branding-navigation">
			<div class="site-branding">
				<?php Backdrop\Theme\Site\display_site_title(); ?>
				<?php
					$tagline = get_bloginfo( 'description' );

					if ( ! empty( $tagline ) ) {
						if ( $sep = Amicable\Tools\Mod::get( 'branding_sep' ) ) : ?>
							<span class="sep" aria-hidden="true"><?php echo esc_html( $sep ) ?></span>
						<?php endif;

						Backdrop\Theme\Site\display_site_description();
					}
				?>
			</div>
			<?php Backdrop\View\display( 'menu', 'primary', [ 'location' => 'primary'] ); ?>
		</div>
	</header>
