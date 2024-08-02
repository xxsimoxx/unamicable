<section id="content" class="site-content">
	<main id="main" class="content-area">
		<?php if ( have_posts() ) : ?>
			<?php while( have_posts() ) : the_post(); ?>
				<?php Backdrop\View\display( 'entry' ); ?>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php endif; ?>
	</main>
</section>
