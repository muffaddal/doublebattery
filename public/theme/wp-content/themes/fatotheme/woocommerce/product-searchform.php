<?php
/**
 * Product-SearchForm
 *
 * Shows product searchform
 *
 * @author 		WooThemes
 * @package 	WooCommerce
 * @version     2.5.0
 */
?>
<form data-role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="input-group">
		<input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php echo esc_html__( 'Search for products', 'woocommerce' ); ?>" />
		<span class="input-group-btn">
			<input type="submit" class="btn btn-primary" id="searchsubmit" value="<?php echo esc_html__( 'Search', 'woocommerce' ); ?>" />
		</span>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>