<?php
// Meta Configuration
$fatotheme_theme_option = fatotheme_get_theme_option();
$post = fatotheme_get_post();
$page_title_bg = $page_heading_img_url = '';
$post_id = $post->ID;
$opt_single_post_heading = $fatotheme_theme_option['single_page_header'] ? true : false;
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
$opt_page_title_url = $fatotheme_theme_option['page_title_bg']['url'];
$opt_page_title_style_bg = !empty($opt_page_title_url) ? (' style="background-image:url('.$opt_page_title_url.');"') : '';
//Page Title
$opt_page_title_align = $fatotheme_theme_option['page_title_align'] ? $fatotheme_theme_option['page_title_align'] : '';
//Page Breadcrumbs
$opt_page_breadcrumbs = $fatotheme_theme_option['page_breadcrumbs'] ? true : false;
$opt_breadcrumbs_align = $fatotheme_theme_option['page_breadcrumbs_align'] ? $fatotheme_theme_option['page_breadcrumbs_align'] : '';
if($opt_single_post_heading || $opt_page_breadcrumbs): ?>
<div class="page-head">
	<div class="container<?php echo esc_attr($page_title_fullwidth); ?>">
		<?php if($opt_single_post_heading || $opt_page_breadcrumbs): ?>
		<div class="page-title-container <?php echo esc_attr($opt_page_title_align) ?>"<?php echo wp_kses_post($opt_page_title_style_bg) ?>>
			<?php if($page_title): ?>
            <?php fatotheme_the_page_title(); ?>
            <?php endif; ?>
            <?php if($opt_page_breadcrumbs) : ?>
            <div class="page-breadcrumbs <?php echo esc_attr($opt_breadcrumbs_align); ?>">
                <?php fatotheme_the_breadcrumb(); ?>
            </div>
            <?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>