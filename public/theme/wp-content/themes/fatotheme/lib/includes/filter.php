<?php
if (!function_exists('fatotheme_search_form')) {
	function fatotheme_search_form($form)
	{
		$form = '<form data-role="search" class="lane-search-form" method="get" id="searchform" action="' . esc_url( home_url( '/' ) ) . '">
                <input type="text" value="' . get_search_query() . '" name="s" id="s"  placeholder="' . esc_html__("Search...", 'fatotheme') . '">
                <button type="submit"><i class="fa fa-search"></i></button>
     		</form>';
		return $form;
	}

	add_filter('get_search_form', 'fatotheme_search_form');
}
if (!function_exists('fatotheme_search_posts_filter')) {
	function fatotheme_search_posts_filter($query)
	{
		if (!is_admin() && $query->is_search && !is_post_type_archive('product')) {
			$query->set('post_type', array('post'));
		}
		return $query;
	}

	add_filter('pre_get_posts', 'fatotheme_search_posts_filter');
}
add_filter('fatotheme_megamenu_toggle_inner_after', 'fatotheme_header_menu_mobile_search_filter');
function fatotheme_header_menu_mobile_search_filter($arg)
{
	return '<div class="toggle-inner-search">
               <div class="search-button-wrapper">
                    <input type="text" placeholder="'.esc_attr__('Type your search here', 'fatotheme').'" class="input-search">
                    <a href="#" class="icon-search-menu"><span class="fa fa-search"></span></a>
                    <div class="widget-search-result-wrapper" style="display: none;">
                        <div class="ajax-search-result-widget"></div>
                    </div>
                </div>
	        </div>';
}