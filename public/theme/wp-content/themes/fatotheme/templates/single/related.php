<?php
$tag_ids = array();
$tags = get_the_tags();
if(!$tags)
    return;
foreach ($tags as $key => $value) {
    $tag_ids[] = $value->term_id;
}

$args = array(
    'tag__in'=>$tag_ids,
    'posts_per_page'=>3,
    'post__not_in'=>array(get_the_ID()),
    'orderby' =>'rand',
);

$relates = new WP_Query( $args );
if($relates->have_posts()):
?>
<div class="related-post-content">
    <h4 class="heading">
        <span><?php esc_html_e('Related post','fatotheme')?></span>
    </h4>
    <div class="row related-post-inner">
        <?php while($relates->have_posts() ): $relates->the_post(); ?>
           <div class="col-md-4 col-sm-4">
                <?php if ( has_post_thumbnail() ) {?>
                <div class="post-thumb">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo fatotheme_post_thumbnail('fatotheme-blog-widget'); ?>
                    </a>
                </div>
                <?php } ?>
                <div class="post-content">
                    <h5 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h5>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>