<?php
// Meta Configuration
$fatotheme_theme_option = fatotheme_get_theme_option();
$single_post_heading = $fatotheme_theme_option['single_page_header'] ? true : false;

get_header( ); ?>
<div id="page-mainbody" class="page-mainbody">
	<?php get_template_part('single', 'head'); ?>
	<div class="container main-content-container<?php echo ($single_post_heading) ? '' : ' main-hasno-pagehead' ?>">
		<div class="row">
			<!-- MAIN CONTENT -->
			<div id="lane-main-content" class="lane-content <?php echo apply_filters( 'fatotheme_main_class', '' ); ?>">
				<?php while ( have_posts() ) : the_post(); $post = fatotheme_get_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('single-container'); ?>>
		              	<?php $is_thumb = get_the_post_thumbnail() ? ' has-thumb' : ' no-thumb' ?>
		              	<div class="post-entry<?php echo esc_attr($is_thumb) ?>">
		              		<div class="entry-date">
								<span class="entry-day">
									<?php __esc_html( get_the_date( 'd' ) ) ?>
								</span>
								<span class="entry-month">
									<?php __esc_html( get_the_date( 'M' ) ) ?>
								</span>
							</div>
							<div class="post-image">
								<?php fatotheme_post_thumbnail('full'); ?>
							</div>
							<h1 class="post-title"><span><?php the_title(); ?></span></h1>
							<?php get_template_part( 'templates/single/meta' ); ?>
							<div class="post-content">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</div>
							<?php comments_template(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<!-- //MAIN CONTENT -->
			<?php do_action('fatotheme_sidebar_render'); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

