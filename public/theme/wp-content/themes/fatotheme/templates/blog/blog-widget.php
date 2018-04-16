<?php $fatotheme_theme_option = fatotheme_get_theme_option(); ?>
<div class="blog-post">
    <div class="post-thumb">
        <?php fatotheme_post_thumbnail('fatotheme-blog-widget'); ?>
    </div>
    <div class="post-inner">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <?php get_template_part( 'templates/single/meta' ); ?>
        <div class="post-content">
            <p class="post-text"><?php echo fatotheme_limit_get_excerpt($fatotheme_theme_option['blog-widget-limittext'],''); ?></p>
            <p class="p-readmore"><a class="post-readmore" href="<?php the_permalink(); ?>"><?php echo esc_html__('Continue Reading','fatotheme'); ?></a></p>
        </div>
    </div>
</div>

