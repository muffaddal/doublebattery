<?php
/*==========================================================================
Function global variable
==========================================================================*/
if (!function_exists('fatotheme_get_theme_option')) 
{
    function fatotheme_get_theme_option()
    {
        global $fatotheme_theme_option;
        
        return $fatotheme_theme_option;
    }
}
if (!function_exists('fatotheme_get_post')) 
{
    function fatotheme_get_post()
    {
        global $post;
        
        return $post;
    }
}
if (!function_exists('fatotheme_get_woocommerce')) 
{
    function fatotheme_get_woocommerce()
    {
        global $woocommerce;
        
        return $woocommerce;
    }
}
if (!function_exists('fatotheme_get_woocommerce_loop')) 
{
    function fatotheme_get_woocommerce_loop()
    {
        global $woocommerce_loop;
        
        return $woocommerce_loop;
    }
}
if (!function_exists('fatotheme_get_product')) 
{
    function fatotheme_get_product()
    {
        global $product;
        
        return $product;
    }
}
if (!function_exists('fatotheme_get_yith_wcwl')) 
{
    function fatotheme_get_yith_wcwl()
    {
        global $yith_wcwl;
        
        return $yith_wcwl;
    }
}
if (!function_exists('fatotheme_get_wp_query')) 
{
    function fatotheme_get_wp_query()
    {
        global $wp_query;
        
        return $wp_query;
    }
}
if (!function_exists('fatotheme_get_is_IE')) 
{
    function fatotheme_get_is_IE()
    {
        global $is_IE;
        
        return $is_IE;
    }
}
if ( ! function_exists( '__esc_attr' ) ) {
    function __esc_attr() {
        echo call_user_func_array( 'esc_attr', func_get_args() );
    }
}



if ( ! function_exists( '__esc_html' ) ) {
    function __esc_html() {
        echo call_user_func_array( 'esc_html', func_get_args() );
    }
}

if ( ! function_exists( '__esc_url' ) ) {
    function __esc_url() {
        echo call_user_func_array( 'esc_url', func_get_args() );
    }
}
/*==========================================================================
Theme Logo
==========================================================================*/
function fatotheme_set_logo_func()
{
    global $fatotheme_theme_option, $wp_query;
    $logo_link = get_post_meta( $wp_query->get_queried_object_id() , '_fatotheme_logo_override' , true );
    if($logo_link==''){
        $logo_link = $fatotheme_theme_option['logo_image']['url'];
    }
?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <?php if($fatotheme_theme_option['logo_type']=='image') : ?>
        <img src="<?php echo esc_url($logo_link); ?>" alt="<?php bloginfo( 'name' ); ?>">
        <?php elseif($fatotheme_theme_option['logo_text']==''): ?>
        <h1 class="default-bloginfo"><?php bloginfo( 'name' ); ?></h1>
        <?php else: ?>
        <?php echo wp_kses_post($fatotheme_theme_option['logo_text']); ?>
        <?php endif; ?>
    </a>
<?php
}
add_action('fatotheme_set_logo','fatotheme_set_logo_func');

/*==========================================================================
Page Title
==========================================================================*/
if (!function_exists('fatotheme_the_page_title')) :
    function fatotheme_the_page_title()
    {
        get_template_part('templates/pagetitle');
    }
endif;

/*==========================================================================
Breadcrumb
==========================================================================*/
if (!function_exists('fatotheme_the_breadcrumb')) :
    function fatotheme_the_breadcrumb()
    {
        get_template_part('templates/breadcrumb');
    }
endif;

