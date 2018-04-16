(function($){
	"use strict";
	var wow;
	var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
   	};

   	var check_iOS = function() {
	    var iDevices = [
	        'iPad Simulator',
	        'iPhone Simulator',
	        'iPod Simulator',
	        'iPad',
	        'iPhone',
	        'iPod'
	    ];
	    while (iDevices.length) {
	        if (navigator.platform === iDevices.pop()){ return true; }
	    }
	    return false;
	}
    
   	var Theme_FixIsotope = function(){
    	"use strict";
    	if(jQuery().isotope){
			jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				jQuery('.isotope').isotope('reLayout');
			});
			jQuery('[id*="accordion-"]').on('shown.bs.collapse',function(e){
				jQuery('.isotope').isotope('reLayout');
			});
		}
   	}
   
   	var Theme_Menu_Search_Form = function(){
    	var $search_menu = $("#menu-search-form");
    	$('.search-toggle').on('click',function(){
    		$search_menu.addClass('active');
    	});
    	$search_menu.find('.search-close').on('click',function(){
    		$search_menu.removeClass('active');
    	});
   	}

   	var Theme_Button_Back_Top = function(){
    	var _isScrolling = false;
    	$("#scrollToTop").on('click',function(e) {
			e.preventDefault();
			$("body, html").animate({scrollTop : 0}, 500);
			return false;
		});

		// Show/Hide Button on Window Scroll event.
		$(window).scroll(function() {
			if(!_isScrolling) {
				_isScrolling = true;
				if($(window).scrollTop() > 150) {
					$("#scrollToTop").stop(true, true).addClass("visible");
					_isScrolling = false;
				} else {
					$("#scrollToTop").stop(true, true).removeClass("visible");
					_isScrolling = false;
				}
			}
		});
   	}

   	var fatotheme_update_wishlist_count = function() {
        $.ajax({
            beforeSend: function () {

            },
            complete  : function () {

            },
            data      : {
                action: 'fatotheme_update_wishlist_count'
            },
            success   : function (data) {
                $('.wishlist-ccount').html(data);
            },

            url: yith_wcwl_l10n.ajax_url
        });
    };
    $('body').on( 'added_to_wishlist removed_from_wishlist', fatotheme_update_wishlist_count );

	$(document).ready(function($) {
		    $('body').on('added_to_cart',function(e,data) {
        alert('Added ' + data['div.widget_shopping_cart_content']);
        if ($('#hidden_cart').length == 0) { //add cart contents only once
            //$('.added_to_cart').after('<a href="#TB_inline?width=600&height=550&inlineId=hidden_cart" class="thickbox">View my inline content!</a>');
            $(this).append('<a href="#TB_inline?width=300&height=550&inlineId=hidden_cart" id="show_hidden_cart" title="<h2>Cart</h2>" class="thickbox" style="display:none"></a>');
            $(this).append('<div id="hidden_cart" style="display:none">'+data['div.widget_shopping_cart_content']+'</div>');
        }
        $('#show_hidden_cart').click();
    });

		Theme_Button_Back_Top();
		Theme_FixIsotope();
		Theme_Menu_Search_Form();

		// init Animate Scroll
    	if( $('body').hasClass('lane-animate-scroll')){
        	wow = new WOW(
          	{
          		mobile : false,
          	});
        	wow.init();
    	}

    	var headerh = $(".page-header").outerHeight();
        $(".header-invisible").css('height',headerh+'px');

		// Promo Popup
		if($('.promo-popup-newsletter').length > 0){
			var promo_popup_closed = $.cookie('promo_newsletter_popup_closed');
			$('.promo-popup-newsletter').magnificPopup({
			    items: {
			        src: '#promo-popup-newsletter',
			        type: 'inline'
			    },
			    removalDelay: 600, //delay removal by X to allow out-animation
			    callbacks: {
			        beforeOpen: function() {
			            this.st.mainClass = 'my-mfp-slide-bottom';
			        },
			        beforeClose: function() {
			        if($('#showagain:checked').val() == 'do-not-show')
			            $.cookie('promo_newsletter_popup_closed', 'do-not-show', { expires: 1, path: '/' } );
			        }
			    }
			    // (optionally) other options
			});
		}

		if(promo_popup_closed != 'do-not-show' && $('.promo-popup-newsletter').length > 0 && $('body').hasClass('visible-popup')) {
		    $('.promo-popup-newsletter').magnificPopup('open');
		}

    	// Collapsible menu for modern header style
		$( '#page-header .navigator-toggle' ).on( 'click', function( e ) {
			e.preventDefault();
			$( '#page-header' ).toggleClass( 'active-navigator' );
		} );

    	// Product initialize isotope
    	if($('.lane-grid-product-isotope').length > 0){
    		var num_per_page = $('.isotope-ploadmore').attr('data-post-per-page');
			$('.lane-grid-product-isotope').isotope({
				// options...
				itemSelector: '.product-isotope',
				layoutMode: 'fitRows',
				filter: ':nth-child(-n+'+ num_per_page +')'
			});
			$('.isotope-ploadmore').parent('.paging-navigation').show('400');
			$('body').delegate('.isotope-ploadmore', 'click', function(event) {
				$('#filters-product-isotope .first').trigger('click');
				$(this).parent('span').parent('.paging-navigation').hide('400');
				return false;
			});
			$('#filters-product-isotope a').on('click',function(){
				$('#filters-product-isotope .current').removeClass('current');
	        	$(this).addClass('current');
				var selector = $(this).attr('data-filter');
					$('.lane-grid-product-isotope').isotope({ filter: selector });
				return false;
			});
		}

    	// Blog Masonry
    	if($('.lane-blog-isotope').length > 0){
			$('.lane-blog-isotope').isotope({
				// options
				itemSelector: '.post-masonry',
				layoutMode: 'masonry'
			});
		}

		$('div.owl-carousel:not(.manual)').each(function () {
			var slider = $(this);

			var defaults = {
				// Most important owl features
				items: 4,
				//itemsCustom: [[0, 1], [767, 1], [992, 2], [1024, 3], [1170, 4]],
				itemsCustom: false,
				itemsDesktop: [1199, 4],
				itemsDesktopSmall: [1024, 3],
				itemsTablet: [991, 2],
				itemsTabletSmall: [768, 2],
				itemsMobile: [480, 1],
				singleItem: false,
				itemsScaleUp: false,

				//Basic Speeds
				slideSpeed: 200,
				paginationSpeed: 800,
				rewindSpeed: 1000,

				//Autoplay
				autoPlay: false,
				stopOnHover: false,

				// Navigation
				navigation: true,
				navigationText: ["<i class='icons icon-arrow-left'></i>", "<i class='icons icon-arrow-right'></i>"],
				rewindNav: true,
				scrollPerPage: false,

				//Pagination
				pagination: true,
				paginationNumbers: false,

				// Responsive
				responsive: true,
				responsiveRefreshRate: 200,
				responsiveBaseWidth: window,

				// CSS Styles
				baseClass: "owl-carousel",
				theme: "owl-theme",

				//Lazy load
				lazyLoad: false,
				lazyFollow: true,
				lazyEffect: "fade",

				//Auto height
				autoHeight: false,

				//JSON
				jsonPath: false,
				jsonSuccess: false,

				//Mouse Events
				dragBeforeAnimFinish: true,
				mouseDrag: true,
				touchDrag: true,

				//Transitions
				transitionStyle: false,

				// Other
				addClassActive: false,

				//Callbacks
				beforeUpdate: false,
				afterUpdate: false,
				beforeInit: false,
				afterInit: false,
				beforeMove: false,
				afterMove: false,
				afterAction: false,
				startDragging: false,
				afterLazyLoad: false
			};

			var config = $.extend({}, defaults, slider.data("plugin-options"));
			var fucStr_afterInit = config.afterInit;
			var fuc_afterInit = function () {
				eval(fucStr_afterInit);
			};
			if (config.afterInit != false) {
				config.afterInit = fuc_afterInit;
			}

			var fucStr_afterMove = config.afterMove;

			var fuc_afterMove = function () {
				eval(fucStr_afterMove);
			};
			if (config.afterMove != false) {
				config.afterMove = fuc_afterMove;
			}

			// Initialize Slider
			slider.owlCarousel(config);
		});

		$('.ryl-text-carousel').each(function () {
			var $this = $(this);

			$this.owlCarousel({
				singleItem: true,
				items: 1,
				pagination: true,
				navigation: $this.hasClass('has-nav'),
				slideSpeed: 300,
				mouseDrag: false,
				transitionStyle: "ryl-text",
				afterAction: updateSliderIndex,
				afterMove: false,
				beforeMove: false,
				autoHeight: true
			});

			function updateSliderIndex() {
				var items = $this.children().find('.owl-pagination .owl-page').length;
				var index = $this.children().find('.owl-pagination .owl-page.active').index() + 1;
				$this.attr('data-index', (index + "/" + items));
			}
		});

		// Single Product Image Gallery
		if($('.product-gallery').length > 0){
			var pmainimages = $("#pmainimages");
			var pthumbs = $("#pthumbs");

			pmainimages.owlCarousel({
				singleItem : true,
				slideSpeed : 1000,
				navigation: false,
				pagination: true,
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
				singleItem : true,
				pagination:false,
				responsiveRefreshRate : 100,
				navigation: true,
				navigationText: ["<i class='icons icon-arrow-left'></i>", "<i class='icons icon-arrow-right'></i>"],
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

			$("#pthumbs").on("click", ".owl-item >.thumbnail-image", function(e){
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

    	// disable spell check for Chrome/Safari
    	$('input[type="text"],input[type="email"],input[type="tel"],input[type="search"],textarea').attr('spellcheck',false);

    	// Category Menu Toggle
    	var categoryToggle = $('.category-toggle');
    	categoryToggle.hover(function(){
			$('.category-vertical').toggleClass('open');
			$(this).toggleClass('active');
		});

		var fatotheme_update_wishlist_count = function() {
	        $.ajax({
	            beforeSend: function () {

	            },
	            complete  : function () {

	            },
	            data      : {
	                action: 'fatotheme_update_wishlist_count'
	            },
	            success   : function (data) {
	                $('.wishlist-ccount').html(data);
	            },

	            url: yith_wcwl_l10n.ajax_url
	        });
	    };
	    $('body').on( 'added_to_wishlist removed_from_wishlist', fatotheme_update_wishlist_count );

		if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		  	$('.tip,.tip-bottom').tipr();
		  	$('.mainheader .tip-top,#page-mainbody .tip-top,#page-footer .tip-top').tipr({mode:"top"});
		}

		// Lane Progress Bar
		if ($('.lane-progress-bar')) {
			$('.lane-progress-bar .vc_single_bar').each(function(){
				var data_value = $(this).children('.vc_bar').attr('data-value');
				//$(this).children('.vc_label').children('.vc_label_units').css('left', data_value + '%');
				$(this).children('.vc_label').children('.vc_label_units').animate({"left": data_value + '%'}, "slow");
			})
		}
	});

	//Search Product Categỏriés
	$(document).mouseup(function (e) {
		var container = $('.wplane-search .product-categories');
		if (!container.is(e.target) && container.has(e.target).length === 0 && !$('.cate-toggler').is(e.target) ) { /* if the target of the click isn't the container nor a descendant of the container */
			if($('.wplane-search .product-categories').hasClass('open')) {
				$('.wplane-search .product-categories').removeClass('open');
			}
		}
		
		container = $('.atc-notice-wrapper');
		if (!container.is(e.target) && container.has(e.target).length === 0 ) {
			$('.atc-notice-wrapper').fadeOut();
		}
	});
	
	$(window).load(function(){

		//wplane Search by category
		var cateToggler = $('.cate-toggler');
		
		$('.wplane-search .product-categories').prepend('<li><a href="'+$('#searchform').attr('action')+'">'+cateToggler.html()+'</a></li>');
		
		cateToggler.click(function(){
			$('.wplane-search .product-categories').toggleClass('open');
		});
		
		/* Init values */
		var searchCat = ''; //category to search, set when click on a category
		var currentCat = getParameterByName( 'product_cat', $('.wplane-search .product-categories .current-cat a').attr('href') ); /* when SEO off */
		var currentCatName = $('.current-cat a').html();
		
		if(currentCatName!=''){
			cateToggler.html(currentCatName);
			
			//change form action when click submit
			$('#wsearchsubmit').click(function(){
				if( searchCat==''){
					$('#searchform').attr( 'action', $('.wplane-search .product-categories .current-cat a').attr('href') );
				}
			});
		}
		if(currentCat!='') {
			/* when SEO off, we need product_cat */
			if( !($('#product_cat').length > 0) ) {
				$('#searchform').append('<input type="hidden" id="product_cat" name="product_cat" value="'+currentCat+'" />');
			}
			$('#product_cat').val(currentCat);
		}
		
		$('.wplane-search .product-categories a').each(function(){
			$(this).click(function(event){
				event.preventDefault();
				
				$('.wplane-search .product-categories a.active').removeClass('active');
				$(this).addClass('active');
				$('.wplane-search .product-categories').removeClass('open');
				$('#searchform').attr( 'action', $(this).attr('href') );
				cateToggler.html($(this).html());
				searchCat = $(this).attr('href');
				
				/* when SEO off, we need product_cat */
				if( !( $('#product_cat').length > 0) && ( getParameterByName( 'product_cat', $(this).attr('href') ) != '' ) ) {
					$('#searchform').append('<input type="hidden" id="product_cat" name="product_cat" value="" />');
				}
				$('#product_cat').val( getParameterByName( 'product_cat', $(this).attr('href') ) );
			});
		});
	});
}).apply(this, [jQuery]);

//Mini Cart Remove
function Theme_MiniCart_Remove(url, itemid) {
	jQuery('.mini_cart_content').addClass('loading');
	jQuery('.cart-form').addClass('loading');
	
	jQuery.get( url, function(data,status){
		if(status=='success'){
			//update mini cart info
			jQuery.post(
				ajaxurl,
				{
					'action': 'get_cartinfo'
				}, 
				function(response){
					var cartinfo = response.split("|");
					var itemAmount = cartinfo[0];
					var cartTotal = cartinfo[1];
					var orderTotal = cartinfo[2];
					
					jQuery('.cart-quantity').html(itemAmount);
					jQuery('.cart-total .amount').html(cartTotal);
					jQuery('.total .amount').html(cartTotal);
					jQuery('.cart-subtotal .amount').html(cartTotal);
					jQuery('.order-total .amount').html(orderTotal);
				}
			);
			//remove item line from mini cart & cart page
			jQuery('#mcitem-' + itemid).animate({'height': '0', 'margin-bottom': '0', 'padding-bottom': '0', 'padding-top': '0'});
			setTimeout(function(){
				jQuery('#mcitem-' + itemid).remove();
				jQuery('#lcitem-' + itemid).remove();
				//set new height
				var mCartHeight = jQuery('.mini_cart_inner').outerHeight();
				jQuery('.mini_cart_content').animate({'height': mCartHeight});
			}, 800);
			
			jQuery('.mini_cart_content').removeClass('loading');
			jQuery('.cart-form').removeClass('loading');
		}
	});
}

function getParameterByName(name, string) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(string);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}




