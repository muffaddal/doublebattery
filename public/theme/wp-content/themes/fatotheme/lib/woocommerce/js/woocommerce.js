// Woo Core Build Events
(function ($) {
	"use strict";
	$(document).ready(function() {
		$('body').delegate('.btn-wishlist', 'click', function(event) {
			var $button = $(this).parents('.product-button-action');
			$button.find('.add_to_wishlist').trigger('click');
			return false;
		});

		$('body').delegate('.btn-compare', 'click', function(event) {
			$(this).parents('.product-button-action').find('.compare').trigger('click');
			return false;
		});

		// Variable Product
		$('body').delegate('.wishlist-compare-email .btn-addtocart', 'click', function(event) {
			$('form.cart .cart-action .add_to_cart').trigger('click');
			return false;
		});

		// Variable Product
		$('body').delegate('.wishlist-compare-email .btn-addtocart', 'click', function(event) {
			$('form.cart .woocommerce-variation-add-to-cart .single_add_to_cart_button').trigger('click');
			return false;
		});

		// Extended Product
		$('#single-product .wishlist-compare-email .btn-addtocart').on('click', function(){
			window.open($('.cart-external-product a').attr('href'),'_self');
		});

		// Single Product
		$('body').delegate('.wishlist-compare-email .btn-wishlist', 'click', function(event) {
			$('#single-product .add_to_wishlist').trigger('click');
			return false;
		});

		$('body').delegate('.wishlist-compare-email .btn-compare', 'click', function(event) {
			$('#single-product .compare.button').trigger('click');
			return false;
		});
	});

	var Core = {
		initialized: false,
		//timeOut_search: null,

		initialize: function () {

			if (this.initialized) return;
			this.initialized = true;

			this.build();
			Core.events();
		},
		build: function () {
			Core.prettyPhoto();
			Core.product_countdown();
			Core.process_product();
			Core.register_widget_search();
            Core.register_header_search();
		},
		events: function () {
			Core.search_popup_process();
			Core.search_box_header_process();
			Core.product_mouseover();
		},
		process_product: function () {
			Core.add_cart_quantity();
			Core.product_quick_view();
			Core.archive_product_layout_switch();
         	//Core.product_add_to_cart();
		},
		prettyPhoto : function() {
			$("a[data-rel^='prettyPhoto']").prettyPhoto({
				social_tools:'',
				animation_speed:'normal',
				theme:'light_square'
			});
			$("a[rel^='prettyPhoto']").prettyPhoto({
				social_tools:'',
				animation_speed:'normal',
				theme:'light_square'
			});
		},
		archive_product_layout_switch : function() {
            $('.layout-switch','.catalog-layout-switch').on('click',function(event) {
                event.preventDefault();
                if ($(this).hasClass('active')) return;
                var $this = $(this);
                $('.layout-switch','.catalog-layout-switch').removeClass('active');

                $.cookie('woo-shop-layout-switch',$this.attr('data-layout'));

                $(this).addClass('active');

                var layout = $this.attr('data-layout');

                $('.achive-product-layout').fadeOut(500,function(){
                    var layout_current = $(this).attr('data-layout');
                    $(this).attr('data-layout',layout);
                    $(this).removeClass(layout_current).addClass(layout).fadeIn(500);
                });
            });
        },
		product_countdown: function() {
			$.countdown.regionalOptions[''] = {
				labels: [lane_countdown_l10n.years, lane_countdown_l10n.months, lane_countdown_l10n.weeks, lane_countdown_l10n.days , lane_countdown_l10n.hours, lane_countdown_l10n.minutes, lane_countdown_l10n.seconds],
				labels1: [lane_countdown_l10n.year, lane_countdown_l10n.month, lane_countdown_l10n.week, lane_countdown_l10n.day, lane_countdown_l10n.hour, lane_countdown_l10n.minute, lane_countdown_l10n.second],
				compactLabels: ['y', 'm', 'w', 'd'],
				whichLabels: null,
				digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
				timeSeparator: ':', isRTL: true};
			$.countdown.setDefaults($.countdown.regionalOptions['']);
			// regionalOptions: { // Available regional settings, indexed by language/country code
			// 		'': { // Default regional settings - English/US
			// 			labels: ['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
			// 			labels1: ['Year', 'Month', 'Week', 'Day', 'Hour', 'Minute', 'Second'],
			// 			compactLabels: ['y', 'm', 'w', 'd'],
			// 			whichLabels: null,
			// 			digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
			// 			timeSeparator: ':',
			// 			isRTL: false
			// 		}
			// 	},
			$('.countdown').each(function() {
		        var count = $(this);
		        var austDay =  new Date(count.data('countdown'));
		        $(this).countdown({
		        	until: austDay,
		        	format: 'dHMS'
		        });
		    });
		},
		product_quick_view: function () {
			$('.woo-product-quickview').on('click', function (event) {
				event.preventDefault();
				$(this).addClass('loading');
				var product_id = $(this).data('product_id');
				var popupWrapper = '#woo-product-quickview-lightbox';
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'product_quick_view',
						id: product_id
					},
					success: function (html) {
						$('.woo-product-quickview').removeClass('loading');
						if ($(popupWrapper).length) {
							$(popupWrapper).remove();
						}
						$('body').append(html);
						Core.add_cart_quantity();
                        Core.tooltip();
						$(popupWrapper).modal();
						$('.quickview-slides').owlCarousel({
							navigation : false,
							pagination: true,
							items :1,
						});
					},
					error: function (html) {
						Core.hide_loading();
					}
				});

			});
		},
		show_loading: function () {
			$('body').addClass('overflow-hidden');
			if ($('.loading-wrapper').length == 0) {
				$('body').append('<div class="loading-wrapper"><span class="spinner-double-section-far"></span></div>');
			}
		},
		hide_loading: function () {
			$('.loading-wrapper').fadeOut(function () {
				$('.loading-wrapper').remove();
				$('body').removeClass('overflow-hidden');
			});
		},
		add_cart_quantity: function ($) {
			jQuery(document).off('click', '.quantity .btn-number').on('click', '.quantity .btn-number', function (event) {
				event.preventDefault();
				var type = jQuery(this).data('type');
				var input = jQuery('input', jQuery(this).parent());
				var current_value = parseInt(input.val());

				var max = input.attr('max');
				if (typeof(max) == 'undefined') {
					max = 100;
				}

				var min = input.attr('min');
				if (typeof(min) == 'undefined') {
					min = 0;
				}
				if (!isNaN(current_value)) {
					if (type == 'minus') {
						if (current_value > min) {
							input.val(current_value - 1).change();
						}
						if (parseInt(input.val()) == min) {
							jQuery(this).attr('disabled', true);
						}
					}

					if (type == 'plus') {

						if (current_value < max) {
							input.val(current_value + 1).change();
						}
						if (parseInt(input.val()) == max) {
							jQuery(this).attr('disabled', true);
						}
					}
				} else {
					input.val(0);
				}
			});


			jQuery('input', '.quantity').focusin(function () {
				jQuery(this).data('oldValue', jQuery(this).val());
			});

			jQuery('input', '.quantity').on('change', function () {
				var input = jQuery(this);
				var max = input.attr('max');
				if (typeof(max) == 'undefined') {
					max = 100;
				}

				var min = input.attr('min');
				if (typeof(min) == 'undefined') {
					min = 0;
				}

				var current_value = parseInt(input.val());

		        var btn_add_to_cart =jQuery('.add_to_cart_button',jQuery(this).parent().parent().parent());
				if (current_value >= min) {
					jQuery(".btn-number[data-type='minus']", jQuery(this).parent()).removeAttr('disabled');
		            if (typeof(btn_add_to_cart) != 'undefined') {
		                btn_add_to_cart.attr('data-quantity',current_value);
		            }

				} else {
					alert('Sorry, the minimum value was reached');
					jQuery(this).val(jQuery(this).data('oldValue'));

		            if (typeof(btn_add_to_cart) != 'undefined') {
		                btn_add_to_cart.attr('data-quantity',jQuery(this).data('oldValue'));
		            }
				}

				if (current_value <= max) {
					jQuery(".btn-number[data-type='plus']", jQuery(this).parent()).removeAttr('disabled');
		            if (typeof(btn_add_to_cart) != 'undefined') {
		                btn_add_to_cart.attr('data-quantity',current_value);
		            }
				} else {
					alert('Sorry, the maximum value was reached');
					jQuery(this).val(jQuery(this).data('oldValue'));
		            if (typeof(btn_add_to_cart) != 'undefined') {
		                btn_add_to_cart.attr('data-quantity',jQuery(this).data('oldValue'));
		            }
				}

			});
		},
		search_box_header_process: function () {
			$('.search-header-wrapper .seach-header-input').on('keyup', function (event) {
				var s_timeOut_search = null;
				if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
					return;
				}

				var keys = ["Control", "Alt", "Shift"];
				if (keys.indexOf(event.key) != -1) return;
				switch (event.which) {
					case 37:
					case 39:
						break;
					case 27:	// ESC
						$('.search-header-result').html('');
						$(this).val('');
						break;
					case 38:	// UP
						s_up();
						break;
					case 40:	// DOWN
						s_down();
						break;
					case 13:	//ENTER
						var $item = $('li.selected a', '.search-header-result');
						if ($item.length == 0) {
							event.preventDefault();
							return false;
						}
						s_enter();
						event.preventDefault();
						break;
					default:
						clearTimeout(Core.timeOut_search);
						Core.timeOut_search = setTimeout(s_search, 500);
						break;
				}
			});

			function s_search() {
				var keyword = $('.search-header-wrapper .seach-header-input').val();
				var $result = $('.search-header-wrapper .search-header-result');
				var $icon = $('.search-header-wrapper > label span.pe-7s-search');

				$icon.addClass('searching');
				$.ajax({
					type: 'POST',
					data: 'action=result_search_product&keyword=' + keyword,
					url: ajaxurl,
					success: function (data) {
						$icon.removeClass('searching');
						var html = '';
						if (data) {
							var items = $.parseJSON(data);
							if (items.length) {
								html += '<ul>';
								if (items[0]['id'] == -1) {
									html += '<li class="selected">' + items[0]['title'] + '</li>';
								}
								else {
									$.each(items, function (index) {
										if (index == 0) {
											html += '<li class="selected">';
										}
										else {
											html += '<li>';
										}

										html += '<a href="' + this['guid'] + '">';
										html += this['thumb'];
										html += this['title'] + '</a>';
										html += '<div class="price">' + this['price'] + '</div>';
										html += '</li>';
									});
								}
							}
							else {
								html = '</ul>';
							}
						}
						$result.html(html);
						if (keyword.length < 3) {
							$result.html('<ul><li class="selected">Please fill keyword more than 2 chars to search</li></ul>');
							return;
						}
						$result.scrollTop(0);
					},
					error: function (data) {
						$icon.removeClass('searching');
					}
				});
			}

			function s_up() {
				var $item = $('li.selected', '.search-header-result');
				if ($('li', '.search-header-result').length < 2) return;
				var $prev = $item.prev();
				$item.removeClass('selected');
				if ($prev.length) {
					$prev.addClass('selected');
				}
				else {
					$('li:last', '.search-header-result').addClass('selected');
					$prev = $('li:last', '.search-header-result');
				}
				if ($prev.position().top < $('.search-header-result').scrollTop()) {
					$('.search-header-result').scrollTop($prev.position().top);
				}
				else if ($prev.position().top + $prev.outerHeight() > $('.search-header-result').scrollTop() + $('.search-header-result').height()) {
					$('.search-header-result').scrollTop($prev.position().top - $('.search-header-result').height() + $prev.outerHeight());
				}
			}

			function s_down() {
				var $item = $('li.selected', '.search-header-result');
				if ($('li', '.search-header-result').length < 2) return;
				var $next = $item.next();
				$item.removeClass('selected');
				if ($next.length) {
					$next.addClass('selected');
				}
				else {
					$('li:first', '.search-header-result').addClass('selected');
					$next = $('li:first', '.search-header-result');
				}
				if ($next.position().top < jQuery('.search-header-result').scrollTop()) {
					$('.search-header-result').scrollTop($next.position().top);
				}
				else if ($next.position().top + $next.outerHeight() > $('.search-header-result').scrollTop() + $('.search-header-result').height()) {
					$('.search-header-result').scrollTop($next.position().top - $('.search-header-result').height() + $next.outerHeight());
				}
			}

			function s_enter() {
				var $item = $('li.selected a', '.search-header-result');
				if ($item.length > 0) {
					window.location = $item.attr('href');
				}
			}
		},
		search_popup_process: function () {
			$('.search-button-wrapper .search-icon').hover(function (event) {
				event.preventDefault();
				//var windowWidth = $(this).parent('.search-button-wrapper').parent('.header-nav-search').width();
                var input_search = $('.input-search',$(this).parent());
                var spanIcon = $('.icon-search-menu');
                //var searchResultWrapper =  $('.widget-search-result-wrapper',$(this).parent());
                $(spanIcon).toggleClass('toggle-icon');
                $(input_search).toggleClass('input-active');
                $('.submit-search').toggleClass('active');
                $('.search-button-wrapper').toggleClass('has-input-search');
                $('.header-nav').toggleClass('has-input-search');
			});
		},
		search_popup_open: function () {
			if (!$('#lane-modal-search').hasClass('in')) {
				$('#lane-modal-search').show();
				setTimeout(function () {
					$('#lane-modal-search').addClass('in');
				}, 300);
				$('#search-ajax', '#lane-modal-search').focus();
				$('#search-ajax', '#lane-modal-search').val('');
				$('.ajax-search-result', '#lane-modal-search').html('')
			}
		},
		search_popup_close: function () {
			if ($('#lane-modal-search').hasClass('in')) {
				$('#lane-modal-search').removeClass('in');
				setTimeout(function () {
					$('#lane-modal-search').hide();
				}, 300);
			}
		},
		register_widget_search:function(){
            $('button','.widget-search').on('click',function(){
                Core.search_widget_process(this);
            });

            $('input','.widget-search').on('keyup', function (event){

                    switch (event.which) {
                        case 13:
                            if ($(this).val()!='') {
                                Core.search_widget_process(this);
                            }
                            break;
                        case 27:
                            $('button i',$(this).parent()).removeClass('fa-spin fa-spinner');
                            $('button i',$(this).parent()).addClass('fa-search');
                            $('.ajax-search-result-widget', '.widget-search').html('');
                            $($widget_search_wrapper).css('display','none');
                            break;
                        case 38:	// UP
                            s_up();
                            break;
                        case 40:	// DOWN
                            s_down();
                            break;
                    }
            });

            $('a.close','.widget-search').on('click',function(){
                var wrapper = $(this).parent();
                $('.ajax-search-result-widget', $(wrapper)).html('');
                $(wrapper).css('display','none');
            });

            function s_up(){
                var $item = $('li.selected', '.ajax-search-result-widget');
                if ($('li', '.ajax-search-result-widget').length < 2) return;
                var $prev = $item.prev();
                $item.removeClass('selected');
                if ($prev.length) {
                    $prev.addClass('selected');
                }
                else {
                    $('li:last', '.ajax-search-result-widget').addClass('selected');
                    $prev = $('li:last', '.ajax-search-result-widget');
                }
                if ($prev.position().top < $('.ajax-search-result-widget').scrollTop()) {
                    $('.ajax-search-result-widget').scrollTop($prev.position().top);
                }
                else if ($prev.position().top + $prev.outerHeight() > $('.ajax-search-result-widget').scrollTop() + $('.ajax-search-result-widget').height()) {
                    $('.ajax-search-result-widget').scrollTop($prev.position().top - $('.ajax-search-result-widget').height() + $prev.outerHeight());
                }
            }
            function s_down() {
                var $item = $('li.selected', '.ajax-search-result-widget');
                if ($('li', '.ajax-search-result-widget').length < 2) return;
                var $next = $item.next();
                $item.removeClass('selected');
                if ($next.length) {
                    $next.addClass('selected');
                }
                else {
                    $('li:first', '.ajax-search-result-widget').addClass('selected');
                    $next = $('li:first', '.ajax-search-result-widget');
                }
                if ($next.position().top < jQuery('.ajax-search-result-widget').scrollTop()) {
                    $('.ajax-search-result-widget').scrollTop($next.position().top);
                }
                else if ($next.position().top + $next.outerHeight() > $('.ajax-search-result-widget').scrollTop() + $('.ajax-search-result-widget').height()) {
                    $('.ajax-search-result-widget').scrollTop($next.position().top - $('.ajax-search-result-widget').height() + $next.outerHeight());
                }
            }
        },
		register_header_search:function(){
            $('input','.search-button-wrapper').on('keyup', function (event){
                var wrapper = $(this).parent();
                switch (event.which) {
                    case 13:
                        if ($(this).val()!='') {
                            Core.search_header_process(wrapper);
                        }
                        break;
                    case 27:
                        $('.ajax-search-result-widget', '.search-button-wrapper').html('');
                        $($widget_search_wrapper).css('display','none');
                        break;
                    case 38:	// UP
                        s_up(wrapper);
                        break;
                    case 40:	// DOWN
                        s_down(wrapper);
                        break;
                }
            });

            function s_up(wrapper) {
                var $item = $('li.selected', wrapper);
                if ($('li', wrapper).length < 2) return;
                var $prev = $item.prev();
                $item.removeClass('selected');
                if ($prev.length) {
                    $prev.addClass('selected');
                }
                else {
                    $('li:last', wrapper).addClass('selected');
                    $prev = $('li:last', wrapper);
                }
                if ($prev.position().top < jQuery('.ajax-search-result',wrapper).scrollTop()) {
                    jQuery('.ajax-search-result',wrapper).scrollTop($prev.position().top);
                }
                else if ($prev.position().top + $prev.outerHeight() > jQuery('.ajax-search-result',wrapper).scrollTop() + jQuery('.ajax-search-result',wrapper).height()) {
                    jQuery('.ajax-search-result',wrapper).scrollTop($prev.position().top - jQuery('.ajax-search-result',wrapper).height() + $prev.outerHeight());
                }
            }

            function s_down(wrapper) {
                var $item = $('li.selected', wrapper);
                if ($('li', wrapper).length < 2) return;
                var $next = $item.next();
                $item.removeClass('selected');
                if ($next.length) {
                    $next.addClass('selected');
                }
                else {
                    $('li:first', wrapper).addClass('selected');
                    $next = $('li:first', wrapper);
                }
                if ($next.position().top < jQuery('.ajax-search-result',wrapper).scrollTop()) {
                    jQuery('.ajax-search-result',wrapper).scrollTop($next.position().top);
                }
                else if ($next.position().top + $next.outerHeight() > jQuery('.ajax-search-result',wrapper).scrollTop() + jQuery('.ajax-search-result',wrapper).height()) {
                    jQuery('.ajax-search-result',wrapper).scrollTop($next.position().top - jQuery('.ajax-search-result',wrapper).height() + $next.outerHeight());
                }
            }

            function s_enter(wrapper) {
                var $item = $('li.selected a', wrapper);
                if ($item.length > 0) {
                    window.location = $item.attr('href');
                }
            }
        },
        search_widget_process: function(control_trigger){
            var $widget_search_wrapper = $('.widget-search-result-wrapper', '.widget-search');

            var wrapper = $(control_trigger).parent().parent().parent();
            $('button i',$(wrapper)).removeClass('fa-search');
            $('button i',$(wrapper)).addClass('fa-spin fa-spinner');

            var keyword = $('input','.widget-search').val();

            $.ajax({
                type: 'POST',
                data: 'action=result_search_product&keyword=' + keyword,
                url: ajaxurl,
                success: function (data) {
                    $('button i',$(wrapper)).removeClass('fa-spin fa-spinner');
                    $('button i',$(wrapper)).addClass('fa-search');
                    var html = '';
                    if (data) {
                        var items = $.parseJSON(data);
                        if (items.length) {
                            html += '<ul>';
                            if (items[0]['id'] == -1) {
                                html += '<li class="selected">' + items[0]['title'] + '</li>';
                            }
                            else {
                                $.each(items, function (index) {
                                    if (index == 0) {
                                        html += '<li class="selected">';
                                    }
                                    else {
                                        html += '<li>';
                                    }

                                    html += '<a href="' + this['guid'] + '">';
                                    html += this['thumb'];
                                    html += this['title'] + '</a>';
                                    html += '<div class="price">' + this['price'] + '</div>';
                                    html += '</li>';
                                });
                            }
                        }
                        else {
                            html = '</ul>';
                        }

                        $('.ajax-search-result-widget', $(wrapper)).css('max-height','360px');
                        $('.widget-search-result-wrapper', $(wrapper)).css('display','block');
                        $('.ajax-search-result-widget', $(wrapper)).html(html);

                        if (keyword.length < 3) {
							$('.ajax-search-result-widget', wrapper).html('<ul><li class="selected">Please fill keyword more than 2 chars to search</li></ul>');
							return;
						}
                        $('.ajax-search-result-widget', $(wrapper)).perfectScrollbar({
                            wheelSpeed: 1,
                            suppressScrollX: true
                        });
                    }
                },
                error: function (data) {
                    $('button i',$(wrapper)).removeClass('fa-spin fa-spinner');
                    $('button i',$(wrapper)).addClass('fa-search');
                }
            });

        },
        search_header_process:function(wrapper){
            var $class_spin =  'fa-spin fa-spinner';
            $('.icon-search-menu span',wrapper).addClass($class_spin);
            var keyword = $('input',wrapper).val();

            $.ajax({
                type: 'POST',
                data: 'action=result_search_product&keyword=' + keyword,
                url: ajaxurl,
                success: function (data) {
                    $('.icon-search-menu span',wrapper).removeClass($class_spin);
                    var html = '';
                    if (data) {
                        var items = $.parseJSON(data);
                        if (items.length) {
                            html += '<ul>';
                            if (items[0]['id'] == -1) {
                                html += '<li class="selected">' + items[0]['title'] + '</li>';
                            }
                            else {
                                $.each(items, function (index) {
                                    if (index == 0) {
                                        html += '<li class="selected">';
                                    }
                                    else {
                                        html += '<li>';
                                    }

                                    html += '<a href="' + this['guid'] + '">';
                                    html += this['thumb'];
                                    html += this['title'] + '</a>';
                                    html += '<div class="price">' + this['price'] + '</div>';
                                    html += '</li>';
                                });
                            }
                        }
                        else {
                            html = '</ul>';
                        }

                        $('.ajax-search-result-widget', wrapper).css('max-height','360px');
                        $('.widget-search-result-wrapper', wrapper).css('display','block');
                        $('.ajax-search-result-widget', wrapper).html(html);

                        if (keyword.length < 3) {
							$('.ajax-search-result-widget', wrapper).html('<ul><li class="selected">Please fill keyword more than 2 chars to search</li></ul>');
							return;
						}
                        $('.ajax-search-result-widget', wrapper).perfectScrollbar({
                            wheelSpeed: 1,
                            suppressScrollX: true
                        });
                    }
                },
                error: function (data) {
                    $('.icon-search-menu span',$(wrapper)).removeClass($class_spin);
                    $('.icon-search-menu span',$(wrapper)).addClass($class_close);
                }
            });
        },
        product_mouseover :function(){
        	//Product block hover
			if($('.product-mouseover').length > 0){
				$(window).resize(function(){   
					if($(window).width() >992) {
						if($(".product-block-hover").length == 0) {
							$("body").append('<div class="woocommerce woo-product-popup"><div class="product-mouseover"><div class="product"><div class="product-block-hover" style="display: none; z-index:1;"></div></div></div></div>');
						}
						$(".product-mouseover .product .product-block").mouseover(function() {
							$(".product-block-hover").children().remove();
							$(".product-block-hover").append($(this).html());
							$(".woo-product-popup").css('width', parseInt($(this).width() + 20) + 'px');
							$(".woo-product-popup").css('top', parseInt($(this).offset().top - 20) + 'px');
							$(".woo-product-popup").css('left', parseInt($(this).offset().left - 10) + 'px');
							$(".product-block-hover").css('display', 'block');
							Core.product_quick_view();
							Core.tooltip();
						});
						$(".product-block-hover").mouseover(function() {
							$(".product-block-hover").css({'display': 'block'});
						});
					} else {
						$(".product-block-hover").remove();
					}			
				});	
				if($(window).width() >992) {
					if($(".product-block-hover").length == 0) {
						$("body").append('<div class="woocommerce woo-product-popup"><div class="product-mouseover"><div class="product"><div class="product-block-hover" style="display: none; z-index:1;"></div></div></div></div>');
					}
					$(".product-mouseover .product .product-block").mouseover(function() {
						$(".product-block-hover").children().remove();
						$(".product-block-hover").append($(this).html());
						$(".woo-product-popup").css('width', parseInt($(this).width() + 20) + 'px');
						$(".woo-product-popup").css('top', parseInt($(this).offset().top - 20) + 'px');
						$(".woo-product-popup").css('left', parseInt($(this).offset().left - 10) + 'px');
						$(".product-block-hover").css('display', 'block');
						Core.product_quick_view();
						Core.tooltip();
					});
					$(".product-block-hover").mouseover(function() {
						$(".product-block-hover").css({'display': 'block'});
					});
				}
			}
        },
        tooltip: function () {
			if ($().tooltip) 
			{
				$('[data-toggle="tooltip"]').tooltip();
			}
		}
	};
	jQuery(document).ready(function () {
		Core.initialize();
	});
})(jQuery);