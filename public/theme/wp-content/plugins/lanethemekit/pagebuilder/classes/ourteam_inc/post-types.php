<?php
function lane_register_ourteam_post_type() 
{
    $labels = array(
        'name' => esc_html__('Our Team', 'lanethemekit'),
        'singular_name' => esc_html__('Our Team', 'lanethemekit'),
        'add_new' => esc_html__('Add New', 'lanethemekit'),
        'add_new_item' => esc_html__('Add New Our Team', 'lanethemekit'),
        'edit_item' => esc_html__('Edit Our Team', 'lanethemekit'),
        'new_item' => esc_html__('New Our Team', 'lanethemekit'),
        'all_items' => esc_html__('All Our Team', 'lanethemekit'),
        'view_item' => esc_html__('View Our Team', 'lanethemekit'),
        'search_items' => esc_html__('Search Our Team', 'lanethemekit'),
        'not_found' => esc_html__('No Our Team found', 'lanethemekit'),
        'not_found_in_trash' => esc_html__('No Our Team found in Trash', 'lanethemekit'),
        'parent_item_colon' => '',
        'menu_name' => esc_html__('Our Team', 'lanethemekit')
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'process' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor','revisions', 'thumbnail')
    );

    register_post_type( LANE_POST_TYPE_NAME, $args);

}
add_action( 'init', 'lane_register_ourteam_post_type');

/**
 * customize UI interaction messages
 * eg: Changes "Post published" to "Pricing Table published"
 * Code template from http://wp.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/
 * I removed the "view post" hyperlinks from notification messages since they are pointless
 *
 * @param  [type] $messages [description]
 * @return [type]           [description]
 */
function lane_ourteam_updated_interaction_messages( $messages ) 
{
    global $post, $post_ID;
    $messages[LANE_POST_TYPE_NAME] = array(
        0 => '',
        1 => sprintf( __('Our Team saved. <a href="%s">View Our Team</a>.', 'lanethemekit'), esc_url( get_permalink($post_ID) ) ),
        2 => esc_html__('Custom field updated.', 'lanethemekit'),
        3 => esc_html__('Custom field deleted.', 'lanethemekit'),
        4 => esc_html__('Our Team saved.', 'lanethemekit'),
        5 => isset($_GET['revision']) ? sprintf( __('Our Team restored to revision from %s', 'lanethemekit'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Our Team saved. <a href="%s">View Our Team</a>', 'lanethemekit'), esc_url( get_permalink($post_ID) ) ),
        7 => esc_html__('Our Team saved.', 'lanethemekit'),
        8 => esc_html__('Our Team submitted.', 'lanethemekit'),
        9 => sprintf( __('Process scheduled for: <strong>%1$s</strong>.', 'lanethemekit'), date_i18n( __( 'M j, Y @ G:i','lanethemekit' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => esc_html__('Our Team saved.', 'lanethemekit'),
    );
    return $messages;
}
add_filter( 'post_updated_messages', 'lane_ourteam_updated_interaction_messages' );


/**
 * changes the "Enter title here" to "Enter pricing table name here'" for pricing-table post type
 */
function lane_ourteam_custom_rewrites($translation, $text, $domain)
{
    global $post;

    if ( ! isset( $post->post_type ) ) {
        return $translation;
    }

    $translations = get_translations_for_domain($domain);
    $translation_array = array();

    switch ($post->post_type) {
        case LANE_POST_TYPE_NAME: // enter your post type name here
            $translation_array = array(
                'Enter title here' => 'Enter member name here'
            );
            break;
    }

    if (array_key_exists($text, $translation_array)) {
        return $translations->translate($translation_array[$text]);
    }
    return $translation;
}
add_filter('gettext', 'lane_ourteam_custom_rewrites', 10, 4);


add_action('admin_enqueue_scripts', 'lane_ourteam_enqueue' );
function lane_ourteam_enqueue()
{
    $screen = get_current_screen();
    if ( LANE_POST_TYPE_NAME != $screen->id ) {
        return;
    }
    wp_enqueue_script('jquery-ui-accordion');
}