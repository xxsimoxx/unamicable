<section id="content" class="site-content">
	<main id="main" class="content-area">
		<?php while( have_posts() ) : the_post(); ?>
			<?php Backdrop\View\display( 'entry/single' ); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
	</main>
	<?php Backdrop\View\display( 'sidebar', 'primary', [ 'location' => 'primary' ] ); ?>
</section>
