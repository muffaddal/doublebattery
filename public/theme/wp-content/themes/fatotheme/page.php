<?php
// Meta Configuration
$fatotheme_theme_option = fatotheme_get_theme_option();
$post = fatotheme_get_post();
$post_id = $post->ID;
$is_breadcrumb = get_post_meta( $post_id, '_fatotheme_show_page_header', true )?true:false;
$mainbody_topsidebar = get_post_meta( $post_id, '_fatotheme_mainbody_topsidebar', true )?true:false;
$mainbody_bottomsidebar = get_post_meta( $post_id, '_fatotheme_mainbody_bottomsidebar', true )?true:false;
$page_heading = $fatotheme_theme_option['page_title'] ? true : false;
$page_heading = $is_breadcrumb ? true : false;
$layout = get_post_meta( $post_id, '_fatotheme_page_layout', true );

get_header( ); ?>

<div id="page-mainbody" class="page-mainbody">
	<?php get_template_part('page', 'head'); ?>
	<?php do_action('sidebar_mainbody_topsidebar_render') ?>
	<div class="<?php echo ($layout=='1') ? 'main-container' : 'container' ?> main-content-container<?php echo ($page_heading) ? '' : ' main-hasno-pagehead' ?>">
		<div class="row">
			<!-- MAIN CONTENT -->
			<div id="lane-main-content" class="lane-content <?php echo apply_filters( 'fatotheme_main_class', '' ); ?>">
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('lane-content'); ?>>
						<?php the_content(); ?>
					</div><!-- #post -->
				<?php endwhile; ?>
				<?php comments_template(); ?>
			</div>
			<?php do_action('fatotheme_sidebar_render'); ?>
		</div>
	</div>
	<?php do_action('sidebar_mainbody_bottomsidebar_render') ?>
</div>
<?php get_footer(); ?>