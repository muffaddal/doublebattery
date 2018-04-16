<?php
$fatotheme_theme_option = fatotheme_get_theme_option();
get_header(); ?>
<div id="page-mainbody" class="page_not_found page-mainbody">
	<div class="container">
		<div class="text-center clearfix">
			<h1><?php __esc_html('404') ?></h1>
			<?php echo wp_kses_post($fatotheme_theme_option['404_text']); ?>
			<div class="button-return">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-default"><?php echo esc_html__('Homepage','fatotheme') ?></a>
				<a class="btn btn-default continue" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) );?>"><?php esc_html_e('Continue Shopping', 'woocommerce');?></a>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>