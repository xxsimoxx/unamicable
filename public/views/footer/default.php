<footer id="colophon" class="site-footer">
	<?php Backdrop\View\display( 'menu', 'social', [ 'location' => 'social' ] ); ?>
	<div class="site-info">
		<?php Amicable\Template\Footer::displayCredit() ?>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
