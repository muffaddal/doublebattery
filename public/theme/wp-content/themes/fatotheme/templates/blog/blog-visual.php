<?php $fatotheme_theme_option = fatotheme_get_theme_option(); ?>
<div class="blog-post">
    <div class="row">
        <div class="col-md-6">
            <div class="post-thumb">
                <?php fatotheme_post_thumbnail('fatotheme-blog-list'); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="post-inner">
                <div class="meta">
                    <span class="published">
                        <a href="<?php the_permalink(); ?>">
                        <i class="fa fa-calendar"></i>
                        <?php the_time( 'M, d' ); ?>
                        </a>
                    </span>
                    <span class="author">
                        <?php esc_html__('By', 'fatotheme') ?>
                        <?php the_author_posts_link(); ?>
                    </span>
                    <span class="comment-count">
                        <i class="fa fa-comment"></i>
                        <?php comments_popup_link(esc_html__(' 0 comment', 'fatotheme'), esc_html__(' 1 comment', 'fatotheme'), esc_html__(' % comments', 'fatotheme')); ?>
                    </span>
                </div>
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="post-content">
                    <p class="post-text"><?php echo fatotheme_limit_get_excerpt($fatotheme_theme_option['blog-visual-limittext'],''); ?></p>
                    <a href="<?php the_permalink(); ?>" class="post-readmore"><?php echo esc_html__('Continue Reading','fatotheme'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

