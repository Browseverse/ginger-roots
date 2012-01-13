<?php
// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die (__('Please do not load this page directly. Thanks!', 'roots'));

  if ( post_password_required() ) { ?>
  <section id="comments">
    <div class="notice">
      <p class="bottom"><?php _e('This post is password protected. Enter the password to view comments.', 'roots'); ?></p>
    </div>
  </section>
  <?php
    return;
  }
?>
<?php
global $context;
$template = $context->update(__FILE__);
$context->post_password_required = post_password_required();
$context->have_comments = have_comments();
$context->previous_comments_link = get_previous_comments_link( __( '&larr; Older comments', 'roots' ) );
$context->next_comments_link = get_next_comments_link( __( 'Newer comments &rarr;', 'roots' ) );
$context->comments_open = comments_open();
$context->cancel_comment_reply_link = get_cancel_comment_reply_link();
$context->comment_registration_and_not_logged_in = get_option('comment_registration') && !is_user_logged_in();
$context->req = ($req) ? __(' (required)', 'roots') : '';
$context->comment_author = $comment_author;
$context->comment_author_email = $comment_author_email;
$context->comment_author_url = $comment_author_url;
$context->comment_id_fields = get_comment_id_fields();
$context->user_identity = $user_identity;
$context->wp_logout_url = wp_logout_url(get_permalink());

// capturing comment list into a (sub) array
$context->commentlist = array(); wp_list_comments('type=comment&callback=roots_comments');

// capturing output buffer for the action hook and some functions that don't have an easy get_ method
// Is there a more elegant way?
ob_start();
do_action('comment_form', $post->ID);
$context->comment_form_action = ob_get_clean();

ob_start();
comment_form_title( __('Leave a Reply', 'roots'), __('Leave a Reply to %s', 'roots') );
$context->comment_form_title = ob_get_clean();

ob_start();
comments_number(__('No Responses to', 'roots'), __('One Response to', 'roots'), __('% Responses to', 'roots') );
$context->comments_number = ob_get_clean();

echo $context->render($template);
?>
<?php function roots_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $context;
    $comment_context = array();
    $comment_context['comment_class'] = comment_class('', null, null, false);
    $comment_context['comment_ID'] = $comment->comment_ID;
    $comment_context['avatar'] = get_avatar($comment,$size='32');
    $comment_context['comment_author_link'] = get_comment_author_link();
    $comment_context['comment_date_time'] = sprintf(__('%1$s', 'roots'), get_comment_date(),  get_comment_time());
    $comment_context['comment_date_c'] = get_comment_date('c');
    $comment_context['edit_comment_link'] = get_edit_comment_link( $comment->comment_ID );
    $comment_context['comment_link'] = htmlspecialchars( get_comment_link( $comment->comment_ID ) );
    $comment_context['approved'] = ($comment->comment_approved !== '0');
    $comment_context['comment_text'] = get_comment_text();

    ob_start();  
    comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
    $comment_context['comment_reply_link'] = ob_get_clean();

    array_push($context->commentlist, $comment_context); 
} ?>
