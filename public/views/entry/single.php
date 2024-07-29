<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-metadata">
			<?php Backdrop\Theme\Entry\display_date(); ?>
		</div>
		<?php Backdrop\Theme\Entry\display_title(); ?>
	</header>
	<?php if ( has_post_thumbnail() ) { ?>
		<figure class="post-thumbnail">
			<?php the_post_thumbnail( 'amicable-large-thumbnails' ); ?>
		</figure>
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
