<div class="post-meta">
	<?php if(is_sticky()){ ?>
		<span class="sticky"><i class="fa fa-thumb-tack"></i><?php esc_html_e('Sticky','fatotheme'); ?></span>
	<?php } ?>
	<span class="published-date">
        <i class="fa fa-calendar" aria-hidden="true"></i>
        <a href="<?php the_permalink(); ?>">
            <span class="the-time"><?php the_time( 'd M, Y' ); ?></span>
        </a>
    </span>
	<span class="author"><?php esc_html_e('Posted by ','fatotheme');the_author_posts_link(); ?></span>
	<span class="category"><i class="fa fa-edit"></i><?php esc_html_e('in ','fatotheme');?><?php the_category( ', ' ); ?></span>
	<?php if (get_the_tags()) : ?>
	<span class="tag"><i class="fa fa-tags"></i><?php the_tags(); ?></span>
	<?php endif; ?>
	<span class="comment-count">
		<i class="fa fa-comments"></i>
		<?php comments_popup_link(esc_html__('Leave a comment', 'fatotheme'), esc_html__(' 1 comment', 'fatotheme'), esc_html__(' % comments', 'fatotheme')); ?>
	</span>
</div>