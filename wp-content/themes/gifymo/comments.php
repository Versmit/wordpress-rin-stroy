<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area comments-tab">
    <ul class="comments-tab-title">
        <?php if (have_comments()) : ?>
            <li>
                <a href="#comments_list" class="comments-tablink"><?php echo esc_html__('Comment', 'gifymo') ?></a>
            </li>
        <?php endif; ?>
        <li>
            <a href="#comment_form" class="comments-tablink"><?php echo esc_html__('Leave a Comment', 'gifymo') ?></a>
        </li>

    </ul>

    <?php

    // You can start editing here -- including this comment!
    if (have_comments()) : ?>
        <div id="comments_list" class="comment-list-wap tabcontent">
            <h2 class="comments-title">
                <?php
                $comments_number = get_comments_number();

                printf(_n('%s Comment', '%s Comments', $comments_number, 'gifymo'), $comments_number);
                ?>
            </h2>
            <ol class="comment-list" data-opal-customizer="otf_comment_template">
                <?php
                wp_list_comments(array(
                    'avatar_size' => 100,
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'reply_text'  => esc_html__('Reply', 'gifymo'),
                ));
                ?>
            </ol>
        </div>
        <?php the_comments_pagination(array(
            'prev_text' => '<span class="fa fa-arrow-left"></span><span class="screen-reader-text">' . esc_html__('Previous page', 'gifymo') . '</span>',
            'next_text' => '<span class="screen-reader-text">' . esc_html__('Next page', 'gifymo') . '</span><span class="fa fa-arrow-right"></span>',
        ));
    endif; // Check for have_comments().

    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'gifymo'); ?></p>
    <?php endif; ?>

    <div id="comment_form" class="tabcontent"><?php comment_form(); ?></div>

</div><!-- #comments -->
