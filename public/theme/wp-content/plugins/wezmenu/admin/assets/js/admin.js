(function($) {
	"use strict";
	var WEZMENU = {
		initialize: function() {
			WEZMENU.add_wezmenu_to_wpmenu();
			WEZMENU.event();
			WEZMENU.scroll_panel_right(true);
			WEZMENU.process_media();
		},

		add_wezmenu_to_wpmenu: function() {
			$('ul.menu > li.menu-item').each(function(){
				var menu_id = parseInt($(this).attr('id').replace('menu-item-',''), 10);
				$('> .menu-item-bar > .menu-item-handle > span.item-title > span.menu-item-title', this).append('<span class="wezmenu-item-config" data-id="' + menu_id + '"><i class="fa fa-cogs"></i> WEZMENU <i class="fa fa-warning"></i></span>');
			});
			$('ul.menu > li.menu-item .wezmenu-item-config').click(function(){
				var menu_id = parseInt($(this).attr('data-id'), 10);
				WEZMENU.open_wezmenu_panel(menu_id);
			});
		},
		open_wezmenu_panel: function(menu_id) {
			if ($('.wezmenu-header .wezmenu-config-panel-save > i').hasClass('fa-spinner')) {
				return;
			}
			$('.wezmenu-config-panel-wrapper').attr('data-id', menu_id);
			var menu_item = wezmenu_menu_item_data[menu_id];
			if (menu_item['nosave-change'] == 1) {
				$('.wezmenu-header .wezmenu-config-panel-save i').attr('class','fa fa-warning');
			}
			else {
				$('.wezmenu-header .wezmenu-config-panel-save i').attr('class','fa fa-save');
			}
			$('.wezmenu-header > h2 > span').html(menu_item['general-title']);
			for (var key in menu_item) {
				var $menu_data = $('#wezmenu_config_' + key);
				if ($menu_data.length > 0) {
					if ($menu_data.hasClass('wez-checkbox')) {
						$menu_data.prop( "checked", menu_item[key] == $menu_data.val());
					}
					else {
						$menu_data.val(menu_item[key]);
					}
					if ($menu_data.hasClass('wez-icon')) {
						$('> i', $($menu_data).parent()).attr('class','fa ' + menu_item[key]);
					}
				}

				if ($menu_data.hasClass('wez-color-picker')) {
					$('.wp-color-result',$menu_data.parent().parent()).css('background-color',menu_item[key]);
				}
			}
			if (menu_item['nosave-type'] != 'custom') {
				$('#wezmenu_config_general-url').attr('readonly','');
			}
			else {
				$('#wezmenu_config_general-url').removeAttr('readonly');
			}
			if (!$('.wezmenu-config-panel-wrapper').hasClass('in')) {
				WEZMENU.show_wezmenu_panel();
			}
		},
		show_wezmenu_panel: function() {
			$('.wezmenu-config-panel-wrapper').addClass('in');
		},
		hide_wezmenu_panel: function() {
			$('.wezmenu-icon-popup').fadeOut();
			$('.wezmenu-config-panel-wrapper').removeClass('in');
		},
		event: function() {
			WEZMENU.rel_section_click();
			WEZMENU.wezmenu_config_panel_close_click();
			WEZMENU.wezmenu_icon_popup_event();
			WEZMENU.wp_color_picker();
			WEZMENU.wp_input_change();
			WEZMENU.window_keyup();
			WEZMENU.save_config_panel();
			WEZMENU.reset();
		},
		reset: function() {
			$('.wezmenu-config-panel-wrapper li.wez-reset').click(function(){

				var menu_id = $('.wezmenu-config-panel-wrapper').attr('data-id');

				$('> i', this).attr('class','fa fa-spinner fa-spin');
				var menu_item = wezmenu_menu_item_data[menu_id];

				for (var key in wezmenu_menu_item_default) {
					if ((key.indexOf('nosave-') === 0) || (key.indexOf('general-') === 0)) continue;
					menu_item[key] = wezmenu_menu_item_default[key];
				}

				for (var key in menu_item) {
					var $menu_data = $('#wezmenu_config_' + key);
					if ($menu_data.length > 0) {
						if ($menu_data.hasClass('wez-checkbox')) {
							$menu_data.prop( "checked", menu_item[key] == $menu_data.val());
						}
						else {
							$menu_data.val(menu_item[key]);
						}
						if ($menu_data.hasClass('wez-icon')) {
							$('> i', $($menu_data).parent()).attr('class','fa ' + menu_item[key]);
						}
					}

					if ($menu_data.hasClass('wez-color-picker')) {
						$('.wp-color-result',$menu_data.parent().parent()).css('background-color',menu_item[key]);
					}
				}
				$('> i', this).attr('class','fa fa-refresh');
				$('.wezmenu-header .wezmenu-config-panel-save i').attr('class','fa fa-warning');
				$('span.menu-item-title .wezmenu-item-config[data-id="' + menu_id + '"]').addClass('is-change');
			});
		},
		save_config_panel: function() {
			$('.wezmenu-header .wezmenu-config-panel-save').click(function() {
				if ($('.wezmenu-header .wezmenu-config-panel-save > i').hasClass('fa-spinner')) {
					return;
				}
				$('> i', this).attr('class','fa fa-spinner fa-spin');
				$('.wezmenu-config-panel-right').addClass('wezmenu-saving');

				var menu_id = $('.wezmenu-config-panel-wrapper').attr('data-id');
				var data_post = {
					id: menu_id,
					config: wezmenu_menu_item_data[menu_id],
					action:'wezmenu_save_config'
				};
				var $this = $(this);
				$.ajax({
					url:wezmenu_meta.ajax_url,
					type   : 'POST',
					data   : data_post,
					dataType : 'json',
					success: function(data) {
						$('.wezmenu-config-panel-right').removeClass('wezmenu-saving');
						if (data.code < 0) {
							$('> i', $this).attr('class','fa fa-save');
							alert(data.message);
							return;
						}
						wezmenu_menu_item_data[menu_id]['nosave-change'] = 0;
						$('span.menu-item-title .wezmenu-item-config[data-id="' + menu_id + '"]').removeClass('is-change');
						$('> i', $this).attr('class','fa fa-check');
						//set menu value
						if (wezmenu_menu_item_data[menu_id]['nosave-type'] == 'custom') {
							$('#edit-menu-item-url-' + menu_id).val(wezmenu_menu_item_data[menu_id]['general-url']);
						}
						$('#edit-menu-item-title-' + menu_id).val(wezmenu_menu_item_data[menu_id]['general-title']);
						$('#edit-menu-item-attr-title-' + menu_id).val(wezmenu_menu_item_data[menu_id]['general-attr-title']);
						$('#edit-menu-item-classes-' + menu_id).val(wezmenu_menu_item_data[menu_id]['general-classes']);
						$('#edit-menu-item-xfn-' + menu_id).val(wezmenu_menu_item_data[menu_id]['general-xfn']);
						$('#edit-menu-item-description-' + menu_id).val(wezmenu_menu_item_data[menu_id]['general-description']);
						$('#edit-menu-item-target-' + menu_id).prop( "checked", wezmenu_menu_item_data[menu_id]['general-target'] == $('#edit-menu-item-target-' + menu_id).val());
					},
					error: function(data) {
						$('.wezmenu-config-panel-right').removeClass('wezmenu-saving');
						$('> i', $this).attr('class','fa fa-warning');
					}
				})
			});
		},
		wezmenu_config_panel_close_click: function() {
			$('.wezmenu-header > h2 .wezmenu-config-panel-close').click(function(){
				WEZMENU.hide_wezmenu_panel();
			});
		},
		window_keyup: function() {
			$(window).keyup(function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 27) {
					if ($('.wezmenu-config-panel-wrapper').hasClass('in')) {
						WEZMENU.hide_wezmenu_panel();
					}
					else {
						var menu_id = $('.wezmenu-config-panel-wrapper').attr('data-id');
						if (typeof (menu_id) != "undefined") {
							WEZMENU.show_wezmenu_panel();
						}
					}

				}
			});
		},
		wp_input_change: function() {
			$('.wez-input').change(function(){
				WEZMENU.process_input_change(this);
			});
		},
		wp_color_picker: function() {
			$('.wezmenu-config-panel-wrapper').find( '.wez-color-picker' ).wpColorPicker({
				'change': function(event, data, ui){
					setTimeout(function(){
						WEZMENU.process_input_change(event.target);
					}, 200)

				},
				'clear': function(event, data, ui){
					setTimeout(function(){
						WEZMENU.process_input_change($('.wez-input', $(event.target).parent())[0]);
					}, 200)
				}
			});
		},

		process_input_change: function(target){
			var menu_id = $('.wezmenu-config-panel-wrapper').attr('data-id');
			wezmenu_menu_item_data[menu_id]['nosave-change'] = 1;
			$('.wezmenu-header .wezmenu-config-panel-save i').attr('class','fa fa-warning');
			$('span.menu-item-title .wezmenu-item-config[data-id="' + menu_id + '"]').addClass('is-change');
			var item_name = $(target).attr('name');
			if ($(target).hasClass('wez-checkbox')) {
				wezmenu_menu_item_data[menu_id][item_name] = $(target).prop( "checked" ) ? $(target).val() : '';
			}
			else {
				wezmenu_menu_item_data[menu_id][item_name] = $(target).val();
			}
		},

		scroll_panel_right: function(isInit) {
			var panel_content_height = $('.wezmenu-config-panel-right-inner').outerHeight();
			var panel_wrapper_height = $('.wezmenu-config-panel-right').height();
			var panel_scroll_height = $('.wezmenu-panel-scroll-wrapper').height() - 2;
			$('.wezmenu-config-panel-right-inner').css('top', '0');
			if (panel_content_height > panel_wrapper_height) {
				$('.wezmenu-config-panel-right').addClass('show-scroll');
				$('.wezmenu-panel-drag').height( ((panel_wrapper_height * 1.0 /panel_content_height) * panel_scroll_height) + 'px');
				$('.wezmenu-panel-drag').css('top','0');
			}
			else {
				$('.wezmenu-config-panel-right').removeClass('show-scroll');
			}

			if (isInit) {
				$('.wezmenu-panel-drag').draggable({
					axis: "y", containment: "parent",
					drag: function () {
						var panel_content_height = $('.wezmenu-config-panel-right-inner').outerHeight();
						var panel_wrapper_height = $('.wezmenu-config-panel-right').height();
						var panel_scroll_height = $('.wezmenu-panel-scroll-wrapper').height() - 2;

						var top_drag = $('.wezmenu-panel-drag').position().top;
						var drag_height = $('.wezmenu-panel-drag').height();
						var top_panel_content = (panel_wrapper_height - panel_content_height) * top_drag * 1.0 / (panel_scroll_height - drag_height);
						$('.wezmenu-config-panel-right-inner').css('top', top_panel_content  + 'px');
					}
				});

				$('.wezmenu-config-panel-right').mousewheel(function (event, delta) {
					if (!$('.wezmenu-config-panel-right').hasClass('show-scroll')) {
						return;
					}
					event.preventDefault();
					var panel_content_height = $('.wezmenu-config-panel-right-inner').outerHeight();
					var panel_wrapper_height = $('.wezmenu-config-panel-right').height();
					var panel_scroll_height = $('.wezmenu-panel-scroll-wrapper').height() - 2;

					var top_drag = $('.wezmenu-panel-drag').position().top;
					var drag_height = $('.wezmenu-panel-drag').height();
					top_drag -= delta * 10;
					if (top_drag < 0) {
						top_drag = 0;
					}
					if (top_drag > (panel_scroll_height - drag_height)) {
						top_drag = (panel_scroll_height - drag_height);
					}
					$('.wezmenu-panel-drag').css('top', top_drag  + 'px');

					var top_panel_content = (panel_wrapper_height - panel_content_height) * top_drag * 1.0 / (panel_scroll_height - drag_height);
					$('.wezmenu-config-panel-right-inner').css('top', top_panel_content  + 'px');

				});
			}
		},
		rel_section_click:function() {
			$('.wezmenu-config-panel-left > ul > li[rel-section]').click(function(){
				$('.wezmenu-config-panel-right-inner > section').removeClass('active');
				var section_id = $(this).attr('rel-section');
				$('section#' + section_id).addClass('active');

				$('.wezmenu-config-panel-left > ul > li[rel-section]').removeClass('active');
				$(this).addClass('active');
				WEZMENU.scroll_panel_right(false);
			});

		},
		process_media: function() {
			wezmenu_media_init('.wez-media-image','.wez-media-button', null, function(target, old_url){
				if ($(target).val() != old_url) {
					WEZMENU.process_input_change(target);
				}
			});
		},
		wezmenu_icon_popup_event: function(){
			$('.wez-icon-wrapper').click(function(event){
				if ($(event.target).closest('.wez-icon-remove').length == 1) {
					return;
				}
				var popup_top = $('.wezmenu-config-panel-right').position().top + $('.wezmenu-config-panel-right-inner').position().top + jQuery(this).position().top;
				var popup_left = $('.wezmenu-config-panel-right').position().left + $('.wezmenu-config-panel-right-inner').position().left + jQuery(this).position().left + jQuery(this).outerWidth();
				var data_rel = $(this).attr('data-rel');
				$('.wezmenu-icon-popup').attr('data-rel',data_rel);
				$('.wezmenu-icon-popup').css('top', popup_top + 'px');
				$('.wezmenu-icon-popup').css('left',(popup_left)+ 'px');
				$('li', '.wezmenu-icon-popup-content').show();
				$('.wezmenu-icon-popup-header > input').val('');
				$('.wezmenu-icon-popup').fadeIn();

			});
			$('.wezmenu-icon-popup-header > i.fa-remove').click(function(){
				$('.wezmenu-icon-popup').fadeOut();
			});
			$('.wezmenu-icon-popup-content > ul > li').click(function(){
				var icon_value = $('i', this).attr('class').replace('fa ','');
				var data_rel = $('.wezmenu-icon-popup').attr('data-rel');
				$('.wez-icon-wrapper[data-rel="' + data_rel + '"] > i').attr('class', 'fa ' + icon_value);

				var old_icon_value = $('.wez-icon-wrapper[data-rel="' + data_rel + '"] > input').val();
				$('.wez-icon-wrapper[data-rel="' + data_rel + '"] > input').val(icon_value);
				if (old_icon_value != icon_value){
					WEZMENU.process_input_change($('.wez-icon-wrapper[data-rel="' + data_rel + '"] > input'));
				}
				$('.wezmenu-icon-popup').fadeOut();
			});
			$('.wez-icon-remove').click(function(){
				if ($('> input', $(this).parent()).val()!=''){
					$('> input', $(this).parent()).val('');
					$('> i', $(this).parent()).attr('class','');
					WEZMENU.process_input_change($('> input', $(this).parent()));
				}
			});
			$('.wezmenu-icon-popup .wezmenu-icon-remove').click(function(){
				var data_rel = $('.wezmenu-icon-popup').attr('data-rel');
				$('.wez-icon-wrapper[data-rel="' + data_rel + '"] > i').attr('class', '');

				if ($('.wez-icon-wrapper[data-rel="' + data_rel + '"] > input').val()!=''){
					WEZMENU.process_input_change($('.wez-icon-wrapper[data-rel="' + data_rel + '"] > input'));
				}
				$('.wez-icon-wrapper[data-rel="' + data_rel + '"] > input').val('');
				$('.wezmenu-icon-popup').fadeOut();
			});
			$('.wezmenu-icon-popup-header > input').keyup(function(){
				var filter = $(this).val();
				$('li', '.wezmenu-icon-popup-content').each(function(){
					if ($(this).attr('title').search(new RegExp(filter, "i")) < 0) {
						$(this).hide();
					}
					else {
						$(this).show();
					}
				});
			});
		}
	}
	$(document).ready(function(){
		WEZMENU.initialize();
	});
})(jQuery);