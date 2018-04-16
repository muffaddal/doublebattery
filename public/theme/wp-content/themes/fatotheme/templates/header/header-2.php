<?php 
$fatotheme_theme_option = fatotheme_get_theme_option();
$woocommerce = fatotheme_get_woocommerce();
$login_url = wp_login_url();
$register_url = wp_registration_url();
$account_link = get_edit_profile_url();
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
}
?>
<header id="page-header" class="page-header header-2">
    <?php if($fatotheme_theme_option['header_topbar']): ?>
    <div class="topbar">
        <div class="container">
            <div class="row">
                <?php if(isset($fatotheme_theme_option['header_topbar_text']) && $fatotheme_theme_option['header_topbar_text']!='') echo wp_kses_post('<div class="topbar-text">'.$fatotheme_theme_option['header_topbar_text'].'</div>'); ?>
            </div>
        </div>
    </div>
    <?php endif; // End Topbar ?>
    <div class="mainheader">
        <div class="container">
            <a href="#" class="navigator-toggle">
                <span class="nav-line"></span>
                <span class="nav-text"><?php echo esc_html__('MENU', 'fatotheme') ?></span>
            </a>
            <div class="logo-box">
                <div class="logo">
                    <?php do_action('fatotheme_set_logo'); ?>
                </div>
            </div>
            <div class="header-extra">
                <div class="header-switcher">
                    <i class="icon-settings icons"></i>
                    <div class="switcher-content">
                        <div class="switcher-content-inner">
                            <?php echo fatotheme_links_userinfo() ?>
                            <?php if( (isset($fatotheme_theme_option['header_is_switch_language']) && $fatotheme_theme_option['header_is_switch_language'] ) || (class_exists('WooCommerce') && ( isset($fatotheme_theme_option['header_is_switch_currency']) && $fatotheme_theme_option['header_is_switch_currency'] ))){ ?>
                            <div class="currency-language">
                                <?php if( isset($fatotheme_theme_option['header_is_switch_language']) && $fatotheme_theme_option['header_is_switch_language'] ){ ?>
                                    <?php echo fatotheme_language_flags(); ?>
                                <?php } ?>
                                <?php if(class_exists('WooCommerce') && ( isset($fatotheme_theme_option['header_is_switch_currency']) && $fatotheme_theme_option['header_is_switch_currency'] )){ ?>
                                    <?php echo fatotheme_woo_currency_switcher_ul(); ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if(class_exists('WooCommerce')){ ?>
                    <?php if ( class_exists( 'YITH_WCWL_UI' ) ) { global $yith_wcwl; ?>
                    <div class="header-wishlist">
                        <a class="wishlist tip-top" href="<?php echo esc_url($yith_wcwl->get_wishlist_url()); ?>" data-tip="<?php esc_html_e('Wishlist','fatotheme'); ?>">
                            <i class="icons icon-heart"></i>
                            <span class="wishlist-ccount"><?php echo yith_wcwl_count_products(); ?></span>
                        </a>
                    </div>
                    <?php } ?>
                <?php } // End If ?>
                <?php if( class_exists('WooCommerce') && $fatotheme_theme_option['header_is_cart'] ){ ?>
                <div class="header-cart">
                    <?php if (class_exists('WooCommerce')): ?>
                        <div class="widget woocommerce widget_shopping_cart">
                            <div class="widget_shopping_cart_content">
                                <?php get_template_part('woocommerce/cart/mini','cart'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php } // End Header Cart ?>
            </div>
            
            <div class="header-nav">
                <div class="nav-container">
                    <?php if (has_nav_menu('mainmenu')) : ?>
                    <?php
                        wp_nav_menu(array(
                            'container' => 'div',
                            'container_class' => 'wez-mega-menu',
                            'theme_location' => 'mainmenu',
                            'menu_class' => 'main-menu'
                        ));
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php do_action('fatotheme_after_header'); ?>
</header>
<div class="header-invisible"></div>
<!-- //HEADER -->