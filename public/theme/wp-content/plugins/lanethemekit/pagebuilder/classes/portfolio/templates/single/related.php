<?php
$args = array(
    'post__not_in' => array($post_id),
    'posts_per_page'   => 4,
    'orderby'			=> 'rand',
    'post_type'        => LANE_PORTFOLIO_POST_TYPE,
    'portfolio_category__in'    => $arrCatId,
    'post_status'      => 'publish'
);
$posts_array = new WP_Query( $args );
$image_size = 'thumbnail-500x600';
?>
<div class="portfolio-related portfolio-wrapper wplane-col-md-4 col-padding-15">
    <?php
    $index=0;
    while ( $posts_array->have_posts() ) : $posts_array->the_post();
        $index++;
        $overlay_style = 'icon';
        $column = 4;
        $terms = wp_get_post_terms( get_the_ID(), array( LANE_PORTFOLIO_CATEGORY_TAXONOMY));
        $permalink = get_permalink();
        $title_post = get_the_title();
        $cat = $cat_filter = '';
        foreach ( $terms as $term ){
            $cat .= $term->name.', ';
        }
        $cat = rtrim($cat,', ');
        ?>
        <?php include(LANE_PORTFOLIO_DIR_PATH.'/portfolio/templates/info-item.php'); ?>
    <?php
    endwhile;
    wp_reset_postdata();
    ?>
    <div style="clear: both"></div>
</div>
