<?php

/*

This file contains functions which clean and update the Wordpress functionality.
Highly infuenced/stolen from the bones Wordpress template (http://themble.com/bones/).

*/

// ---------------------------------------------------------------------------
// BOOTSTRAP

function theme_comments( $comment, $args, $depth ) {

    $GLOBALS['comment'] = $comment;
    ?>

    <div class="ibm-blog__comments-item">

        <div class="ibm-col-6-1 ibm-blog__comments-meta">
            <h6 class="ibm-h6 ibm-item-note">
                <?php $bgauthemail = get_comment_author_email(); ?>
                <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=60" class="load-gravatar avatar avatar-48 photo" height="60" width="60" src="<?php echo get_template_directory_uri(); ?>/assets/img/avatar.png" />
                <br/><cite><?php comment_author_link(); ?></cite>
                <br/><time datetime="<?php echo comment_time('Y-m-j'); ?>"><?php $my_theme = wp_get_theme(); comment_time(__( 'F jS, Y', $my_theme->get( 'Name' ) )); ?></time>
            </h6>

        </div>

        <div class="ibm-col-6-3">

            <?php if ($comment->comment_approved == '0') : ?>
                <div class="alert alert-info">
                    <p class="ibm-item-note-alternate"><?php $my_theme = wp_get_theme(); _e( 'Your comment is awaiting moderation.', $my_theme->get( 'Name' ) ) ?></p>
                </div>
            <?php endif; ?>

            <?php comment_text() ?>

            <p class="ibm-required text"><?php $my_theme = wp_get_theme(); edit_comment_link(__( '(Edit)', $my_theme->get( 'Name' ) )); ?></p>

            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

        </div>

        <div class="ibm-col-6-4"><div class="ibm-rule ibm-alternate ibm-gray-30"> </div></div>

    </div>

<?php }


/*

This file contains functions which clean and update the Wordpress functionality.
Highly infuenced/stolen from the bones Wordpress template (http://themble.com/bones/).

*/

// ---------------------------------------------------------------------------
// BOOTSTRAP

function theme_comments_full_width( $comment, $args, $depth ) {

    $GLOBALS['comment'] = $comment;
    ?>

    <div class="ibm-blog__comments-item">

        <div class="ibm-col-6-1 ibm-blog__comments-meta">
            <h6 class="ibm-h6  disqus-comment-count"  data-disqus-url="<?php get_permalink(); ?>">
                <?php $bgauthemail = get_comment_author_email(); ?>
                <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=60" class="load-gravatar avatar avatar-48 photo" height="60" width="60" src="<?php echo get_template_directory_uri(); ?>/assets/img/avatar.png" />
                <br/><cite><?php comment_author_link(); ?></cite>
                <br/><time datetime="<?php echo comment_time('Y-m-j'); ?>"><?php $my_theme = wp_get_theme(); comment_time(__( 'F jS, Y', $my_theme->get( 'Name' ) )); ?></time>
            </h6>

        </div>

        <div class="ibm-col-6-5">

            <?php if ($comment->comment_approved == '0') : ?>
                <div class="alert alert-info">
                    <p class="ibm-item-note-alternate"><?php $my_theme = wp_get_theme(); _e( 'Your comment is awaiting moderation.', $my_theme->get( 'Name' ) ) ?></p>
                </div>
            <?php endif; ?>

            <?php comment_text() ?>

            <p class="ibm-required text"><?php $my_theme = wp_get_theme(); edit_comment_link(__( '(Edit)', $my_theme->get( 'Name' ) )); ?></p>

            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

        </div>

        <div class="ibm-col-1-1"><div class="ibm-rule ibm-alternate ibm-gray-30"> </div></div>

    </div>

<?php }  ?>