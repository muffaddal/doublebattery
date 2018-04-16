<?php
/*==========================================================================
Setup Theme
==========================================================================*/
function fatotheme_theme_setup(){
    load_theme_textdomain( 'fatotheme', get_template_directory() .'/languages' );
    register_nav_menus( array(
        'mainmenu'   => esc_html__( 'Main Menu', 'fatotheme' ),
        'footer-menu' => esc_html__('Copyright Menu', 'fatotheme'),
        'category-menu'   => esc_html__( 'Category Menu', 'fatotheme' )
    ) );
    
    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-formats', array(
       'image', 'video', 'audio', 'gallery', 'status'
    ) );
    add_theme_support( "post-thumbnails" );
    add_image_size('fatotheme-blog-masonry',570,355,true);
    add_image_size('fatotheme-blog-mini',400,400,true);
    add_image_size('fatotheme-blog-list',374,237,true);
    add_image_size('fatotheme-blog-widget',370,273,true);

    if ( ! isset( $content_width ) ) $content_width = 900;
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background' );
    add_theme_support( "title-tag" );
}
add_action( 'after_setup_theme', 'fatotheme_theme_setup' );

/*==========================================================================
Switch Themes
==========================================================================*/
function fatotheme_theme_activation($oldname, $oldtheme=false) 
{
    admin_url();
}
add_action("after_switch_theme", "fatotheme_theme_activation", 10, 2);

/*==========================================================================
Header Sticky
==========================================================================*/
add_action( 'wp_footer', 'fatotheme_init_header_sticky' );
function fatotheme_init_header_sticky()
{
    global $fatotheme_theme_option, $woocommerce;
    $login_url = esc_url(wp_login_url('/'));
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    if ( $myaccount_page_id ) {
        $login_url = esc_url(get_permalink( $myaccount_page_id ));
        if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ) {
            $login_url = str_replace( 'http:', 'https:', $login_url );
        }
    }
    if(!$fatotheme_theme_option['header_is_sticky']) return;
    ?>
    <script type="text/javascript">
        <!--
        ( function( $ ) {
            "use strict";

            var $win = $(window), $doc = $(document), $body = $('body');
            
            $.headerSticky = function() {
                $win.on( 'scroll load', function() {
                    $win.scrollTop() > $( '.page-header' ).outerHeight()
                        ? $( '.page-header' ).addClass( 'header-sticky' )
                        : $( '.page-header' ).removeClass( 'header-sticky' );
                } );
            };
            $(function() {
                // Initialize the header sticky
                $.headerSticky();
            });
        } ).call( this, jQuery )
        -->
    </script>
<?php
}

