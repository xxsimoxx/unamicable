<section id="content" class="site-content clear">
	<main id="main" class="content-area">
		<?php if ( have_posts() ) : ?>
			<div class="loop">
				<ul class="grid-items grid-col-3">
					<?php while( have_posts() ) : the_post(); ?>
						<?php Backdrop\View\display( 'entry/archive' ); ?>
					<?php endwhile; ?>
				</ul>
				<?php the_posts_pagination(); ?>
			</div>
		<?php endif; ?>
	</main>
</section>
