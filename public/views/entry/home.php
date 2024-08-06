<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php Backdrop\Theme\Entry\display_title(); ?>
	</header>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
</article>