/*==========================================================================
Style Switcher
==========================================================================*/
function fatotheme_style_switcher() 
{ ?>
    <div class="style-switcher hidden-xs hidden-sm hidden-md">
        <div class="stoggler"><i class="fa fa-cog fa-spin"></i></div>
        <div class="spanel">
            <h2><?php __esc_html('Style Switcher') ?></h2>
            <form name="styleswitcher" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                <div class="layout">
                    <select name="slayout" class="slayout">
                        <option value=""><?php __esc_html('-Select-') ?></option>
                        <option value="full"><?php __esc_html('Full Width') ?></option>
                        <option value="box"><?php __esc_html('Box') ?></option>
                    </select>
                </div>
                <div class="switcher-color">
                    <h3><?php __esc_html('Color Style') ?></h3>
                    <div class="color color-1" data-style="<?php echo get_template_directory_uri().'/assets/css/color/color-1.css';?>"><i class="fa fa-check"></i></div>
                    <div class="color color-2" data-style="<?php echo get_template_directory_uri().'/assets/css/color/color-2.css';?>"><i class="fa fa-check"></i></div>
                    <div class="color color-3" data-style="<?php echo get_template_directory_uri().'/assets/css/color/color-3.css';?>"><i class="fa fa-check"></i></div>
                    <div class="color color-4" data-style="<?php echo get_template_directory_uri().'/assets/css/color/color-4.css';?>"><i class="fa fa-check"></i></div>
                    <div class="color color-5" data-style="<?php echo get_template_directory_uri().'/assets/css/color/color-5.css';?>"><i class="fa fa-check"></i></div>
                    <div class="color color-6" data-style="<?php echo get_template_directory_uri().'/assets/css/color/color-6.css';?>"><i class="fa fa-check"></i></div>
                </div>
                <div class="bg-color">
                    <h3><?php __esc_html('Background Color') ?></h3>
                    <ul id="bgsolid" class="colors bgsolid">
                        <li><a title="Green" class="green-bg" href="#"></a></li>
                        <li><a title="Blue" class="blue-bg" href="#"></a></li>
                        <li><a title="Orange" class="orange-bg" href="#"></a></li>
                        <li><a title="Navy" class="navy-bg" href="#"></a></li>
                        <li><a title="Yellow" class="yellow-bg" href="#"></a></li>
                        <li><a title="Peach" class="peach-bg" href="#"></a></li>
                        <li><a title="Beige" class="beige-bg" href="#"></a></li>
                        <li><a title="Purple" class="purple-bg" href="#"></a></li>
                        <li><a title="Red" class="red-bg" href="#"></a></li>
                        <li><a title="Pink" class="pink-bg" href="#"></a></li>
                        <li><a title="Celadon" class="celadon-bg" href="#"></a></li>
                        <li><a title="Brown" class="brown-bg" href="#"></a></li>
                        <li><a title="Cherry" class="cherry-bg" href="#"></a></li>
                        <li><a title="Cyan" class="cyan-bg" href="#"></a></li>
                        <li><a title="Gray" class="gray-bg" href="#"></a></li>
                        <li><a title="Dark" class="dark-bg" href="#"></a></li>
                    </ul>
                </div>
                <div class="bg-image">
                    <h3><?php __esc_html('Background Image') ?></h3>
                    <ul id="bg" class="colors bg">
                        <li><a class="bg0" href="#"></a></li>
                        <li><a class="bg1" href="#"></a></li>
                        <li><a class="bg2" href="#"></a></li>
                        <li><a class="bg3" href="#"></a></li>
                        <li><a class="bg4" href="#"></a></li>
                        <li><a class="bg5" href="#"></a></li>
                        <li><a class="bg6" href="#"></a></li>
                        <li><a class="bg7" href="#"></a></li>
                        <li><a class="bg8" href="#"></a></li>
                        <li><a class="bg9" href="#"></a></li>
                        <li><a class="bg10" href="#"></a></li>
                        <li><a class="bg11" href="#"></a></li>
                        <li><a class="bg12" href="#"></a></li>
                        <li><a class="bg13" href="#"></a></li>
                        <li><a class="bg14" href="#"></a></li>
                        <li><a class="bg15" href="#"></a></li>
                        <li><a class="bg16" href="#"></a></li>
                        <li><a class="bg17" href="#"></a></li>
                        <li><a class="bg18" href="#"></a></li>
                        <li><a class="bg19" href="#"></a></li>
                        <li><a class="bg20" href="#"></a></li>
                        <li><a class="bg21" href="#"></a></li>
                        <li><a class="bg22" href="#"></a></li>
                        <li><a class="bg23" href="#"></a></li>
                        <li><a class="bg24" href="#"></a></li>
                        <li><a class="bg25" href="#"></a></li>
                        <li><a class="bg26" href="#"></a></li>
                        <li><a class="bg27" href="#"></a></li>
                        <li><a class="bg28" href="#"></a></li>
                        <li><a class="bg29" href="#"></a></li>
                        <li><a class="bg30" href="#"></a></li>
                    </ul>
                </div>
                <button type="button" id="resetpreview" class="btn btn-primary"><?php __esc_html('Reset') ?></button>
            </form>
        </div>
    </div>
<?php   
}
$fatotheme_theme_option = fatotheme_get_theme_option();
if (isset($fatotheme_theme_option['enable_sswitcher']) && $fatotheme_theme_option['enable_sswitcher']=='1') {
    add_action('wp_footer', 'fatotheme_style_switcher');
}

/*==========================================================================
Add admin style
==========================================================================*/
function fatotheme_custom_style() {
    wp_enqueue_style('fatotheme-admin-main-styles' , get_template_directory_uri().'/admin/assets/css/main.css');
}
add_action('admin_head', 'fatotheme_custom_style');