/*==========================================================================
Post View
==========================================================================*/
add_action('wp_head', 'fatotheme_themekit_setpostviews' );
function fatotheme_themekit_setpostviews() 
{
    global $fatotheme_theme_option, $post;
    if('post' == get_post_type() && is_single()) {
        $postID = $post->ID;
        if(!empty($postID)) {
            $count_key = 'fatotheme_post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    }
}

/*==========================================================================
Render Sidebar
==========================================================================*/
function fatotheme_layout_config_sidebar()
{ 
    global $fatotheme_theme_option, $hidden_xs, $hidden_sm;

    $hidden_sm = ($fatotheme_theme_option['sidebar-on-tablet']==0) ? ' hidden-sm' : '';
    $hidden_xs = ($fatotheme_theme_option['sidebar-on-mobile']==0) ? ' hidden-xs' : '';

    if(apply_filters( 'fatotheme_is_sidebar_left' , false )){ ?>
        <div class="sidebar sidebar-left <?php echo apply_filters( 'fatotheme_sidebar_left_class', 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9' ); ?><?php echo esc_attr($hidden_sm . $hidden_xs); ?>" role="complementary">
            <?php $leftsidebar = apply_filters( 'fatotheme_sidebar_left', '' ); ?>
            <?php if(is_active_sidebar($leftsidebar)): ?>
                <?php dynamic_sidebar($leftsidebar); ?>
            <?php endif; ?>
        </div>
    <?php } ?>

    <?php if(apply_filters( 'fatotheme_is_sidebar_right' , false )){ ?>
        <div class="sidebar sidebar-right <?php echo apply_filters( 'fatotheme_sidebar_right_class', 'col-sm-4 col-md-3' ); ?><?php echo esc_attr($hidden_sm . $hidden_xs); ?>" role="complementary">
            <?php $rightsidebar = apply_filters( 'fatotheme_sidebar_right' , '' ); ?>
            <?php if(is_active_sidebar($rightsidebar)): ?>
                <?php dynamic_sidebar($rightsidebar); ?>
            <?php endif; ?>
        </div>
    <?php } 
}
add_action('fatotheme_sidebar_render','fatotheme_layout_config_sidebar');

/*==========================================================================
Layout Config
==========================================================================*/
function fatotheme_layout_config()
{
    global $fatotheme_theme_option, $wp_query, $meta_boxes, $page_configs;
    $layout = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $layout = $fatotheme_theme_option['woo-shop-layout'];
    }else if( function_exists('is_product') && is_product()){
        $layout = $fatotheme_theme_option['woo-single-layout'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $layout = get_post_meta( $page_id, '_fatotheme_page_layout', true );
    }else{
        $layout = $fatotheme_theme_option['blog-layout'];
    }
    if (isset($_GET['layout'])) {
        $layout = $_GET['layout'];
    }

    add_filter( 'fatotheme_sidebar_right' , 'fatotheme_set_sidebar_right' );
    add_filter( 'fatotheme_sidebar_left' , 'fatotheme_set_sidebar_left' );

    switch ($layout) {
        // Two Sidebar
        case '4':
            add_filter( 'fatotheme_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'fatotheme_sidebar_right_class' , create_function('', 'return "col-sm-6  col-md-3";') );
            add_filter( 'fatotheme_main_class' , create_function('', 'return "col-md-6 col-md-push-3 lane-main-two-sidebar";') );
            add_filter( 'fatotheme_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'fatotheme_is_sidebar_right', create_function('', 'return true;') );
            break;
        //One Sidebar Right
        case '3':
            add_filter( 'fatotheme_sidebar_right_class' , create_function('', 'return "col-md-3 lane-main-right";') );
            add_filter( 'fatotheme_main_class' , create_function('', 'return "col-md-9 lane-main-right-sidebar";') );
            add_filter( 'fatotheme_is_sidebar_right', create_function('', 'return true;') );
            break;
        // One Sidebar Left
        case '2':
            add_filter( 'fatotheme_sidebar_left_class' , create_function('', 'return "col-md-3 col-md-pull-9 lane-main-left";') );
            add_filter( 'fatotheme_main_class' , create_function('', 'return "col-md-9 col-md-push-3 lane-main-left-sidebar";') );
            add_filter( 'fatotheme_is_sidebar_left', create_function('', 'return true;') );
            break;

        case '6':
            add_filter( 'fatotheme_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3";') );
            add_filter( 'fatotheme_sidebar_right_class' , create_function('', 'return "col-sm-6 col-md-3";') );
            add_filter( 'fatotheme_main_class' , create_function('', 'return " col-md-6";') );
            add_filter( 'fatotheme_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'fatotheme_is_sidebar_right', create_function('', 'return true;') );
            break;

        case '5':
            add_filter( 'fatotheme_sidebar_left_class' , create_function('', 'return "col-md-3 col-md-pull-6 lane-main-left-left";') );
            add_filter( 'fatotheme_sidebar_right_class' , create_function('', 'return "col-md-3 col-md-pull-6 lane-main-right-right";') );
            add_filter( 'fatotheme_main_class' , create_function('', 'return "col-md-6 col-md-push-6 lane-main-left-right";') );
            add_filter( 'fatotheme_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'fatotheme_is_sidebar_right', create_function('', 'return true;') );
            break;

        // Fullwidth
        default:
            add_filter( 'fatotheme_main_class' , create_function('', 'return "col-xs-12 lane-main-no-sidebar";') );
            add_filter( 'fatotheme_is_sidebar_left', create_function('', 'return false;') );
            add_filter( 'fatotheme_is_sidebar_right', create_function('', 'return false;') );
            break;
    }
}
add_action('wp_head','fatotheme_layout_config');

/*==========================================================================
Layout Sidebar
==========================================================================*/
function fatotheme_set_sidebar_right()
{
    global $fatotheme_theme_option, $wp_query;
    $sidebar = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $sidebar = $fatotheme_theme_option['woo-shop-sidebar'];
    }elseif(function_exists('is_product') && is_product()){
        $sidebar = $fatotheme_theme_option['woo-single-sidebar'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $sidebar = get_post_meta( $page_id, '_fatotheme_page_right_sidebar', true );
    }else{
        $sidebar = $fatotheme_theme_option['blog-right-sidebar'];
    }
    return $sidebar;
}

function fatotheme_set_sidebar_left()
{
    global $fatotheme_theme_option, $wp_query;
    $sidebar = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $sidebar = $fatotheme_theme_option['woo-shop-sidebar'];
    }elseif(function_exists('is_product') && is_product()){
        $sidebar = $fatotheme_theme_option['woo-single-sidebar'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $sidebar = get_post_meta( $page_id, '_fatotheme_page_left_sidebar', true );
    }else{
        $sidebar = $fatotheme_theme_option['blog-left-sidebar'];
    }
    return $sidebar;
}

/*==========================================================================
Extended Sidebars
==========================================================================*/
// Mainbody bottom sidebar
function fatotheme_set_sidebar_mainbody_topsidebar()
{
    global $fatotheme_theme_option, $wp_query;
    $sidebar = '';
    $page_id = $wp_query->get_queried_object_id();
    $sidebar = get_post_meta( $page_id, '_fatotheme_mainbody_topsidebar', true );
    return $sidebar;
}
// Mainbody top sidebar render
function fatotheme_set_sidebar_mainbody_topsidebar_render()
{ 
    global $fatotheme_theme_option;
    add_filter( 'sidebar_mainbody_topsidebar' , 'fatotheme_set_sidebar_mainbody_topsidebar' );

    $maintopsidebar = apply_filters( 'sidebar_mainbody_topsidebar', '' );
    if(is_active_sidebar($maintopsidebar)): ?>
    <div class="mainbody-top">
        <?php dynamic_sidebar($maintopsidebar); ?>
    </div>
    <?php endif;
}
add_action('sidebar_mainbody_topsidebar_render','fatotheme_set_sidebar_mainbody_topsidebar_render');

// Mainbody bottom sidebar
function fatotheme_set_sidebar_mainbody_bottomsidebar()
{
    global $fatotheme_theme_option, $wp_query;
    $sidebar = '';
    $page_id = $wp_query->get_queried_object_id();
    $sidebar = get_post_meta( $page_id, '_fatotheme_mainbody_bottomsidebar', true );
    return $sidebar;
}
// Mainbody bottom sidebar render
function fatotheme_set_sidebar_mainbody_bottomsidebar_render()
{ 
    global $fatotheme_theme_option;
    add_filter( 'sidebar_mainbody_bottomsidebar' , 'fatotheme_set_sidebar_mainbody_bottomsidebar' );

    $mainbottomsidebar = apply_filters( 'sidebar_mainbody_bottomsidebar', '' );
    if(is_active_sidebar($mainbottomsidebar)): ?>
    <div class="mainbody-bottom">
        <?php dynamic_sidebar($mainbottomsidebar); ?>
    </div>
    <?php endif;
}
add_action('sidebar_mainbody_bottomsidebar_render','fatotheme_set_sidebar_mainbody_bottomsidebar_render');

/*==========================================================================
Enable Effect Scroll
==========================================================================*/
if(isset($fatotheme_theme_option['is-effect-scroll']) && $fatotheme_theme_option['is-effect-scroll'] ):
add_filter('body_class','fatotheme_enable_effect_scroll');
function fatotheme_enable_effect_scroll($classes)
{
    $classes[] = 'lane-animate-scroll';
    return $classes;
}
endif;

/*==========================================================================
Back To Top
==========================================================================*/
if(isset($fatotheme_theme_option['is-back-to-top']) && $fatotheme_theme_option['is-back-to-top'] ):
add_filter('fatotheme_after_wrapper','fatotheme_back_to_top_button');
function fatotheme_back_to_top_button()
{
?>
    <a class="scroll-to-top visible" href="#" id="scrollToTop">
        <i class="zmdi zmdi-long-arrow-up"></i>
    </a>
<?php
}
endif;

/*==========================================================================
Fix Vimeo
==========================================================================*/
add_action('init','fatotheme_themekit_add_vimeo_oembed_correctly');
function fatotheme_themekit_add_vimeo_oembed_correctly() 
{
    wp_oembed_add_provider( '#http://(www\.)?vimeo\.com/.*#i', 'http://vimeo.com/api/oembed.{format}', true );
}

/*==========================================================================
Fix Embed
==========================================================================*/
add_filter( 'oembed_result', 'fatotheme_themekit_fix_oembeb' );
function fatotheme_themekit_fix_oembeb( $url )
{
    $array = array (
        'webkitallowfullscreen'     => '',
        'mozallowfullscreen'        => '',
        'frameborder="0"'           => '',
        '</iframe>)'        => '</iframe>'
    );
    $url = strtr( $url, $array );

    if ( strpos( $url, "<embed src=" ) !== false ){
        return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $url);
    }
    elseif ( strpos ( $url, 'feature=oembed' ) !== false ){
        return str_replace( 'feature=oembed', esc_url('feature=oembed&wmode=opaque'), $url );
    }
    else{
        return $url;
    }
}

/*==========================================================================
Search Filter
==========================================================================*/
add_filter('pre_get_posts','fatotheme_themekit_search_filter');
function fatotheme_themekit_search_filter($query) 
{
    if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
        $query->is_search = true;
        $query->is_home = false;
    }
	return $query;
}

/*==========================================================================
Remove Dimension Image
==========================================================================*/
add_filter( 'post_thumbnail_html', 'fatotheme_themekit_remove_thumbnail_dimensions' , 10, 3 );
function fatotheme_themekit_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) 
{
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

/*==========================================================================
Set Custom CSS/JS
==========================================================================*/
function fatotheme_hex2rgb($hex) 
{
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(',', $rgb); // returns an array with the rgb values
}

function fatotheme_rgb2hex($rgb) 
{
    $rgb = explode(',', $rgb);
    $hex = "#";
    $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

    return $hex; 
}

function fatotheme_adjustColorLightenDarken($color_code,$percentage_adjuster = 0) 
{
    $percentage_adjuster = round($percentage_adjuster/100,2);
    if(is_array($color_code)) {
        $r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
        $g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
        $b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);

        return array("r"=> round(max(0,min(255,$r))),
            "g"=> round(max(0,min(255,$g))),
            "b"=> round(max(0,min(255,$b))));
    }
    else if(preg_match("/#/",$color_code)) {
        $hex = str_replace("#","",$color_code);
        $r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
        $g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
        $b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
        $r = round($r - ($r*$percentage_adjuster));
        $g = round($g - ($g*$percentage_adjuster));
        $b = round($b - ($b*$percentage_adjuster));

        return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);

    }
}

add_action('wp_head','fatotheme_themekit_custom_style_css',98);
function fatotheme_themekit_custom_style_css()
{
    global $fatotheme_theme_option;
    echo '<style type="text/css" id="lanetheme-option-color-style">';
        get_template_part( 'assets/css/color' );
        $logo_height = (int) $fatotheme_theme_option['logo_height'];
        $logo_sticky_height = (int) $fatotheme_theme_option['logo_sticky_height'];
        if ( $logo_height > 0 ) {
            echo 'header.page-header .mainheader .logo-box .logo img{';
            echo 'height:' .
            sprintf( '%dpx', $logo_height );
            echo '}';
        }
        if ( $logo_sticky_height > 0 ) {
            echo 'header.page-header.header-sticky .mainheader .logo-box .logo img{';
            echo 'height:' .
            sprintf( '%dpx', $logo_sticky_height );
            echo '}';
        }
    echo '</style>';
}

add_action('wp_head','fatotheme_themekit_init_custom_code',100);
function fatotheme_themekit_init_custom_code()
{
	global $fatotheme_theme_option;
    if ( ! empty( $fatotheme_theme_option['custom-css'] ) ){
        printf( '<style type="text/css">%s</style>', $fatotheme_theme_option['custom-css'] );
    }
    if ( ! empty( $fatotheme_theme_option['custom-js'] ) ){
        printf( '<script type="text/javascript">%s</script>', $fatotheme_theme_option['custom-js'] );
    }
}

/*==========================================================================
Add Scripts Admin
==========================================================================*/
add_filter( 'body_class','fatotheme_themekit_style_layout' );
function fatotheme_themekit_style_layout($classes)
{
    global $fatotheme_theme_option, $wp_query, $post;
    $pageid = $wp_query->get_queried_object_id(); 
    $header_style = get_post_meta( $pageid, '_fatotheme_header_style', true );
    $header_absolute = get_post_meta( $pageid, '_fatotheme_header_absolute', true );
    $page_layout_meta = get_post_meta( $pageid, '_fatotheme_page_layout_style', true );
    $meta_page_title = (get_post_meta( $pageid, '_fatotheme_show_page_title', true )=='yes')?true:false;
    $meta_show_breadcrumbs = (get_post_meta( $pageid, '_fatotheme_show_breadcrumbs', true )=='yes')?true:false;
    $opt_page_breadcrumbs = $fatotheme_theme_option['page_breadcrumbs'] ? true : false;
    if (class_exists('WooCommerce') && isset($post) && ($post->post_type=='product')) {
        $post_id = get_option( 'woocommerce_shop_page_id' );
        $meta_page_title = (get_post_meta( intval($post_id), '_fatotheme_show_page_title', true )=='yes')?true:false;
        $meta_show_breadcrumbs = (get_post_meta( intval($post_id), '_fatotheme_show_breadcrumbs', true )=='yes')?true:false;
    } else {
        $meta_page_title = $fatotheme_theme_option['page_title'] ? true : false;
        $opt_page_breadcrumbs = $fatotheme_theme_option['page_breadcrumbs'] ? true : false;
    }
    $page_breadcrumbs = ($meta_show_breadcrumbs) ? $opt_page_breadcrumbs : $meta_show_breadcrumbs;
    $page_layout_opt = $fatotheme_theme_option['style_layout'];

    if($header_style){
        $classes[] = 'style-'. $header_style;
    }
    if(isset($page_layout_meta) && $page_layout_meta=='boxed'){
        $classes[] = 'boxed';
    } else if((isset($page_layout_meta) && $page_layout_meta=='inherit') && (isset($page_layout_opt) && $page_layout_opt=='boxed')){
        $classes[] = 'boxed';
    } else if(isset($page_layout_meta) && $page_layout_meta=='fullwidth'){
        $classes[] = '';
    }else if(($page_layout_meta==false) && isset($page_layout_opt) && $page_layout_opt=='boxed'){
        $classes[] = 'boxed';
    }
    if(isset($fatotheme_theme_option['promo_popup']) && $fatotheme_theme_option['promo_popup'] == true){
        $classes[] = 'visible-popup';
    }
    if(isset($fatotheme_theme_option['header_is_sticky']) && $fatotheme_theme_option['header_is_sticky']=='1'){
        $classes[] = 'header-sticky';
    }else{
        $classes[] = 'header-no-sticky';
    }
    if(isset($fatotheme_theme_option['header_absolute']) && $fatotheme_theme_option['header_absolute']==true && $header_absolute=='yes'){
        $classes[] = 'header-absolute';
    }else if(isset($fatotheme_theme_option['header_absolute']) && $fatotheme_theme_option['header_absolute']==false && $header_absolute=='yes'){
        $page_layout_class = 'page-header-absolute';
    }
    $classes[] = ($meta_page_title==false && $page_breadcrumbs==false) ? 'page-hide-title' : '';
    
    return $classes;
}

if (!function_exists('fatotheme_header_layout'))
{
    function fatotheme_header_layout($template){
        global $fatotheme_theme_option, $wp_query, $post;
        $opt = $fatotheme_theme_option['header'];
        $header = get_post_meta( $wp_query->get_queried_object_id(), '_fatotheme_header_style',true );

        if ( is_page() )
        {
            if ($header!='global' && $header!='') 
            {
                $template = $header;
            }
            else if( ($header=='global' && isset($opt) && $opt!='' && $opt!='global') || ($header=='' && isset($opt) && $opt!='' && $opt!='global') )
            {
                $template = get_template_part('templates/header/header',$opt);
            }
        } 
        else
        {   
            if(class_exists('WooCommerce') && isset($post) && ($post->post_type=='product'))
            {
                $post_id = get_option( 'woocommerce_shop_page_id' );
                $shop_header = get_post_meta( intval($post_id), '_fatotheme_header_style',true );
                if($post_id=='' && !isset($opt))
                {
                    $template = get_template_part('templates/header/header','global');
                }
                else if($post_id=='' && isset($opt)){
                    $template = get_template_part('templates/header/header',$opt);
                }
                else if($shop_header && $shop_header!='global')
                {
                    $template = $shop_header;
                }
                else if($shop_header=='global' && isset($opt) && $opt!='' && $opt!='global')
                {
                    $template = get_template_part('templates/header/header',$opt);
                }
                else
                {
                    $template = get_template_part('templates/header/header','global');
                }
            }
            else if ( (isset($opt) && $opt='') || !isset($opt) ) 
            {
                $template = get_template_part('templates/header/header','global');
            }
            else if( isset($opt) && $opt=!'' && $opt!='global' )
            {
                $template = get_template_part('templates/header/header',$opt);
            }
        }

        return $template;
    }
    add_filter( 'header_layout', 'fatotheme_header_layout',100 );
}

/*==========================================================================
Footer Layout
==========================================================================*/
add_action( 'fatotheme_footer_layout_style', 'fatotheme_func_footer_layout_style' );
function fatotheme_func_footer_layout_style()
{
    global $fatotheme_theme_option, $wp_query;
    $pageid = $wp_query->get_queried_object_id();

    $footer_id = @get_post_meta( $pageid , '_fatotheme_footer_style' , true );

    if($footer_id=='' || $footer_id=='global'){
        if( $fatotheme_theme_option['is-footer-custom'] == '1' ){
            if(isset($fatotheme_theme_option['footer_id'])){
                $footer_id = @$fatotheme_theme_option['footer_id'];
            }
            if ($footer_id =='') {
                get_template_part( 'templates/footer/default' );
                return;
            }
        }else{
            get_template_part( 'templates/footer/default' );
            return;
        }
    }
    if($footer_id){
        echo '<div class="footer-visual-composer clear-footer">';
        echo  do_shortcode(get_post( $footer_id )->post_content ) ;
        echo '</div>';
    }
}

/*==========================================================================
Comments List
==========================================================================*/
if (!function_exists('fatotheme_render_comments')) {
    function fatotheme_render_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">

            <?php echo get_avatar($comment, $args['avatar_size']); ?>
            <div class="comment-text">
                <div class="comment-meta">
                    <span class="author-name"><?php printf(esc_html__('Article by %s', 'fatotheme'), get_comment_author_link()) ?></span>
                    <span class="comment-meta-date">
                        <?php echo get_comment_date(get_option('date_format')); ?>
                    </span>
                    <?php edit_comment_link(esc_html__('Edit', 'fatotheme'), '<span class="comment-meta-edit"><i class="fa fa-edit"></i>', '</span>') ?>
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
                <div class="text"><?php comment_text() ?></div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php esc_html_e('Your comment is awaiting moderation.', 'fatotheme') ?></em>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }
}

