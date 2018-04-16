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
<div class="toplinks">
    <ul class="nav">
        <?php if(is_user_logged_in()){ ?>
            <li class="first">
                <a class="account" href="<?php echo esc_url($account_link); ?>" title="Account">
                    <i class="fa fa-user"></i>
                    <?php echo esc_html__('My Account','fatotheme'); ?>
                </a>
            </li>
        <?php } ?>
        <?php if(class_exists('WooCommerce')){ ?>
            <?php if ( class_exists( 'YITH_WCWL_UI' ) ) { global $yith_wcwl; ?>
            <li>
                <a class="wishlist" href="<?php echo esc_url($yith_wcwl->get_wishlist_url()); ?>" title="<?php esc_html_e('Wishlist','fatotheme'); ?>">
                    <i class="fa fa-heart"></i>
                    <?php echo esc_html__('My Wishlist','fatotheme'); ?>
                </a>
            </li>
            <?php } ?>
            <li>
                <a class="checkout" href="<?php echo esc_url($woocommerce->cart->get_checkout_url()); ?>" title="Checkout">
                    <i class="fa fa-fire"></i>
                    <?php echo esc_html__('Check Out','fatotheme'); ?>
                </a>
            </li>
        <?php } ?>
        <?php if(is_user_logged_in()) { ?>
            <li>
                <a href="<?php echo esc_url(wp_logout_url(is_home() ? esc_url( home_url( '/' ) ) : get_permalink())) ?>">
                    <i class="fa fa-unlock-alt"></i>
                    <?php echo esc_html__('Logout', 'fatotheme'); ?>
                </a>
            </li>
        <?php }else { ?>
            <li>
                <a href="<?php echo esc_url($login_url) ?>" class="login-in">
                    <i class="fa fa-unlock-alt"></i>
                    <?php echo esc_html__('Login', 'fatotheme'); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>