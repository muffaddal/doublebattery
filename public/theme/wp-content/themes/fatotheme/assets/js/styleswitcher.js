/* Style Switcher JS */
(function($) {
	"use strict";
	//Cookies
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
		}
		return "";
	}
	function removeCookie(name) {
	    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	}
	function removeColorClassOf(element){
		jQuery(element).removeClass('green-bg blue-bg orange-bg navy-bg yellow-bg peach-bg red-bg beige-bg pink-bg cyan-bg celadon-bg brown-bg cherry-bg gray-bg purple-bg dark-bg');
	}
	function removeImageClassOf(element){
		jQuery(element).removeClass('bg0 bg1 bg2 bg3 bg4 bg5 bg6 bg7 bg8 bg9 bg10 bg11 bg12 bg13 bg14 bg15 bg16 bg17 bg18 bg19 bg20 bg21 bg22 bg23 bg24 bg25 bg26 bg27 bg28 bg29 bg30');
	}
	jQuery(window).ready(function(){
		var orgWrapperClass = jQuery('.page-wrapper').attr('class');
		
		//Toggle switcher panel
		jQuery('.stoggler').on('click',function(){
			if(jQuery('.style-switcher').hasClass('open')) {
				jQuery('.style-switcher').removeClass('open');
				jQuery('.style-switcher .stoggler i').removeClass('fa-close');
				jQuery('.style-switcher .stoggler i').addClass('fa-cog');
			} else {
				jQuery('.style-switcher').addClass('open');
				jQuery('.style-switcher .stoggler i').removeClass('fa-cog');
				jQuery('.style-switcher .stoggler i').addClass('fa-close');
			}
		});
		
		//Load layout from cookie
		var pageLayout = getCookie('page_layout');
		if(pageLayout=='full') {
			jQuery('.page-wrapper').removeClass('box-layout');
			jQuery('body').removeClass('boxed');
			jQuery('.slayout').val('full');
		}
		if(pageLayout=='box') {
			jQuery('.page-wrapper').addClass('box-layout');
			jQuery('body').addClass('boxed');
			jQuery('.slayout').val('box');
		}
		//Change layout
		jQuery('.slayout').change(function(){
			jQuery('.slayout option:selected').each(function() {
				if(jQuery(this).val()=='box') {
					jQuery('.page-wrapper').addClass('box-layout');
					jQuery('body').addClass('boxed');
				}
				if(jQuery(this).val()=='full') {
					jQuery('.page-wrapper').removeClass('box-layout');
					jQuery('body').removeClass('boxed');
				}
				setCookie('page_layout', jQuery(this).val(), 1);
			});
		});
		// Switcher Color
    	jQuery('.switcher-color .color').click(function(){
      	var datastyle = jQuery(this).attr('data-style');
      	jQuery('head').append("<link class='theme-switcher-color' rel='stylesheet' href='"+datastyle+"'  type='text/css' />");
      	if ((jQuery.cookie('data-style') != null) && (jQuery.cookie('data-style') != datastyle)){
        	jQuery.cookie('data-style', null, { path: '/' });
      	}
      	jQuery.cookie('data-style',datastyle,{path: '/'});
      	jQuery('.switcher-color .color').removeClass('checked');
      	jQuery(this).addClass('checked');
    	});
    	if (jQuery.cookie('data-style') != null){
      		jQuery('head').append("<link class='theme-switcher-color' rel='stylesheet' href='"+jQuery.cookie('data-style')+"'  type='text/css' />");
    	};
		//Load class from cookie
		var bgClass = getCookie('background_class');
		var bgImageClass = getCookie('backgroundimage_class');
		if(bgClass!='' || bgImageClass!='') {
			jQuery('body').addClass(bgClass);
			jQuery('body').addClass(bgImageClass);
		}
		//Change class
		jQuery('#bgsolid a').each(function(){
			jQuery(this).on('click',function(event){
				event.preventDefault();
				
				var pageLayout = jQuery('.slayout').val();
				if(pageLayout!='box') {
					jQuery('.page-wrapper').addClass('box-layout');
					jQuery('.slayout').val('box');
				}
				
				var bgClass = jQuery(this).attr('class');
				
				removeColorClassOf('body');
				
				jQuery('body').addClass(bgClass);
				setCookie('background_class', bgClass, 1);
				setCookie('page_layout', 'box', 1);
			});
		});
		//Change class image
		jQuery('#bg a').each(function(){
			jQuery(this).on('click',function(event){
				event.preventDefault();
				
				var pageLayout = jQuery('.slayout').val();
				if(pageLayout!='box') {
					jQuery('.page-wrapper').addClass('box-layout');
					jQuery('.slayout').val('box');
				}
				
				var bgImageClass = jQuery(this).attr('class');
				
				removeImageClassOf('body');
				
				jQuery('body').addClass(bgImageClass);
				setCookie('backgroundimage_class', bgImageClass, 1);
				setCookie('page_layout', 'box', 1);
			});
		});
		//Reset
		jQuery('#resetpreview').on('click',function(event){
			event.preventDefault();
			
			removeColorClassOf('body');
			removeImageClassOf('body');
			setCookie('background_class', '', 1);
			setCookie('backgroundimage_class', '', 1);
			jQuery('.theme-switcher-color').remove();
			$.removeCookie('data-style', { path: '/' });
			jQuery('.page-wrapper').removeClass('box-layout');
			jQuery('body').removeClass('boxed');
			jQuery('.page-wrapper').addClass(orgWrapperClass);
			jQuery('.slayout').val('');
			setCookie('page_layout', '', 1);
		});
	});
})(jQuery);