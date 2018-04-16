<div class="page-found clearfix">
	<h2 class="entry-title"><?php echo esc_html__( 'Nothing Found', 'fatotheme' ); ?></h2>
</div>
<article class="wrapper">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php echo esc_html__( 'Ready to publish your first post?', 'fatotheme' ); ?> <a href="<?php echo esc_url(admin_url( 'post-new.php' ) ); ?>">Get started here</a></p>

	<?php elseif ( is_search() ) : ?>

		<p><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'fatotheme' ); ?></p>
	<?php get_search_form(); ?>

	<?php else : ?>

		<p><?php echo esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fatotheme' ); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</article>