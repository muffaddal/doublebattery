<?php get_header(); ?>
<?php get_template_part('single', 'head'); ?>
<?php
if ( have_posts() ) {
    // Start the Loop.
    while ( have_posts() ) : the_post();
        $post_id = get_the_ID();
        $categories = get_the_terms($post_id, LANE_PORTFOLIO_CATEGORY_TAXONOMY);

        $meta_values = get_post_meta( get_the_ID(), 'portfolio-format-gallery', false );
        $imgThumbs = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $cat = '';
        $arrCatId = array();
        if($categories){
            foreach($categories as $category) {
                $cat .= '<span><a href="'. get_term_link( $category, LANE_PORTFOLIO_CATEGORY_TAXONOMY ) .'">'.$category->name.'</a></span>, ';
                $arrCatId[count($arrCatId)] = $category->term_id;
            }
            $cat = trim($cat, ', ');
        }
        $image_size = 'thumbnail-1170x730'; // image size for related
        include_once(plugin_dir_path( __FILE__ ).'/bigslider.php');

    endwhile;
    }
?>
<script type="text/javascript">
    <!--
    (function($) {
        "use strict";
        $(document).ready(function(){
            $("a[rel^='prettyPhoto']").prettyPhoto(
                {
                    theme: 'light_rounded',
                    slideshow: 5000,
                    deeplinking: false,
                    social_tools: false
                });
            $('.portfolio-item > div.entry-thumbnail').hoverdir();
        })


        $(window).load(function(){
            $(".post-slideshow",'#portfolio-content').owlCarousel({
                items: 1,
                singleItem: true,
                navigation : true,
                navigationText: ['<span class="fa fa-angle-left"></span>','<span class="fa fa-angle-right"></span>'],
                pagination: false
            });
        })
    })(jQuery);
    -->
</script>
<?php get_footer(); ?>
