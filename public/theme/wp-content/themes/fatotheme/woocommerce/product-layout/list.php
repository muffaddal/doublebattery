<div class="product-list <?php if($type) echo ($type); ?> <?php if($layout) echo ($layout); ?> <?php if($style) echo ($style); ?><?php if($hide_time_sale=='1') echo ' hide-time-sale'; ?>">
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<?php wc_get_template( 'content-widget-product.php', 
							array( 
								'show_rating' => $show_rating, 
								'show_category'=> true,
								'is_deals'=>$is_deals ) ); ?>
	<?php endwhile; ?>
</div>