/*==========================================================================
Register Google Fonts
==========================================================================*/
function fatotheme_gfonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'fatotheme' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Poppins|Playfair Display' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}
/*
Enqueue scripts and styles.
*/
function fatotheme_gfonts_scripts() {
    wp_enqueue_style( 'fatotheme-gfonts', fatotheme_gfonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'fatotheme_gfonts_scripts' );

/*==========================================================================
Single Post
==========================================================================*/
add_action('fatotheme_post_before_content','fatotheme_set_post_thumbnail',10);
add_action('fatotheme_post_after_content','fatotheme_single_sharebox',10);
add_action('fatotheme_post_after_content','fatotheme_single_related_post',15);
add_action('fatotheme_post_after_content','fatotheme_single_author_bio',20);
function fatotheme_set_post_thumbnail()
{
    global $fatotheme_theme_option, $post;
    $postid = $post->ID;
    $link_embed = get_post_meta($postid,'_fatotheme_post_video',true);
    $gallery = get_post_meta( $postid,'_fatotheme_post_gallery', true );
    $status = get_post_meta( $postid, '_fatotheme_post_status' , true );
    $is_thumb = false;
    $content = $output = $start = $end = '';
    
    if( has_post_format( 'video' ) && $link_embed!='' ){
        $content ='<div class="video-responsive">'.wp_oembed_get($link_embed).'</div>';
        $is_thumb = true;
    }else if ( has_post_format( 'audio' ) ){
        $content ='<div class="audio-responsive">'.wp_oembed_get($link_embed).'</div>';
        $is_thumb = true;
    }else if ( has_post_format( 'gallery' ) && $gallery != '' ){
        $count = 0;
        $content =  '<div id="post-slide-'.$postid.'" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">';
        foreach ($gallery as $key => $id){
            $img_src = wp_get_attachment_image_src($key, apply_filters( 'fatotheme_gallery_image_size','full' ));
            $content.='<div class="item '.(($count==0)?'active':'').'">
                        <img src="'.$img_src[0].'">
                    </div>';
            $count++;
        }
        $content.='</div>
            <a class="carousel-control left" href="#post-slide-'.esc_attr($postid).'" data-slide="prev"><i class="fa fa-angle-left"></i></a>
            <a class="carousel-control right" href="#post-slide-'.esc_attr($postid).'" data-slide="next"><i class="fa fa-angle-right"></i></a>
        </div>';
        $is_thumb = true;
    }else if( has_post_format( 'status' ) && $status != '' ){
        $content ='<div class="status-responsive">'.$status.'</div>';
        $is_thumb = true;
    }else if( has_post_thumbnail() ){
        $content = get_the_post_thumbnail( $postid, apply_filters( 'fatotheme_single_image_size','full' ) );
        $is_thumb = true;
    } else {
        $content = '<img src="'.get_template_directory_uri() . '/assets/images/no-image-1280x800.jpg" alt="no-image" />';
        $is_thumb = true;
    }

    if( $is_thumb ){
        $start = '<div class="post-thumb">';
        $end = '</div>';
    }

    $output = $start.$content.$end;
    
    echo !empty( $output ) ? $output : '';
}

/*==========================================================================
Get Post Thumbnail
==========================================================================*/
if (!function_exists('fatotheme_post_thumbnail')) :
    function fatotheme_post_thumbnail($size)
    {
        global $fatotheme_theme_option, $post;
        $postid = $post->ID;
        $link_embed = get_post_meta($postid,'_fatotheme_post_video',true);
        $status = get_post_meta( $postid, '_fatotheme_post_status' , true );
        $gallery = get_post_meta( $postid,'_fatotheme_post_gallery', true );
        $html = $post_format = '';
        $post_format = get_post_format() ? : 'standard';
        switch ($post_format) {
            case 'image':
                $args = array(
                    'size' => $size,
                    'format' => 'src',
                    'meta_key' => 'post-format-image'
                );
                $image = fatotheme_get_image($args);
                $html = fatotheme_get_image_hover($image, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                break;
            case 'gallery':
                $data_plugin_options = "data-plugin-options='{\"items\" : 1, \"singleItem\" : true, \"pagination\" : false, \"navigation\" : true, \"autoHeight\" : true}'";
                $html = '<div class="owl-carousel" '.$data_plugin_options.'>';
                $args = array(
                    'size' => $size,
                    'format' => 'src',
                    'meta_key' => ''
                );
                $image = fatotheme_get_image($args);
                if (!$image) break;
                $html .= fatotheme_get_image_hover($image, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                if($gallery) {
                    foreach ($gallery as $id=>$image) {
                        $src = wp_get_attachment_image_src($id, $size);
                        $image = $src[0];
                        $html .= fatotheme_get_image_hover($image, get_permalink(), the_title_attribute('echo=0'),get_the_ID(),1);
                    }
                }
                $html .= '</div>';
                break;
            case 'video':
                if ($link_embed!='' && filter_var($link_embed, FILTER_VALIDATE_URL)) {
                    $html .= '<div class="video-responsive embed-responsive embed-responsive-' . $size . '">';
                    $html .= wp_oembed_get($link_embed);
                    $html .= '</div>';
                }
                break;
            case 'audio':
                if ($link_embed!='' && filter_var($link_embed, FILTER_VALIDATE_URL)) {
                    $html .= '<div class="audio-responsive embed-responsive embed-responsive-' . $size . '">';
                    $html .= wp_oembed_get($link_embed);
                    $html .= '</div>';
                }
                break;
            case 'status':
                if($status!=''){
                    $html .='<div class="status-responsive">'.$status.'</div>';
                } else {
                    $args = array(
                        'size' => $size,
                        'format' => 'src',
                        'meta_key' => 'post-format-image'
                    );
                    $image = fatotheme_get_image($args);
                    $html = fatotheme_get_image_hover($image, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                }
                break;
            default:
                $args = array(
                    'size' => $size,
                    'format' => 'src',
                    'meta_key' => ''
                );
                $image = fatotheme_get_image($args);
                $html = fatotheme_get_image_hover($image, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                break;
        }
        echo !empty( $html ) ? $html : '';
    }
endif;

/*==========================================================================
Get Image Hover prettyPhoto
==========================================================================*/
if (!function_exists('fatotheme_get_image_hover')) :
    function fatotheme_get_image_hover($image, $url, $title, $post_id,$gallery = 0)
    {
        global $fatotheme_theme_option, $post;
        $postid = $post->ID;

        $attachment_id = fatotheme_get_attachment_id_from_url($image);

        $image_full_arr = wp_get_attachment_image_src($attachment_id,'full');

        $image_full = $image;

        if (isset($image_full_arr)) {
            $image_full = $image_full_arr[0];
        }

        $prettyPhoto='prettyPhoto[blog_'.$postid.']';

        if (!$image_full){
            return;
        } else {

            return sprintf('<div class="entry-thumbnail">
                            <a href="%1$s" title="%2$s" class="entry-thumbnail_overlay">
                                <img class="img-responsive" src="%3$s" alt="%2$s"/>
                            </a>
                            <a data-rel="%5$s" href="%4$s" class="image-zoom '.$prettyPhoto.'"></a>
                          </div>',
                $url,
                $title,
                $image,
                $image_full,
                $prettyPhoto
            );
        }
    }
endif;

/*==========================================================================
Get Post Image
==========================================================================*/
if (!function_exists('fatotheme_get_image')) :
    function fatotheme_get_image($args = array())
    {
        $default = apply_filters(
            'fatotheme_get_image_default_args',
            array(
                'post_id' => get_the_ID(),
                'size' => 'thumbnail',
                'format' => 'html', // html or src
                'attr' => '',
                'meta_key' => '',
                'scan' => true,
                'default' => ''
            )
        );

        $args = wp_parse_args($args, $default);
        if (!$args['post_id']) {
            $args['post_id'] = get_the_ID();
        }

        // Get image from cache
        $key = md5(serialize($args));
        $image_cache = wp_cache_get($args['post_id'], 'fatotheme_get_image');


        if (!is_array($image_cache)) {
            $image_cache = array();
        }

        if (empty($image_cache[$key])) {
            // Get post thumbnail
            if (has_post_thumbnail($args['post_id'])) {
                $id = get_post_thumbnail_id();
                $html = wp_get_attachment_image($id, $args['size'], false, $args['attr']);
                list($src) = wp_get_attachment_image_src($id, $args['size'], false, $args['attr']);
            }

            // Get the first image in the custom field
            if (!isset($html, $src) && $args['meta_key']) {
                $id = get_post_meta($args['post_id'], $args['meta_key'], true);
                if ($id) {
                    $html = wp_get_attachment_image($id, $args['size'], false, $args['attr']);
                    list($src) = wp_get_attachment_image_src($id, $args['size'], false, $args['attr']);
                }
            }

            // Get the first image in the post content
            if (!isset($html, $src) && ($args['scan'])) {
                preg_match('|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field('post_content', $args['post_id']), $matches);
                if (!empty($matches)) {
                    $html = $matches[0];
                    $src = $matches[1];
                }
            }

            // Use default when nothing found
            if (!isset($html, $src) && !empty($args['default'])) {
                if (is_array($args['default'])) {
                    $html = @$args['html'];
                    $src = @$args['src'];
                } else {
                    $html = $src = $args['default'];
                }
            }

            if (!isset($html, $src)) {
                return false;
            }

            $output = 'html' === strtolower($args['format']) ? $html : $src;
            $image_cache[$key] = $output;
            wp_cache_set($args['post_id'], $image_cache, 'fatotheme_get_image');
        } else {
            $output = $image_cache[$key];
        }
        $output = apply_filters('fatotheme_get_image', $output, $args);
        return $output;
    }
endif;

/*==========================================================================
Get Post Link
==========================================================================*/
if (!function_exists('fatotheme_get_link_url')) {
    function fatotheme_get_link_url()
    {
        $content = get_the_content();
        $has_url = get_url_in_content($content);

        return ($has_url) ? $has_url : apply_filters('the_permalink', get_permalink());
    }
}

/*==========================================================================
Get Attachment ID
==========================================================================*/
if(!function_exists('fatotheme_get_attachment_id_from_url')) {
    function fatotheme_get_attachment_id_from_url( $attachment_url = '' ) {

        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ( '' == $attachment_url )
            return;

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

        }
        return $attachment_id;
    }
}

/*==========================================================================
Promo Popup
==========================================================================*/
if ($fatotheme_theme_option!=null && $fatotheme_theme_option['promo_popup']=='1'):
add_action('fatotheme_after_wrapper', 'fatotheme_promo_popup');
if(!function_exists('fatotheme_promo_popup')) {
    
    function fatotheme_promo_popup() {
        global $fatotheme_theme_option;
        ?>
        <div id="promo-popup-newsletter" class="white-popup-block mfp-hide mfp-with-anim zoom-anim-dialog">
            <div class="newsletter-wr">
                <?php echo (isset($fatotheme_theme_option['promo_popup_content'])) ? do_shortcode($fatotheme_theme_option['promo_popup_content']) : '';?>
                <p class="checkbox-label">
                    <input type="checkbox" value="do-not-show" name="showagain" id="showagain" class="showagain" />
                    <label for="showagain"><?php esc_html_e("Don't show this popup again", 'fatotheme'); ?></label>
                </p>
            </div>
        </div>
    <?php
    }
}
endif;
/*==========================================================================
Links User Info
==========================================================================*/
if ($fatotheme_theme_option!=null && $fatotheme_theme_option['promo_popup']=='1'):
add_action('wp_head', 'fatotheme_promo_popup_style');
if (!function_exists('fatotheme_promo_popup_style')) {
    function fatotheme_promo_popup_style(){
        global $fatotheme_theme_option;
        ?>
        <style type="text/css">
        #promo-popup-newsletter{
            width: <?php echo (isset($fatotheme_theme_option['promo_popup_width'])) ? $fatotheme_theme_option['promo_popup_width'] : 970; ?>px;
            height: <?php echo (isset($fatotheme_theme_option['promo_popup_height'])) ? $fatotheme_theme_option['promo_popup_height'] : 541; ?>px;
            background-image: url(<?php echo (isset($fatotheme_theme_option['promo_popup_background']['url'])) ? $fatotheme_theme_option['promo_popup_background']['url']:''?>);
        }
        </style>
    <?php
    }
}
endif;

/*==========================================================================
Links User Info
==========================================================================*/
function fatotheme_links_userinfo()
{
    global $fatotheme_theme_option, $woocommerce;
    $login_url = wp_login_url('/');
    $register_url = wp_registration_url('/');
    $account_link = get_edit_profile_url('/');
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    if ( $myaccount_page_id ) {
        $login_url = get_permalink( $myaccount_page_id );
        if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ) {
            $login_url = str_replace( 'http:', 'https:', $login_url );
        }
        if( get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes' ){
            $register_url = $login_url;
        }
        $account_link = get_permalink($myaccount_page_id);
    } ?>
    <div class="topbar-userinfo">
        <ul class="userinfo content-toggler-inner">
            <?php if(is_user_logged_in()){ ?>
                <li class="first">
                    <a class="account" href="<?php echo esc_url($account_link); ?>" title="Account">
                        <i class="fa fa-user"></i> <?php echo esc_html__('My Account','fatotheme'); ?>
                    </a>
                </li>
            <?php } ?>
            <?php if(class_exists('WooCommerce')){ ?>
                <?php if ( class_exists( 'YITH_WCWL_UI' ) ) { global $fatotheme_theme_option, $yith_wcwl; ?>
                <li>
                    <a class="wishlist" href="<?php echo esc_url($yith_wcwl->get_wishlist_url()); ?>" title="<?php esc_html_e('Wishlist','fatotheme'); ?>">
                        <i class="fa fa-heart"></i> <?php echo esc_html__('My Wishlist','fatotheme'); ?>
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()) ?>">
                        <i class="fa fa-shopping-cart"></i> <?php echo esc_html__('My Cart','fatotheme'); ?>
                    </a>
                </li>
                <li>
                    <a class="checkout" href="<?php echo esc_url($woocommerce->cart->get_checkout_url()); ?>" title="Checkout">
                        <i class="fa fa-hand-o-right"></i> <?php echo esc_html__('Check Out','fatotheme'); ?>
                    </a>
                </li>
            <?php } ?>
            <?php if(is_user_logged_in()) { ?>
                <li>
                    <a href="<?php echo esc_url(wp_logout_url(is_home() ? esc_url( home_url( '/' ) ) : get_permalink())) ?>">
                        <i class="fa fa-lock"></i> <?php echo esc_html__('Logout', 'fatotheme'); ?>
                    </a>
                </li>
            <?php }else { ?>
                <li>
                    <a href="<?php echo esc_url($login_url) ?>" class="login-in">
                        <i class="fa fa-unlock-alt"></i> <?php echo esc_html__('Login', 'fatotheme'); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php
}
add_action('fatotheme_links_userinfo_render','fatotheme_links_userinfo');

function fatotheme_social_contact()
{
    global $fatotheme_theme_option;

    $social_output = '<ul class="social-icons">';
    if(isset($fatotheme_theme_option['social_icons'])) {
        foreach($fatotheme_theme_option['social_icons'] as $key=>$value ) {
            if($value!=''){
                if($key=='vimeo'){
                    $social_output .= '<li><a class="'.esc_attr($key).' social-icon tip-top" data-tip="'.ucwords(esc_attr($key)).'" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
                } else {
                    $social_output .= '<li><a class="'.esc_attr($key).' social-icon tip-top" data-tip="'.ucwords(esc_attr($key)).'" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
                }
            }
        }
        
    } 
    $social_output .= '</ul>';

    return $social_output;
}

function fatotheme_single_sharebox()
{
    ?>
    <div class="post-share">
        <div class="row">
            <div class="col-sm-4">
                <h4 class="heading"><?php echo esc_html__( 'Share this Post!','fatotheme' ); ?></h4>
            </div>
            <div class="col-sm-8">
                <?php get_template_part( 'templates/sharebox' ); ?>
            </div>
        </div>
    </div>
    <?php
}
function fatotheme_single_related_post()
{
    get_template_part('templates/single/related');
}
function fatotheme_single_author_bio()
{
    ?>
    <div class="author-about">
        <?php get_template_part('templates/single/author-bio'); ?>
    </div>
    <?php
}

if (!function_exists('lane_post_nav')) {
    function lane_post_nav()
    {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);

        if (!$next && !$previous) {
            return;
        }
        ?>
        <nav class="post-navigation" role="navigation">
            <div class="nav-links">
                <?php
                previous_post_link('<div class="nav-previous">%link</div>', _x('<span class="fa fa-caret-left"></span> <div class="post-navigation-content"><div class="post-navigation-label">Previous</div> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'fatotheme'));
                next_post_link('<div class="nav-next">%link</div>', _x('<span class="fa fa-caret-right"></span> <div class="post-navigation-content"><div class="post-navigation-label">Next</div> <div class="post-navigation-title">%title</div></div> ', 'Next post link', 'fatotheme'));
                ?>
            </div>
            <!-- .nav-links -->
        </nav><!-- .navigation -->
    <?php
    }
}

/*==========================================================================
Language Flags
==========================================================================*/
function fatotheme_language_flags() 
{
    $flag_image = get_template_directory_uri() . '/assets/images/icons/';
    $language_output = '<div class="language-switcher lc-switcher">';
    $language_output .= '<h3>'.esc_html__('Languages', 'fatotheme').'</h3>';
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            $language_output .= '<ul class="language-list lc-list">';
            foreach($languages as $l){
                if($l['country_flag_url']){
                    if($l['active']) {
                        $language_output .= '<li class="active"><a href="'.esc_url($l['url']).'"><img class="country_flag" src="'.$l['country_flag_url'].'" alt="'.$l['native_name'] . ' flag' .'" />'.$l['native_name'].'</a></li>'."\n";
                    } else {
                        $language_output .= '<li><a href="'.esc_url($l['url']).'" ><img class="country_flag" src="'.$l['country_flag_url'].'" alt="'.$l['native_name'] . ' flag' .'" />'.$l['native_name'].'</a></li>'."\n";
                    }
                }
            }
            $language_output .= '</ul>';
        }
    } else {
        $language_output .= '<ul class="language-list lc-list">
            <li><a href="#"><img src="'.$flag_image.'english.png" alt="English" /><span class="flag">English</span></a></li>
            <li><a href="#"><img src="'.$flag_image.'french.png" alt="French" /><span class="flag">French</span></a></li>
            <li><a href="#"><img src="'.$flag_image.'spanish.png" alt="Spanish" /><span class="flag">Spanish</span></a></li>
        </ul>';
    }
    $language_output .= '</div>';
    return $language_output;
}


/*==========================================================================
Currency Switcher
==========================================================================*/
function fatotheme_woo_currency_switcher_ul()
{   
    if(class_exists('WooCommerce')){
        
        global $fatotheme_theme_option;
        $current_currency = get_woocommerce_currency();
        $currency_symbol = get_woocommerce_currency_symbol();

        $currency_output = '<div class="currency-switcher lc-switcher">';
        $currency_output .= '<h3>'.esc_html__('Currency', 'fatotheme').'</h3>';
        $currency_output .= '<div class="current-currency lc-current">'.$current_currency.'</div>';
        $currency_output .= '<ul class="currency-list lc-list">';

        $currencies = $fatotheme_theme_option['woo-currencies'];
        if (!empty($currencies)) {
            foreach ($currencies as $idx => $currency) {
                $currency_output .= '<li id="currency'.strtolower($idx).'"><a href="?currency='.$currencies[$idx].'">'.$currencies[$idx].'</a></li>'."\n";
            }
        }
        $currency_output .= '</ul></div>';
    }
    return $currency_output;
}

/*==========================================================================
Define Ajaxurl
==========================================================================*/
function fatotheme_ajaxurl() {
    echo '<script type="text/javascript">var ajaxurl= "'. admin_url("admin-ajax.php") .'";</script>';
    // Enqueue variation scripts
    wp_enqueue_script( 'wc-add-to-cart-variation' );
}
add_action( 'wp_head', 'fatotheme_ajaxurl' );

/*==========================================================================
Get cart info
==========================================================================*/
add_action( 'wp_ajax_get_cartinfo', 'fatotheme_get_cartinfo' );
add_action( 'wp_ajax_nopriv_get_cartinfo', 'fatotheme_get_cartinfo' );
function fatotheme_get_cartinfo() 
{
    global $fatotheme_theme_option, $woocommerce;
    
    echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woocommerce'), $woocommerce->cart->cart_contents_count);
    echo '|'.$woocommerce->cart->get_cart_total();echo '|'.$woocommerce->cart->get_total(); ?>

    <?php
    die();
}

/*==========================================================================
Change search form
==========================================================================*/
function fatotheme_search_form( $form ) 
{
    if(get_search_query()!=''){
        $search_str = get_search_query();
    } else {
        $search_str = esc_html__( 'Search...', 'fatotheme' );
    }
    
    $form = '<form role="search" method="get" id="blogsearchform" class="searchform" action="' . esc_url(home_url( '/' ) ). '" >
    <div class="form-input">
        <input class="input_text" type="text" value="'.esc_attr($search_str).'" name="s" id="search_input" />
        <button class="button" type="submit" id="blogsearchsubmit"><i class="fa fa-search"></i></button>
        <input type="hidden" name="post_type" value="post" />
        </div>
    </form>';
    $form .= '<script type="text/javascript">';
    $form .= 'jQuery(document).ready(function(){
        jQuery("#search_input").focus(function(){
            if(jQuery(this).val()=="'.esc_html__( 'Search...', 'fatotheme' ).'"){
                jQuery(this).val("");
            }
        });
        jQuery("#search_input").focusout(function(){
            if(jQuery(this).val()==""){
                jQuery(this).val("'.esc_html__( 'Search...', 'fatotheme' ).'");
            }
        });
        jQuery("#blogsearchsubmit").click(function(){
            if(jQuery("#search_input").val()=="'.esc_html__( 'Search...', 'fatotheme' ).'" || jQuery("#search_input").val()==""){
                jQuery("#search_input").focus();
                return false;
            }
        });
    });';
    $form .= '</script>';
    return $form;
}

/*==========================================================================
Change woocommerce search form
==========================================================================*/
function fatotheme_woo_search_form( $form ) 
{
    if(get_search_query()!=''){
        $search_str = get_search_query();
    } else {
        $search_str = esc_html__( 'Search product...', 'fatotheme' );
    }
    
    $form = '<form data-role="search" method="get" id="searchform" action="'.esc_url( home_url( '/'  ) ).'">';
        $form .= '<div>';
            $form .= '<input type="text" value="'.esc_attr($search_str).'" name="s" id="ws" placeholder="" />';
            $form .= '<button class="btn btn-primary" type="submit" id="wsearchsubmit"><i class="icons icon-magnifier"></i></button>';
            $form .= '<input type="hidden" name="post_type" value="product" />';
        $form .= '</div>';
    $form .= '</form>';
    $form .= '<script type="text/javascript">';
    $form .= 'jQuery(document).ready(function(){
        jQuery("#ws").focus(function(){
            if(jQuery(this).val()=="'.esc_html__( 'Search product...', 'fatotheme' ).'"){
                jQuery(this).val("");
            }
        });
        jQuery("#ws").focusout(function(){
            if(jQuery(this).val()==""){
                jQuery(this).val("'.esc_html__( 'Search product...', 'fatotheme' ).'");
            }
        });
        jQuery("#wsearchsubmit").click(function(){
            if(jQuery("#ws").val()=="'.esc_html__( 'Search product...', 'fatotheme' ).'" || jQuery("#ws").val()==""){
                jQuery("#ws").focus();
                return false;
            }
        });
    });';
    $form .= '</script>';
    return $form;
}
add_filter( 'get_product_search_form', 'fatotheme_woo_search_form' );

