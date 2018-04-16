<?php
if ( post_password_required() ){
    return;
}
$GLOBALS['comment'] = $comment;
$add_below = '';
?>
<div id="comments">
    <div class="comments-list">
        <?php if ( have_comments() ) { ?>
        <h4 class="heading"><span><?php comments_number( esc_html__('Comment (0)', 'fatotheme'), esc_html__('Comment (1)', 'fatotheme'), esc_html__('Comments (%)', 'fatotheme') ); ?></span></h4>
            <ol class="commentlists list-unstyled clearfix">
                <?php wp_list_comments(array(
                    'style' => 'li',
                    'callback' => 'fatotheme_render_comments',
                    'avatar_size' => 120,
                    'short_ping' => true,
                )); ?>
            </ol>
            <?php
                // Are there comments to navigate through?
            if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <footer class="navigation comment-navigation" data-role="navigation">
                <div class="previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'fatotheme' ) ); ?></div>
                <div class="next right"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'fatotheme' ) ); ?></div>
            </footer><!-- .comment-navigation -->
            <?php endif; // Check for comment navigation ?>
            <?php if ( ! comments_open() && get_comments_number() ) : ?>
                <p class="no-comments"><?php echo esc_html__( 'Not allow comments.' , 'fatotheme' ); ?></p>
            <?php endif; ?>
        <?php } ?>
    </div>
	<?php if ( comments_open() ) : ?>
        <?php
        $commenter = wp_get_current_commenter();
        $req       = get_option( 'require_name_email' );
        $aria_req  = ( $req ) ? " aria-required='true'" : '';
        $html_req  = ( $req ) ? " required='required'" : '';
        $html5     = ( 'html5' === current_theme_supports( 'html5', 'comment-form' ) ) ? 'html5' : 'xhtml';

        $fields = array();

        $fields['author'] = '<div id="comment-input" class="row"><div class="col-md-3 author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_html__( 'Name (required)', 'fatotheme' ) . '" size="30"' . $aria_req . $html_req . ' /></div>';
        $fields['email']  = '<div class="col-md-3 email"><input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . esc_html__( 'Email (required)', 'fatotheme' ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></div>';
        $fields['url']    = '<div class="col-md-3 url"><input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_html__( 'Website', 'fatotheme' ) . '" size="30" /></div></div>';

        $comments_args = array(
            'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
            'comment_field'        => '<div id="comment-textarea"><label class="screen-reader-text" for="comment">' . esc_attr__( 'Comment', 'fatotheme' ) . '</label><textarea name="comment" id="comment" cols="45" rows="8" aria-required="true" required="required" tabindex="0" class="textarea-comment" placeholder="' . esc_html__( 'Comment...', 'fatotheme' ) . '"></textarea></div>',
            'title_reply'          => esc_html__( 'Leave a comment', 'fatotheme' ),
            'title_reply_to'       => esc_html__( 'Leave a comment', 'fatotheme' ),
            'must_log_in'          => '<p class="must-log-in">' .  sprintf( esc_html__( 'You must be %slogged in%s to post a comment.', 'fatotheme' ), '<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">', '</a>' ) . '</p>',
            'logged_in_as'         => '<p class="logged-in-as">' . sprintf( esc_html__( 'Logged in as %s. %sLog out &raquo;%s', 'fatotheme' ), '<a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>', '<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . esc_html__( 'Log out of this account', 'fatotheme' ) . '">', '</a>' ) . '</p>',
            'comment_notes_before' => '',
            'id_submit'            => 'comment-submit',
            'class_submit'         => 'fusion-button fusion-button-default',
            'label_submit'         => esc_html__( 'Post Comment', 'fatotheme' ),
        );
        ?>

        <?php comment_form( $comments_args ); ?>

    <?php endif; ?>
</div><!-- end comments -->
