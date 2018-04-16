<?php $fatotheme_theme_option = fatotheme_get_theme_option(); ?>
<article id="post-<?php the_ID(); ?>" <?php (is_sticky()) ? post_class('post-container post-sticky') : post_class('post-container post-list'); ?>>
    <div class="row">
        <div class="col-md-5">
            <?php $is_thumb = get_the_post_thumbnail() ? ' has-thumb' : ' no-thumb' ?>
            <div class="post-thumb<?php echo esc_attr($is_thumb) ?>">
                <?php fatotheme_post_thumbnail('fatotheme-blog-list'); ?>
                <div class="entry-date">
                    <span class="entry-day">
                        <?php __esc_html( get_the_date( 'd' ) ) ?>
                    </span>
                    <span class="entry-month">
                        <?php __esc_html( get_the_date( 'M' ) ) ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <h2 class="post-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
            <?php get_template_part( 'templates/single/meta' ); ?>
            <div class="post-content">
                <p class="post-text"><?php echo fatotheme_limit_get_excerpt($fatotheme_theme_option['blog-list-limittext'],''); ?></p>
                <a class="post-readmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Continue Reading','fatotheme'); ?></a>
            </div>
        </div>
    </div>
</article>