/*==========================================================================
Sidebar Register
==========================================================================*/
add_action( 'widgets_init' , 'fatotheme_sidebar_setup' );
function fatotheme_sidebar_setup(){
    register_sidebar(array(
        'name'          => esc_html__( 'Shop Sidebar','fatotheme' ),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => esc_html__( 'Shop Single Sidebar','fatotheme' ),
        'id'            => 'shop-single-sidebar',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => esc_html__( 'Blog Sidebar','fatotheme' ),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => esc_html__( 'Footer 1','fatotheme' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget widget-footer-1 %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    
    register_sidebar(array(
        'name'          => esc_html__( 'Footer 2','fatotheme' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget widget-footer-2 %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => esc_html__( 'Footer 3','fatotheme' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget widget-footer-3 %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => esc_html__( 'Footer 4','fatotheme' ),
        'id'            => 'footer-4',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget widget-footer-4 %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => esc_html__( 'Footer 5','fatotheme' ),
        'id'            => 'footer-5',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget widget-footer-5 %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => esc_html__( 'Footer 6','fatotheme' ),
        'id'            => 'footer-6',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget widget-footer-6 %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => esc_html__( 'Sidebar of Top Main Page','fatotheme' ),
        'id'            => 'mainbody-top',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => esc_html__( 'Sidebar of Bottom Main Page','fatotheme' ),
        'id'            => 'mainbody-bottom',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.','fatotheme'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
}

/*==========================================================================
Header Config
==========================================================================*/
add_filter( 'fatotheme_header_layout', 'fatotheme_header_layout_func',100 );
function fatotheme_header_layout_func(){
    global $fatotheme_theme_option, $wp_query;
    $template = $fatotheme_theme_option['header'];

    if(is_page()){
        $header = get_post_meta( $wp_query->get_queried_object_id(), '_fatotheme_header_style',true );
        if($header!='global' && $header!=''){
            $template = $header;
        }
    } else if($fatotheme_theme_option==null){
        $template = get_template_part('templates/header/header','global');
    }
    return $template;
}
