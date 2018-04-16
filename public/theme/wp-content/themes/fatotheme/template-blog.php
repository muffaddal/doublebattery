<?php
/*
*Template Name: Blog
*
*/
// Meta Configuration
$fatotheme_theme_option = fatotheme_get_theme_option();
$post = fatotheme_get_post();
$post_id = $post->ID;
$post_per_page = get_post_meta( $post_id, '_fatotheme_blog_count', true );
$blog_skin = get_post_meta( $post_id, '_fatotheme_blog_skin', true );
$class_content_inner = $blog_js = '';
if($blog_skin=='mini'){
	add_filter( 'fatotheme_gallery_image_size' , create_function('', 'return "fatotheme-blog-mini";') );
	add_filter( 'fatotheme_single_image_size' , create_function('', 'return "fatotheme-blog-mini";') );
}else if( $blog_skin=='masonry' ){
	$masonry_column = get_post_meta( $post_id, '_fatotheme_blog_masonry_column_count', true );
	if($masonry_column>2){
		add_filter( 'fatotheme_gallery_image_size' , create_function('', 'return "fatotheme-blog-mini";') );
		add_filter( 'fatotheme_single_image_size' , create_function('', 'return "fatotheme-blog-mini";') );
	}
	add_filter( 'fatotheme_blog_masonry_column', create_function('', 'return '.$masonry_column.';') );
	$class_content_inner = ' masonry';
}

if(is_front_page()) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$args = array(
	'post_type' => 'post',
	'paged' => $paged,
	'posts_per_page'=>$post_per_page
);
$blog = new WP_Query($args);
$is_breadcrumb = get_post_meta( $post_id, '_fatotheme_show_page_header', true )?true:false;
$page_heading = $fatotheme_theme_option['page_title'] ? true : false;
$page_heading = $is_breadcrumb ? true : false;
?>
<?php get_header(); ?>
<div id="page-mainbody" class="page-mainbody">
	<?php get_template_part('page', 'head'); ?>
	<div class="container main-content-container<?php echo ($page_heading) ? '' : ' main-hasno-pagehead' ?>">
		<div class="row">
			<!-- MAIN CONTENT -->
			<div id="lane-main-content" class="lane-content clearfix <?php echo apply_filters( 'fatotheme_main_class', '' ); ?>">
				
				<div class="lane-blog<?php echo ($blog_skin=='masonry') ? '-isotope' : ''; ?> clearfix<?php echo esc_attr($class_content_inner); ?>">
					<?php if ( $blog->have_posts() ) : ?>
						<?php /* The loop */ ?>
						<?php while ( $blog->have_posts() ) : $blog->the_post(); ?>
							<?php get_template_part( 'templates/blog/blog', $blog_skin ); ?>
						<?php endwhile; ?>
					<?php else : ?>
						<?php get_template_part( 'templates/none' ); ?>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>
				<?php fatotheme_pagination($prev = '<i class="fa fa-angle-left"></i>', $next = '<i class="fa fa-angle-right"></i>', $pages=$blog->max_num_pages); ?>
			</div>
			<!-- //END MAINCONTENT -->
			<?php do_action('fatotheme_sidebar_render'); ?>

		</div>
	</div>
</div>
<?php get_footer(); ?>
