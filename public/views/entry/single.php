<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-metadata">
			<?php Backdrop\Theme\Entry\display_date(); ?>
		</div>
		<?php Backdrop\Theme\Entry\display_title(); ?>
	</header>
	<?php if ( has_post_thumbnail() ) { ?>
		<picture class="post-thumbnail">
			<?php
				$size = get_theme_mod( 'theme_content_feature_image', 'amicable-landscape-medium' ) ? get_theme_mod( 'theme_content_feature_image' ) : Mod::fallback( 'featured_image_size' );
				the_post_thumbnail( $size );
			?>
		</picture>
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php Backdrop\View\display( 'nav/pagination', 'post' ); ?>
	</div>
	<footer class="entry-footer">
	<?php Backdrop\Theme\Entry\display_terms( [
			// Translators: %s is the category list.
			'text'     => __( 'Topics: %s', 'amicable' ),
			'taxonomy' => 'category'
		] ) ?>
		<?php Backdrop\Theme\Entry\display_terms( [
			// Translators: %s is the post tags list.
			'text'     => __( 'Tagged %s', 'amicable' ),
			'taxonomy' => 'post_tag'
		] ) ?>
	</footer>
</article>
