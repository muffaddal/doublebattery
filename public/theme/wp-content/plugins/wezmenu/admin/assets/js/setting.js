(function($) {
	"use strict";
	var WEZMENU_SETTING = {
		initialize: function() {
			WEZMENU_SETTING.event();
		},

		event: function() {
			WEZMENU_SETTING.group_setting_event();
			WEZMENU_SETTING.open_setting_add_menu();
		},
		group_setting_event: function() {
			$('.wezmenu-settings .setting-left li[data-ref]').click(function(){
				if ($(this).hasClass('active')) {
					return;
				}
				var data_ref =  $(this).attr('data-ref');
				console.log(data_ref);
				$('.wezmenu-settings .setting-left li[data-ref]').removeClass('active');
				$(this).addClass('active');
				$('.wezmenu-settings .setting-right table[data-ref]').removeClass('active');
				$('.wezmenu-settings .setting-right table[data-ref="' + data_ref + '"]').addClass('active');
			});
			$('#wezmenu-save-setting').click(function(){
				$('#wezmenu-save-setting i').attr('class', 'fa fa-spin fa-spinner');
				var data_post = $("#wezmenu_settings").serialize();
				$.ajax({
					url:wezmenu_meta.ajax_url,
					type   : 'POST',
					data   : data_post,
					dataType : 'json',
					success: function(data) {
						$('#wezmenu-save-setting i').attr('class', 'fa fa-save');
						if (data.code < 0) {
							alert(data.message);
							return;
						}
					},
					error: function(data) {
						$('#wezmenu-save-setting i').attr('class', 'fa fa-save');
					}
				});
			});
			$('#wezmenu-delete-setting').click(function() {
				if (!confirm(wezmenu_meta.delete_setting_confirm)) {
					return;
				}
				$('#wezmenu-delete-setting i').attr('class', 'fa fa-spin fa-spinner');
				var data_post = {
					action: 'wezmenu_delete_setting',
					menu_slug: $('#wezmenu_menu_slug').val()
				};
				$.ajax({
					url:wezmenu_meta.ajax_url,
					type   : 'POST',
					data   : data_post,
					dataType : 'json',
					success: function(data) {
						if (data.code < 0) {
							$('#wezmenu-delete-setting i').attr('class', 'fa fa-remove');
							alert(data.message);
							return;
						}
						window.location.href = window.location.origin + window.location.pathname + '?page=wezmenu-settings';
					},
					error: function(data) {
						$('#wezmenu-delete-setting i').attr('class', 'fa fa-remove');
					}
				});
			});
		},
		open_setting_add_menu: function() {
			$('#setting-add-menu').click(function(){
				$('#wezmenu-setting-popup').fadeIn();
			});
			$('#setting-add-menu-close').click(function() {
				$('#wezmenu-setting-popup').fadeOut();
			});
			$('#wezmenu-create-button').click(function() {
				if ($('#setting-add-menu-close').hasClass('fa-spin')) {
					return;
				}
				if (($('#wezmenu-select-create').val() == null) || ($('#wezmenu-select-create').val() == '')) {
					return;
				}
				var data_post = {
					menu_slug: $('#wezmenu-select-create').val(),
					action:'wezmenu_setting_create'
				};
				$('#setting-add-menu-close').attr('class', 'fa fa-spin fa-spinner');
				$.ajax({
					url:wezmenu_meta.ajax_url,
					type   : 'POST',
					data   : data_post,
					dataType : 'json',
					success: function(data) {
						if (data.code < 0) {
							$('#setting-add-menu-close').attr('class', 'fa fa-close');
							alert(data.message);
							return;
						}
						window.location.href = window.location.origin + window.location.pathname + '?page=wezmenu-settings&menu=' + $('#wezmenu-select-create').val();
					},
					error: function(data) {
						$('#setting-add-menu-close').attr('class', 'fa fa-close');
					}
				});
			});
		}

	}
	$(document).ready(function(){
		WEZMENU_SETTING.initialize();
	});
})(jQuery);