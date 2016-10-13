<?php
/*
The comments page for Bones
*/

// don't load it if you can't comment
if ( post_password_required() ) return;

?>
<p>This is child comment full template </p>
<div class="ibm-blog__comments">

    <a name="comments"></a>

    <?php if ( comments_open() ) : ?>

        <div data-widget="showhide" data-type="panel" class="ibm-show-hide">
            <h2 class="ibm-bold ibm-h1">
                <?php $my_theme = wp_get_theme(); _e('Add Comment', $my_theme->get( 'Name' )); ?> 
                    <div class="ibm-item-note disqus-comment-count"  data-disqus-url="<?php get_permalink(); ?>"><?php $my_theme = wp_get_theme(); comments_number( __( '<span>No</span> Comments', $my_theme->get( 'Name' ) ), __( '<span>One</span> Comment', $my_theme->get( 'Name' ) ), __( '<span>%</span> Comments', $my_theme->get( 'Name' ) ) );?>
                    </div>
            </h2>
            <div class="ibm-container-body">

                <div class="ibm-blog__comments-form ibm-column-form">

                    <div class="ibm-rule ibm-alternate ibm-gray-30"> </div>

                    <?php comment_form(array(
                        // To see all available options:
                        // http://codex.wordpress.org/Function_Reference/comment_form
                        'class_submit'      => 'ibm-btn-pri ibm-btn-small',
                        'comment_field'     =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
                                                '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
                                                '</textarea></p>',
                        )); ?>

                </div>

            </div>
        </div>

    <?php endif; ?>

    <?php if ( have_comments() ) : ?>

        <div class="ibm-rule ibm-alternate ibm-gray-30"> </div>

        <div class="ibm-columns ibm-blog__comments-list">

            <?php
            $my_theme = wp_get_theme();
            wp_list_comments( array(
                'style'             => 'li',
                'short_ping'        => true,
                'avatar_size'       => 40,
                'callback'          => 'theme_comments_full_width',
                'type'              => 'all',
                'reply_text'        => __('Reply', $my_theme->get( 'Name' )),
                'page'              => '',
                'per_page'          => '',
                'reverse_top_level' => null,
                'reverse_children'  => ''
            ));
            ?>

            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            	<nav class="navigation comment-navigation" role="navigation">
              	<div class="comment-nav-prev"><?php $my_theme = wp_get_theme(); previous_comments_link( __( '&larr; Previous Comments', $my_theme->get( 'Name' ) ) ); ?></div>
              	<div class="comment-nav-next"><?php $my_theme = wp_get_theme(); next_comments_link( __( 'More Comments &rarr;', $my_theme->get( 'Name' ) ) ); ?></div>
            	</nav>
            <?php endif; ?>

            <?php if ( ! comments_open() ) : ?>
            	<p class="no-comments"><?php $my_theme = wp_get_theme(); _e( 'Comments are closed.' , $my_theme->get( 'Name' ) ); ?></p>
            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>