<?php
$fatotheme_theme_option = fatotheme_get_theme_option();
$product = fatotheme_get_product();
$post = fatotheme_get_post();
$woocommerce_loop = fatotheme_get_woocommerce_loop();
if($post!=null) {
    if( $post->post_type=='product' ) {
      $post_id = get_option( 'woocommerce_shop_page_id' );
    } else {
      $post_id = $post->ID;
    }
}
if($post!=null) {
    $meta_page_title = (get_post_meta( intval($post_id), '_fatotheme_show_page_title', true )=='yes')?true:false;
}
$page_title = $fatotheme_theme_option['page_title'] ? true : false;
$meta_page_title_fullwidth = get_post_meta( $post_id, '_fatotheme_page_title_fullwidth', true );
$opt_page_title_fullwidth = $fatotheme_theme_option['page_title_fullwidth'] ? true : false;
$page_title_fullwidth = '';
if($opt_page_title_fullwidth){
    switch ($meta_page_title_fullwidth) {
        case 'inherit':
            $page_title_fullwidth = '-fluid';
            break;
        case 'fullwidth':
            $page_title_fullwidth = '-fluid';
            break;
        case 'no-fullwidth':
            $page_title_fullwidth = '';
            break;
        default:
            $page_title_fullwidth = '-fluid';
            break;
    }
}else{
    switch ($meta_page_title_fullwidth) {
        case 'inherit':
            $page_title_fullwidth = '';
            break;
        case 'fullwidth':
            $page_title_fullwidth = '-fluid';
            break;
        case 'no-fullwidth':
            $page_title_fullwidth = '';
            break;
        default:
            $page_title_fullwidth = '';
            break;
    }
}
if($post!=null) {
    $page_title = $meta_page_title ? true : false;
}
$opt_page_title_url = $fatotheme_theme_option['page_title_bg']['url'];
if($post!=null) {
    $meta_page_title_img_url = get_post_meta( intval($post_id), '_fatotheme_page_title_bg', true );
}
$opt_page_title_bg_url = !empty($meta_page_title_img_url) ? $meta_page_title_img_url : $opt_page_title_url;
$opt_page_title_style_bg = !empty($opt_page_title_bg_url) ? (' style="background-image:url('.$opt_page_title_bg_url.');"') : '';
//Page Title
$opt_page_title_align = $fatotheme_theme_option['page_title_align'] ? $fatotheme_theme_option['page_title_align'] : '';
//Page Breadcrumbs
$meta_show_breadcrumbs = (get_post_meta( intval($post_id), '_fatotheme_show_breadcrumbs', true )=='yes')?true:false;
$opt_page_breadcrumbs = $fatotheme_theme_option['page_breadcrumbs'] ? true : false;
$page_breadcrumbs = ($meta_show_breadcrumbs) ? $opt_page_breadcrumbs : $meta_show_breadcrumbs;
$opt_breadcrumbs_align = $fatotheme_theme_option['page_breadcrumbs_align'] ? $fatotheme_theme_option['page_breadcrumbs_align'] : '';

if($page_title || $page_breadcrumbs): ?>
<div class="page-head">
    <div class="container<?php echo esc_attr($page_title_fullwidth); ?>">
        <?php if($page_title || $page_breadcrumbs): ?>
        <div class="page-title-container <?php echo esc_attr($opt_page_title_align) ?>"<?php echo wp_kses_post($opt_page_title_style_bg) ?>>
            <?php if($page_title): ?>
            <?php fatotheme_the_page_title(); ?>
            <?php endif; ?>
            <?php if($page_breadcrumbs) : ?>
            <div class="page-breadcrumbs <?php echo esc_attr($opt_breadcrumbs_align); ?>">
                <?php fatotheme_the_breadcrumb(); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>