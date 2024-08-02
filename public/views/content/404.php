<section id="content" class="site-content clear">
	<main id="main" class="content-area">
		<?php
		use Amicable\Template\ErrorPage;
		$error = new ErrorPage(); // phpcs:ignore
		?>
		<?php $error->setup(); ?>
		<article id="post-0" class="page">
			<header class="entry-header">
				<h1 class="entry-title"><?php $error->displayTitle(); ?></h1>
			</header>
			<div class="entry-content">
				<?php $error->displayContent(); ?>
			</div>
		</article>
		<?php $error->reset(); ?>
	</main>
</section>
