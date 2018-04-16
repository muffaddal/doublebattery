<?php
function lane_register_footer()
{
  $labels = array(
    'name' => esc_html__( 'Footer Builder', 'lanethemekit' ),
    'singular_name' => esc_html__( 'Footer', 'lanethemekit' ),
    'add_new' => esc_html__( 'Add New Footer', 'lanethemekit' ),
    'add_new_item' => esc_html__( 'Add New Footer', 'lanethemekit' ),
    'edit_item' => esc_html__( 'Edit Footer', 'lanethemekit' ),
    'new_item' => esc_html__( 'New Footer', 'lanethemekit' ),
    'view_item' => esc_html__( 'View Footer', 'lanethemekit' ),
    'search_items' => esc_html__( 'Search Footers', 'lanethemekit' ),
    'not_found' => esc_html__( 'No Footers found', 'lanethemekit' ),
    'not_found_in_trash' => esc_html__( 'No Footers found in Trash', 'lanethemekit' ),
    'parent_item_colon' => esc_html__( 'Parent Footer:', 'lanethemekit' ),
    'menu_name' => esc_html__( 'Footers Builder', 'lanethemekit' ),
  );

  $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'description' => 'List Footer',
      'supports' => array( 'title', 'editor' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'show_in_nav_menus' => false,
      'publicly_queryable' => false,
      'exclude_from_search' => false,
      'has_archive' => false,
      'query_var' => true,
      'can_export' => true,
      'rewrite' => false
  );
  register_post_type( 'footer', $args );

  if($options = get_option('wpb_js_content_types'))
  {
    $check = true;
    foreach ($options as $key => $value) 
    {
      if($value=='footer') $check=false;
    }
    if($check)
      $options[] = 'footer';
  }
  else
  {
    $options = array('page','footer');
  }
  update_option( 'wpb_js_content_types',$options );

}
add_action('init','lane_register_footer');