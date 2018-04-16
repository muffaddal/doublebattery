<?php
/*
*Template Name: Visual Composer Template
*
*/
?>
<?php get_header(); ?>
<div id="page-mainbody" class="page-mainbody visual-composer">
	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="lane-content" <?php post_class( 'lane-content visual-layout' ); ?>>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>