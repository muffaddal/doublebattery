<?php
/*
*Template Name: Underconstruction
*
*/
$fatotheme_theme_option = fatotheme_get_theme_option();
$post = fatotheme_get_post();
get_header(); ?>
<div id="page-mainbody" class="page-underconstruction page-mainbody">
	<div class="container">
		<div class="text-center clearfix">
			<div class="logo-box">
                <div class="logo">
                    <?php do_action('fatotheme_set_logo'); ?>
                </div>
            </div>
			<h3><?php echo esc_html__('This is the site under construction','fatotheme') ?></h3>
			<h5><?php echo esc_html__('We are working one some improvements and will come back in','fatotheme'); ?></h5>
			<div class="col-sm-6 col-sm-offset-3 countdown-row">
				<div class="countdown-underconstruction">
					<?php if(strtotime($fatotheme_theme_option['underconstruction_time'])): ?>
						<span class="countdown" data-countdown="<?php echo esc_attr(date('M j Y H:i:s O',strtotime($fatotheme_theme_option['underconstruction_time']))); ?>"></span>
					<?php else: ?>
						<span><?php echo esc_html__('Please choose date!','fatotheme') ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="copyright clearfix">
	            <?php echo wp_kses_post($fatotheme_theme_option['footer-copyright']); ?>
	         </div>
		</div>
	</div>
</div>
<?php get_footer(); ?>