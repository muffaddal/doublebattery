<?php
/**
 * Add the features meta box
 * @var [type]
 */
global $ourteam_metabox;

$ourteam_metabox = new WPAlchemy_MetaBox(array
(
    'id' => 'lane_ourteam_settings',
    'title' => esc_html__('Our Team Social Settings', 'lanethemekit'),
    'template' => LANE_PLUGIN_PATH . 'ourteam_inc/metaboxes/metabox.php',
    'types' => array(LANE_POST_TYPE_NAME),
    'autosave' => TRUE,
    'priority' => 'high',
    'context' => 'normal',
    'hide_editor' => TRUE
));

