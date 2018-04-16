<?php $infinite_id = rand(); ?>
<div class="row products-infinite shortcode_<?php echo esc_attr($infinite_id); ?>" data-cat-ids="<?php echo esc_attr($cat_ids) ?>" data-next-page="3" data-product-type="<?php echo esc_attr($type); ?>" data-post-per-page="<?php echo esc_attr($number_per_page); ?>" data-max-pages="<?php echo esc_attr($loop->max_num_pages); ?>" data-column-class="<?php echo esc_attr($class_column); ?>">
    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
        <div <?php post_class(esc_attr($class_column).' product-infinite product-grid clearfix') ?>>
            <?php 
                if(isset($is_deals) && $is_deals){
                    wc_get_template_part( 'content', 'product-deals' );
                }else{
                    wc_get_template_part( 'content', 'product-grid' );
                }
            ?>
        </div>
    <?php endwhile; ?>
</div>
<div class="load-more-infinite text-center">
    <?php if ($loop->max_num_pages > 1) {?>
        <div class="load-more-btn load-more <?php echo ($infinite_id); ?>" data-infinite="<?php echo ($infinite_id);?>"><span><?php esc_html_e('LOAD MORE','fatotheme'); ?></span><span class="load-more-icon fa fa-angle-double-down"></span></div>
    <?php } ?>
</div>
