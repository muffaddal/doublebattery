<?php if (!is_front_page()) : ?>
	<?php fatotheme_get_breadcrumb(); ?>
<?php else: ?>
	<ul class="breadcrumbs">
		<li><a rel="v:url" href="<?php echo esc_url( home_url('/') ); ?>" class="home"><?php esc_html_e('Home', 'fatotheme'); ?> </a></li>
		<li><span><?php esc_html_e('Blog', 'fatotheme'); ?></span></li>
	</ul>
<?php endif; ?>

