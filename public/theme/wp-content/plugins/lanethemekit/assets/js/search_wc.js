function getParameterByName(name, string) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(string);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
(function($) {
	"use strict";
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