/*==========================================================================
Comments Form
==========================================================================*/
if (!function_exists('fatotheme_comment_form')) :
    function fatotheme_comment_form()
    {
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true'" : '');
        $html5 = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';;

        $fields = array(

            'author' => '<div>' .
                '<label for="author">'.esc_html__("Name *","fatotheme").'</label>'.
                '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . '>' .
                '</div>',

            'email' => '<div>' .
                '<label for="email">'.esc_html__("Email *","fatotheme").'</label>'.
                '<input id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . '>' .
                '</div>',
            'url'   => '<div>'.
                '<label for="url">'.esc_html__("Website","fatotheme").'</label>'.
                '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" />'.
                '</div>'
        );

        $comment_form_args = array(
            'fields' => $fields,
            'comment_field' => '<div>' .
                '<label for="comment">'.esc_html__("Content *","fatotheme").'</label>'.
                '<textarea rows="6" id="comment" name="comment"  value="' . esc_attr($commenter['comment_author_url']) . '" '. $aria_req .'></textarea>' .
                '</div>',


            'comment_notes_before' => '<p class="comment-notes">' .
                esc_html__('Your email address will not be published.', 'fatotheme') /* . ( $req ? $required_text : '' ) */ .
                '</p>',
            'comment_notes_after' => '',
            'id_submit' => 'btnComment',
            'class_submit' => 'button-comment',
            'title_reply' => esc_html__('Leave a Comment', 'fatotheme'),
            'title_reply_to' => esc_html__('Leave a Comment to %s', 'fatotheme'),
            'cancel_reply_link' => esc_html__('Cancel reply', 'fatotheme'),
            'label_submit' => esc_html__('Send Messages', 'fatotheme')
        );
        comment_form($comment_form_args);
    }
