<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
/* Setup actions */
add_action('admin_footer-edit.php', 'lane_ourteam_add_custom_bulk_action');
function lane_ourteam_add_custom_bulk_action() 
{
    global $post_type;

    if($post_type == LANE_POST_TYPE_NAME) 
    {
        $nonce = wp_create_nonce("lane_ourteam_clone_table_nonce");
        $link = admin_url('admin-ajax.php?action=lane_ourteam_clone_table&nonce='.$nonce);
        ?>
        <script type="text/javascript">
            <!--
            jQuery(document).ready(function() {
                jQuery('<option>').val('eptclone').text('<?php esc_html_e('Make a Copy', 'lanethemekit')?>').insertAfter("select[name='action'] option[value='edit']");
                jQuery('<option>').val('eptclone').text('<?php esc_html_e('Make a Copy', 'lanethemekit')?>').insertAfter("select[name='action2'] option[value='edit']");
                jQuery('.row-actions').each(function() {
                    var post_edit_url = jQuery(this).find('.edit a').attr('href');
                    var clone_html = '<span class="eptclone"><a href="#" data-ajax="<?php echo esc_url($link); ?>&raw='+encodeURIComponent(post_edit_url)+'"><?php esc_html_e('Make a Copy', 'lanethemekit')?></a> | </span>';
                    jQuery(this).find('.trash').before(clone_html);
                });

                jQuery('.eptclone a').on('click', function() {
                    jQuery.ajax({
                        type: "GET",
                        url: jQuery(this).attr('data-ajax')
                    })
                        .done(function( msg ) {
                            location.reload();
                        });
                });
            });
            -->
        </script>
    <?php
    }
}

add_action('load-edit.php', 'lane_ourteam_custom_bulk_action');
function lane_ourteam_custom_bulk_action()
{
    global $typenow;

    if($typenow == LANE_POST_TYPE_NAME) {

        $action = isset($_REQUEST['action'])?$_REQUEST['action']:'post';
        if ($action != 'eptclone' && isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'eptclone') {
            $action = 'eptclone';
        }

        $post_ids = isset($_REQUEST['post'])?array_map('intval', $_REQUEST['post']):array();
        $page_num = isset($_REQUEST['paged'])?$_REQUEST['paged']:1;

        // Return when invalid parameters are given
        if($action != 'eptclone' || empty($post_ids)) {
            return;
        }

        // security check
        check_admin_referer('bulk-posts');

        // this is based on wp-admin/edit.php
        $sendback = remove_query_arg( array('eptcloned', 'untrashed', 'deleted', 'ids'), wp_get_referer());
        if (!$sendback) {
            $sendback = admin_url("edit.php?post_type=" . $typenow);
        }

        $sendback = add_query_arg( 'paged', $page_num, $sendback);

        // Process custom bulk action
        switch($action) {
            case 'eptclone':
                $cloned = 0;
                foreach( $post_ids as $post_id) {
                    lane_ourteam_clone_table($post_id);
                    $cloned++;
                }

                $sendback = add_query_arg( array('eptcloned' => $cloned, 'ids' => join(',', $post_ids) ), $sendback);
                break;

            default:
                return;
        }

        $sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );
        wp_redirect($sendback);
        exit();
    }
}

add_action('admin_notices', 'lane_ourteam_custom_bulk_admin_notices');
function lane_ourteam_custom_bulk_admin_notices()
{
    global $post_type, $pagenow;

    if($pagenow == 'edit.php' && $post_type == LANE_POST_TYPE_NAME && isset($_REQUEST['eptcloned']) && (int)$_REQUEST['eptcloned']) {
        $message = sprintf(
            _n( 'Ourteam social was copied successfully.', '%s Ourteam social were copied successfully.', $_REQUEST['eptcloned'], 'lanethemekit'),
            number_format_i18n($_REQUEST['eptcloned'])
        );
        echo '<div class="updated"><p>'.$message.'</p></div>';
    }
}

add_action("wp_ajax_dh_ptp_clone_table", "lane_ourteam_clone_single_table_action");
function lane_ourteam_clone_single_table_action()
{
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "lane_ourteam_clone_table_nonce")) {
        exit(esc_html__("No naughty business please", 'lanethemekit'));
    }

    preg_match('/post=(\d+)/', $_REQUEST['raw'], $m);
    if (isset($m[1]) && $m[1]) {
        lane_ourteam_clone_table($m[1]);
    }
    exit();
}

function lane_ourteam_clone_table($post_id)
{
    $meta_key = 'lane_ourteam_settings';

    // Get post
    $clone = get_post($post_id, ARRAY_A);
    $meta_value = get_post_meta($post_id, $meta_key, true);

    // Update content
    unset($clone['ID']);
    unset($clone['post_name']);
    unset($clone['guid']);
    $clone['post_title'] = sprintf( esc_html__('Copy of %s', 'lanethemekit'), $clone['post_title']);

    // Insert clone
    $cloned_post_id = wp_insert_post($clone, $wp_error);
    add_post_meta($cloned_post_id, $meta_key, $meta_value);

    return true;
}