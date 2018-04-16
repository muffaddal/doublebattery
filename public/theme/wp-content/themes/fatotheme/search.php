<?php get_header(); ?>
<div id="page-mainbody" class="page-mainbody">
    <div class="container main-content-container">
        <div class="row">
            <!-- MAIN CONTENT -->
            <div id="lane-main-content" class="lane-content clearfix <?php echo apply_filters( 'fatotheme_main_class', '' ); ?>">
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