endif;

function fatotheme_comment_form($arg,$class='btn-primary',$id='submit')
{
	ob_start();
	comment_form($arg);
	$form = ob_get_clean();
	echo str_replace('id="submit"','id="'.$id.'" class="btn '.$class.'"', $form);
}

function fatotheme_get_post_views($postID)
{
    $count_key = 'fatotheme_';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}

function fatotheme_share_box( $layout='',$args=array() )
{
	$default = array(
		'position' => 'top',
		'animation' => 'true'
		);
	$args = wp_parse_args( (array) $args, $default );
}

function fatotheme_embed() 
{
    $link = get_post_meta(get_the_ID(),'_fatotheme_post_video',true);
    echo  wp_oembed_get($link);
}

function fatotheme_gallery($size='full')
{
    $output = array();
    $galleries = get_post_gallery( get_the_ID(), false );
    if(isset($galleries['ids'])){
        $img_ids = explode(",",$galleries['ids']);
        foreach ($img_ids as $key => $id){
            $img_src = wp_get_attachment_image_src($id,$size);
            $output[] = $img_src[0];
        }
    }
    return $output;
}

//page navegation
function fatotheme_pagination($prev = 'Prev', $next = 'Next', $pages='' ,$args=array('class'=>'')) 
{
    global $fatotheme_theme_option, $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    if($pages==''){
        global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
    }
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $pages,
        'current' => $current,
        'prev_text' => $prev,
        'next_text' => $next,
        'type' => 'array'
    );
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
    if(paginate_links( $pagination )!=''){
        $paginations = paginate_links( $pagination );
        echo '<nav class="paging paging-bottom">';
        echo '<ul class="pagination '.$args["class"].'">';
            foreach ($paginations as $key => $pg) {
                echo '<li>'.$pg.'</li>';
            }
        echo '</ul>';
        echo '</nav>';
    }
}

