<div class="portfolio-item <?php echo esc_attr($cat_filter) ?>">
    <?php
        $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
        $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, $image_size );
        $thumbnail_url = $arrImages[0];
        $arrImages = wp_get_attachment_image_src( $post_thumbnail_id,'full');
        $url_origin = $arrImages[0];
        $width = 480;
        $height = 300;
        include(plugin_dir_path( __FILE__ ).'/overlay/'.$overlay_style.'.php');
        $terms = wp_get_post_terms( get_the_ID(), array( LANE_PORTFOLIO_CATEGORY_TAXONOMY));
        $cat = $cat_filter = $term_link = '';
        foreach ( $terms as $term ){
            $cat_filter .= preg_replace('/\s+/', '', $term->name) .' ';
            $cat .= $term->name.', ';
            $term_link = get_term_link( $term );
            // If there was an error, continue to the next term.
            if ( is_wp_error( $term_link ) ) {
                continue;
            }
        }
        $cat = rtrim($cat,', ');
    ?>
    <div class="item-info">
    <div class="category"><a href="<?php echo esc_url( $term_link ) ?>"><?php echo wp_kses_post($cat) ?></a></div>
    <div class="post-title"><a href="<?php echo get_permalink(get_the_ID()) ?>"><?php echo get_the_title(); ?></a> </div>
    </div>

    <?php if($overlay_style=='icon-view' || $overlay_style=='icon'){ ?>
        <div style="display: none">
            <?php
            $meta_values = get_post_meta( get_the_ID(), 'portfolio-format-gallery', false );
            if(count($meta_values) > 0){
                foreach($meta_values as $image){
                    $urls = wp_get_attachment_image_src($image,'full');
                    $gallery_img = '';
                    if(count($urls)>0)
                        $gallery_img = $urls[0];
                    ?>
                    <div>
                        <a href="<?php echo esc_url($gallery_img) ?>" rel="prettyPhoto[pp_gal_<?php echo get_the_ID()?>]" title="<?php echo "<a href='".esc_url($permalink)."'>".esc_html($title_post)."</a>"?>"></a>
                    </div>
                <?php        }
            }
            ?>
        </div>
    <?php } ?>
</div>
<?php if($index%$column==0) {?>
    <div style="clear:both"></div>
<?php }?>