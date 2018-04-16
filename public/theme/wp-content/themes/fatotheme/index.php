<?php 
$fatotheme_theme_option = fatotheme_get_theme_option();
$post = fatotheme_get_post();
$post_id = $post->ID;
$page_heading = $fatotheme_theme_option['page_title'] ? true : false;
?>
<?php get_header(); ?>
<div id="page-mainbody" class="page-mainbody">
    <?php get_template_part('index', 'head'); ?>
    <div class="container main-content-container<?php echo ($page_heading) ? '' : ' main-hasno-pagehead' ?>">
        <div class="row">
            <!-- MAIN CONTENT -->
            <div id="lane-main-content" class="lane-content <?php echo apply_filters( 'fatotheme_main_class', '' ); ?>">
                <div class="lane-content-inner clearfix">
                <?php  if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'templates/blog/blog'); ?>
                        <?php endwhile; ?>
                <?php else : ?>
                    <?php get_template_part( 'templates/none' ); ?>
                <?php endif; ?>
                </div>
                <?php fatotheme_pagination($prev = '<i class="fa fa-angle-left"></i>', $next = '<i class="fa fa-angle-right"></i>'); ?>
            </div>
            <!-- //END MAINCONTENT -->
            <?php do_action('fatotheme_sidebar_render'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>