/*==========================================================================
Function Define
==========================================================================*/
function fatotheme_getAgo($timestamp)
{
    // return $timestamp;
    $timestamp = strtotime($timestamp);
    $difference = time() - $timestamp;

    if ($difference < 60) {
        return $difference.esc_html__(" seconds ago",'fatotheme');
    } else {
        $difference = round($difference / 60);
    }

    if ($difference < 60) {
        return $difference.esc_html__(" minutes ago",'fatotheme');
    } else {
        $difference = round($difference / 60);
    }

    if ($difference < 24) {
        return $difference.esc_html__(" hours ago",'fatotheme');
    }
    else {
        $difference = round($difference / 24);
    }

    if ($difference < 7) {
        return $difference.esc_html__(" days ago",'fatotheme');
    } else {
        $difference = round($difference / 7);
        return $difference.esc_html__(" weeks ago",'fatotheme');
    }
}

function fatotheme_limit_get_excerpt($limit,$afterlimit='[...]') 
{
    $excerpt = get_the_excerpt();
    if($excerpt != ''){
       $excerpt = explode(' ', strip_tags($excerpt), $limit);
    }else{
        $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
    }
    if (count($excerpt)>=$limit) {
        array_pop($excerpt); 
        $excerpt = implode(" ",$excerpt).' '.$afterlimit;
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    if ($afterlimit == '') {
        $excerpt = preg_replace('([?:[!]+|&hellip;])',' ',$excerpt);
    } else {
        $excerpt = trim(preg_replace('([?:[!]+|&hellip;])',' ',$excerpt)).''.$afterlimit;
    }
    return strip_shortcodes( $excerpt );
}

function fatotheme_make_id($length = 5)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function fatotheme_string_limit_words($string, $word_limit)
{
    $words = explode(' ', $string, ($word_limit + 1));

    if(count($words) > $word_limit) {
        array_pop($words);
    }

    return implode(' ', $words);
}

/**
 * Add paramater to current url
 * @param  string $url         URL to add param to
 * @param  string $param_name  Param name
 * @param  string $param_value Param value
 * @return array               params added to url data
 */
if ( ! function_exists( 'fatotheme_add_url_parameter' ) ) {
    function fatotheme_add_url_parameter( $url, $param_name, $param_value ) {
         $url_data = parse_url($url);
         if (!isset($url_data["query"]))
             $url_data["query"]="";

         $params = array();
         parse_str($url_data['query'], $params);

         if ( is_array( $param_value ) ) {
            $param_value = $param_value[0];
         }

         $params[$param_name] = $param_value;

         if ( $param_name == 'page_size' ) {
            $params['paged'] = '1';
         }

         $url_data['query'] = http_build_query($params);
         return fatotheme_build_url($url_data);
    }
}

/**
 * Build final URL form $url_data returned from fatotheme_add_url_paramtere
 *
 * @param  array $url_data  url data with custom params
 * @return string           fully formed url with custom params
 */
if ( ! function_exists( 'fatotheme_build_url' ) ) {
    function fatotheme_build_url( $url_data ) {
        $url = '';
        if ( isset( $url_data['host'] ) ) {
            $url .= $url_data['scheme'] . '://';
            if ( isset ( $url_data['user'] ) ) {
                $url .= $url_data['user'];
                if ( isset( $url_data['pass'] ) ) {
                    $url .= ':' . $url_data['pass'];
                }
                $url .= '@';
            }
            $url .= $url_data['host'];
            if ( isset ( $url_data['port'] ) ) {
                $url .= ':' . $url_data['port'];
            }
        }

        if ( isset( $url_data['path'] ) ) {
            $url .= $url_data['path'];
        }

        if ( isset( $url_data['query'] ) ) {
            $url .= '?' . $url_data['query'];
        }

        if ( isset( $url_data['fragment'] ) ) {
            $url .= '#' . $url_data['fragment'];
        }

        return $url;
    }
}

/**
 * Get theme option value
 * @param  string $theme_option ID of theme option
 * @return string               Value of theme option
 */
if ( ! function_exists( 'fatotheme_get_theme_option' ) ) {
    function fatotheme_get_theme_option() {

        global $fatotheme_theme_option;
        
        $theme_option = object;

        if ( $fatotheme_theme_option && null !== $fatotheme_theme_option ) {
            foreach ($fatotheme_theme_option as $key=>$option) {
                $theme_option->{$key} = $option;
            }
            
            return $theme_option;
        }

        return FALSE;
    }
}
