<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

$fatotheme_theme_option = fatotheme_get_theme_option();
if (!isset($fatotheme_archive_product_style) || empty($fatotheme_archive_product_style)) {
	if(!isset($_COOKIE['woo-shop-layout-switch'])) {
		$catalog_layout = $fatotheme_theme_option['woo-shop-layout-switch'];
	} else {
		$catalog_layout =  $_COOKIE['woo-shop-layout-switch'];
	}
} else {
	$catalog_layout = $fatotheme_archive_product_style;
}

$class[] = $catalog_layout;
$class_names = join(' ', $class);
?>

    <div class="products achive-product-layout <?php echo esc_attr($class_names); ?>" data-layout="<?php echo esc_attr($catalog_layout);?>">
        <div class="row">