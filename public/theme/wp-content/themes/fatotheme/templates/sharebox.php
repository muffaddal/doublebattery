<?php
$full_image = '';
$fatotheme_theme_option = fatotheme_get_theme_option();
$post = fatotheme_get_post();
?>
<ul class="social-networks clearfix list-unstyled">
	<li class="facebook">
		<a class="tip-top" data-tip="<?php echo esc_attr('Facebook') ?>" href="javascript:void(0);" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p&#91;title&#93;=<?php the_title(); ?>&amp;p&#91;url&#93;=<?php echo esc_url(get_permalink( )); ?>')" target="_blank">
			<i class="fa fa-facebook"></i>
		</a>
	</li>
	<li class="twitter">
		<a class="tip-top" data-tip="<?php echo esc_attr('Twitter') ?>" onClick="window.open('http://twitter.com/home?status=<?php echo esc_html( get_the_title() ); ?><?php echo esc_url(get_the_permalink()); ?>')" href="javascript:void(0);" target="_blank">
			<i class="fa fa-twitter"></i>
		</a>
	</li>
	<li class="linkedin">
		<a class="tip-top" data-tip="<?php echo esc_attr('LinkedIn') ?>" href="javascript:void(0);" onClick="window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url(get_the_permalink()); ?>&amp;title=<?php echo esc_html( get_the_title() ); ?>')" target="_blank">
			<i class="fa fa-linkedin"></i>
		</a>
	</li>
	<li class="tumblr">
		<a class="tip-top" data-tip="<?php echo esc_attr('Tumblr') ?>" href="javascript:void(0);" onClick="window.open('http://www.tumblr.com/share/link?url=<?php echo esc_url(get_permalink()); ?>&amp;name=<?php echo esc_html($post->post_title); ?>&amp;description=<?php echo esc_url(get_the_excerpt()); ?>')" target="_blank">
			<i class="fa fa-tumblr"></i>
		</a>
	</li>
	<li class="google">
		<a class="tip-top" data-tip="<?php echo esc_attr('Google +1') ?>" href="javascript:void(0);" onClick="javascript:window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>',
'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
			<i class="fa fa-google-plus"></i>
		</a>
	</li>
	<li class="pinterest">
		<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
		<a href="tooltip(0);" class="tip-top" data-tip="<?php echo esc_attr('Pinterest') ?>" onClick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;description=<?php echo esc_html($post->post_title); ?>&amp;media=<?php echo esc_url($full_image[0]); ?>')" target="_blank">
			<i class="fa fa-pinterest"></i>
		</a>
	</li>
	<li class="email">
		<a class="tip-top" data-tip="<?php echo esc_attr('Email') ?>" onClick="javascript:window.location='mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>'" href="javascript:void(0);">
			<i class="fa fa-envelope"></i>
		</a>
	</li>
</ul>