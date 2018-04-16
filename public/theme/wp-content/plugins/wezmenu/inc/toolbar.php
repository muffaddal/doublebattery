<?php
add_action( 'admin_bar_menu', 'wezmenu_add_toolbar_items', 100 );
function wezmenu_get_toolbar_icon($icon_name) {
	return '<i class="fa fa-'. esc_attr($icon_name) . '"></i>';
}
function wezmenu_add_toolbar_items($admin_bar) {
	if( !current_user_can( 'manage_options' ) ) return;

	$admin_bar->add_node( array(
		'id'    => 'wezmenutoolbar',
		'title' => '<span class="ab-icon"></span><span>' . __('WezMenu','wezmenu') . '</span>',
		'href'  => admin_url( 'themes.php?page=wezmenu-settings' ),
		'meta'  => array(
			'title' => __( 'WezMenu' , 'wezmenu' ),
		),
	));

	$admin_bar->add_node( array(
		'id'    => 'wezmenu_settings',
		'parent' => 'wezmenutoolbar',
		'title' => __( 'WezMenu Settings' , 'wezmenu' ),
		'href'  => admin_url( 'themes.php?page=wezmenu-settings' )
	));

	$admin_bar->add_node( array(
		'id'    => 'wezmenu_menu_edit',
		'parent' => 'wezmenutoolbar',
		'title' => __( 'Edit Menus' , 'wezmenu' ),
		'href'  => admin_url( 'nav-menus.php' )
	));
	$menus = wp_get_nav_menus( array('orderby' => 'name') );
	foreach( $menus as $menu ){
		$admin_bar->add_node( array(
			'id'    	=> 'wezmenu_menu_edit_'.$menu->slug,
			'parent' 	=> 'wezmenu_menu_edit',
			'title' 	=> $menu->name,
			'href'  	=> admin_url( 'nav-menus.php?action=edit&menu='.$menu->term_id ),
			'meta'  	=> array(
				'title' => __('Configure' , 'wezmenu' ) . ' '. $menu->name,
				'target' => '_blank',
				'class' => ''
			),
		));
	}

	$admin_bar->add_node( array(
		'id'    => 'wezmenu_menu_assign',
		'parent' => 'wezmenutoolbar',
		'title' => __( 'Assign Menus' , 'wezmenu' ),
		'href'  => admin_url( 'nav-menus.php?action=locations' )
	));
}