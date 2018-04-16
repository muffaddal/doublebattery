 <?php
$product = fatotheme_get_product();
$post = fatotheme_get_post();
$woocommerce = fatotheme_get_woocommerce();
$attachment_ids = $product->get_gallery_image_ids();
$images =array();
if(has_post_thumbnail()){
    $images[] = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
}else{
    $images[] = '<img src="'.wc_placeholder_img_src().'"/>';
}
foreach ($attachment_ids as $attachment_id) {
    $images[]       = wp_get_attachment_image( $attachment_id, 'shop_single' );
}

$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
$assets_path = str_replace(array('http:', 'https:'), '', WC()->plugin_url()) . '/assets/';
$frontend_script_path = $assets_path . 'js/frontend/';
?>
<div id="woo-product-quickview-lightbox" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
                    <div id="single-product" class="row woocommerce">
                        <div class="col-sm-6">
                            <div class="single-product-image">
                            <?php
                            /**
                             * woocommerce_before_single_product_summary hook
                             *
                             * @hooked woocommerce_show_product_sale_flash - 10
                             * @hooked woocommerce_show_product_images - 20
                             */
                            do_action( 'woocommerce_before_single_product_summary' );
                            ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="summary-product entry-summary">
                                <?php
                                /**
                                 * woocommerce_single_product_summary hook
                                 *
                                 * @hooked woocommerce_template_single_title - 5
                                 * @hooked woocommerce_template_single_rating - 10
                                 * @hooked woocommerce_template_single_price - 10
                                 * @hooked woocommerce_template_single_excerpt - 20
                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                 * @hooked woocommerce_template_single_meta - 40
                                 * @hooked woocommerce_template_single_sharing - 50
                                 */
                                do_action( 'woocommerce_single_product_summary' );
                                echo fatotheme_social_contact();
                                ?>
                            </div>
                        </div>
                    </div>
                </div><!-- #product-<?php the_ID(); ?> -->
            </div>
        </div>
    </div>
    <script type="text/javascript"
            src="<?php echo esc_url($frontend_script_path); ?>add-to-cart<?php echo ''.$suffix; ?>.js"></script>
    <script type="text/javascript"
            src="<?php echo esc_url($frontend_script_path); ?>add-to-cart-variation<?php echo ''.$suffix; ?>.js"></script>
    <script>
        <!--
        (function ($) {
            "use strict";
            $('.variations_form').wc_variation_form();
            $('.variations_form .variations select').change();

            // Single Product Image Gallery
            if($('.product-gallery').length > 0){
                var pmainimages = $("#pmainimages");
                var pthumbs = $("#pthumbs");

                pmainimages.owlCarousel({
                    singleItem : true,
                    slideSpeed : 1000,
                    navigation: false,
                    pagination:false,
                    afterAction : syncPosition,
                    responsiveRefreshRate : 200
                });

                pthumbs.owlCarousel({
                    items : 1,
                    itemsDesktop: [1199, 1],
                    itemsDesktopSmall: [980, 1],
                    itemsTablet: [768, 1],
                    itemsTabletSmall: false,
                    itemsMobile: [479, 1],
                    pagination:false,
                    responsiveRefreshRate : 100,
                    navigation: true,
                    navigationText: ["<i class='pe-7s-angle-left'></i>", "<i class='pe-7s-angle-right'></i>"],
                    afterInit : function(el){
                        el.find(".owl-item").eq(0).addClass("active");
                    }
                });

                function syncPosition(el){
                    var current = this.currentItem;
                    $("#pthumbs")
                        .find(".owl-item")
                        .removeClass("active")
                        .eq(current)
                        .addClass("active")
                    if($("#pthumbs").data("owlCarousel") !== undefined){
                        center(current)
                    }
                }

                $("#pthumbs").on("click", ".owl-item", function(e){
                    e.preventDefault();
                    var number = $(this).data("owlItem");
                    pmainimages.trigger("owl.goTo",number);
                });

                function center(number){
                    var pthumbsvisible = pthumbs.data("owlCarousel").owl.visibleItems;
                    var num = number;
                    var found = false;
                    for(var i in pthumbsvisible){
                        if(num === pthumbsvisible[i]){
                            var found = true;
                        }
                    }

                    if(found===false){
                        if(num>pthumbsvisible[pthumbsvisible.length-1]){
                            pthumbs.trigger("owl.goTo", num - pthumbsvisible.length+2)
                        }else{
                            if(num - 1 === -1){
                                num = 0;
                            }
                            pthumbs.trigger("owl.goTo", num);
                        }
                    } else if(num === pthumbsvisible[pthumbsvisible.length-1]){
                        pthumbs.trigger("owl.goTo", pthumbsvisible[1])
                    } else if(num === pthumbsvisible[0]){
                        pthumbs.trigger("owl.goTo", num-1)
                    }
                }


                $(document).on('change','.variations_form .variations select,.variations_form .variation_form_section select,div.select',function(){
                    var variation_form = $(this).closest( '.variations_form' );
                    var current_settings = {},
                        reset_variations = variation_form.find( '.reset_variations' );
                    variation_form.find('.variations select,.variation_form_section select' ).each( function() {
                        // Encode entities
                        var value = $(this ).val();

                        // Add to settings array
                        current_settings[ $( this ).attr( 'name' ) ] = jQuery(this ).val();
                    });

                    variation_form.find('.variation_form_section div.select input[type="hidden"]' ).each( function() {
                        // Encode entities
                        var value = $(this ).val();

                        // Add to settings array
                        current_settings[ $( this ).attr( 'name' ) ] = jQuery(this ).val();
                    });

                    var all_variations = variation_form.data( 'product_variations' );

                    var variation_id = 0;
                    var match = true;

                    for (var i = 0; i < all_variations.length; i++)
                    {
                        match = true;
                        var variations_attributes = all_variations[i]['attributes'];
                        for(var attr_name in variations_attributes) {
                            var val1 = variations_attributes[attr_name];
                            var val2 = current_settings[attr_name];
                            if (val1 == undefined || val2 == undefined ) {
                                match = false;
                                break;
                            }
                            if (val1.length == 0) {
                                continue;
                            }

                            if (val1 != val2) {
                                match = false;
                                break;
                            }
                        }
                        if (match) {
                            variation_id = all_variations[i]['variation_id'];
                            break;
                        }
                    }

                    if (variation_id > 0) {
                        var index = parseInt($('a[data-variation_id="'+variation_id+'"]','#pthumbs').data('index'),10) ;
                        if (!isNaN(index) ) {
                            pmainimages.trigger("owl.goTo",index);
                        }
                    }
                });
            }
        })(jQuery);
        -->
    </script>
</div>