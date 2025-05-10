<?php

if (!function_exists('gifymo_entry_meta')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function gifymo_entry_meta() {

        echo '<div class="meta-inner">';
        $separate_meta = __(',&nbsp;', 'gifymo');

        // Get the author name; wrap it in a link.
        $byline = sprintf(
        /* translators: %s: post author */
            '<span class="meta-title">' . esc_html__('By:', 'gifymo') . '</span> %s',
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a></span>'
        );

        $time_link = sprintf(
        /* translators: %s: post author */
            '<span class="meta-title">' . esc_html__('Post on:', 'gifymo') . '</span> %s',
            gifymo_time_link()
        );

        echo '<span class="byline">' . $byline . '</span>';// WPCS: XSS ok.

        echo '<span class="posted-on">' . $time_link . '</span>';// WPCS: XSS ok.

        // Finally, let's write all of this to the page.
        echo '</div>';
    }
endif;

if (!function_exists('gifymo_entry_meta_single')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function gifymo_entry_meta_single() {
        echo '<div class="meta-inner">';
        $separate_meta = __(',&nbsp;', 'gifymo');

        // Get the author name; wrap it in a link.
        $byline = sprintf(
        /* translators: %s: post author */
            '<span class="meta-title">' . esc_html__('By:', 'gifymo') . '</span> %s',
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a></span>'
        );

        $time_link = sprintf(
        /* translators: %s: post author */
            '<span class="meta-title">' . esc_html__('Post on:', 'gifymo') . '</span> %s',
            gifymo_time_link()
        );

        // Get Categories for posts.
        $categories_list = get_the_category_list($separate_meta);


        $tags_title = '<span class="meta-title">' . esc_html__('Tags: ', 'gifymo') . '</span>';
        $tags_list  = get_the_tag_list($tags_title, $separate_meta);


        echo '<span class="byline">' . $byline . '</span>';// WPCS: XSS ok.

        echo '<span class="posted-on">' . $time_link . '</span>';// WPCS: XSS ok.

        echo '<span class="entry-comment"><span class="meta-title">' . _n("Comment: ", "Comments: ", get_comments_number(), "gifymo") . '</span><span class="meta-content comment-number">' . get_comments_number() . '</span></span>';// WPCS: XSS ok.

        if ('post' === get_post_type()) {
            // Make sure there's more than one category before displaying.
            if ($categories_list && gifymo_categorized_blog()) {
                echo '<span class="cat-links"><span class="meta-title">' . esc_html__('Categories: ', 'gifymo') . '</span>' . $categories_list . '</span>';
            }
        }

        if ($tags_list) {
            echo '<span class="tags-links">' . $tags_list . '</span>'; // WPCS: XSS ok.
        }

        // Finally, let's write all of this to the page.
        echo '</div>';
    }
endif;


if (!function_exists('gifymo_cat_links')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function gifymo_cat_links() {
        /* translators: used between list items, there is a space after the comma */
        $separate_meta = esc_html__(', ', 'gifymo');

        // Get Categories for posts.
        $categories_list = get_the_category_list($separate_meta);

        if ('post' === get_post_type()) {
            // Make sure there's more than one category before displaying.
            if ($categories_list && gifymo_categorized_blog()) {
                echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__('Categories', 'gifymo') . '</span>' . $categories_list . '</span>';
            }
        }
    }
endif;

if (!function_exists('gifymo_count_comment')) :
    function gifymo_count_comment() {
        echo '<span class="entry-comment"><span class="meta-title">' . _n("Comment", "Comments", get_comments_number(), "gifymo") . '</span>' . get_comments_number() . '</span>';
    }
endif;

if (!function_exists('gifymo_tags_link')) :
    function gifymo_tags_link() {
        /* translators: Used between list items, there is a space after the comma. */
        $separate_meta = __(',&nbsp;', 'gifymo');
        $tags_title    = '<span class=" tags-title screen-reader-text1">' . esc_html__('Tags: ', 'gifymo') . '</span>';
        $tags_list     = get_the_tag_list($tags_title, $separate_meta);
        if ($tags_list) {
            echo '<span class="tags-links">' . $tags_list . '</span>'; // WPCS: XSS ok.
        }
    }
endif;

if (!function_exists('gifymo_time_link')) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function gifymo_time_link() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time></a>';
        }

        $time_string = sprintf($time_string,
            get_the_date(DATE_W3C),
            get_the_date(),
            get_the_modified_date(DATE_W3C),
            get_the_modified_date()
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        return $time_string;
    }
endif;

if (!function_exists('gifymo_entry_footer')):
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function gifymo_entry_footer() {

        // We don't want to output .entry-footer if it will be empty, so make sure its not.

        if ('post' === get_post_type()) {
            if ((gifymo_is_osf_framework_activated() && get_theme_mod('osf_socials'))) {
                echo '<div class="entry-footer">';

                gifymo_social_share();

                echo '</div> <!-- .entry-footer -->';
            }

        }
    }
endif;


if (!function_exists('gifymo_edit_link')) :
    /**
     * Returns an accessibility-friendly link to edit a post or page.
     *
     * This also gives us a little context about what exactly we're editing
     * (post or page?) so that users understand a bit more where they are in terms
     * of the template hierarchy and their content. Helpful when/if the single-page
     * layout with multiple posts/pages shown gets confusing.
     */
    function gifymo_edit_link() {
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                esc_html__('Edit', 'gifymo') . '<span class="screen-reader-text"> "%s"</span>',
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('gifymo_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function gifymo_post_thumbnail() {
        if (!gifymo_can_show_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <figure class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </figure><!-- .post-thumbnail -->

        <?php
        else :
            ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail('post-thumbnail'); ?>
                </a>
            </figure>

        <?php
        endif; // End is_singular().
    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function gifymo_categorized_blog() {
    $category_count = get_transient('gifymo_categories');

    if (false === $category_count) {
        // Create an array of all the categories that are attached to posts.
        $categories = get_categories(array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number'     => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $category_count = count($categories);

        set_transient('gifymo_categories', $category_count);
    }

    // Allow viewing case of 0 or 1 categories in post preview.
    if (is_preview()) {
        return true;
    }

    return $category_count > 1;
}


/**
 * Flush out the transients used in gifymo_categorized_blog.
 */
function gifymo_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('gifymo_categories');
}

add_action('edit_category', 'gifymo_category_transient_flusher');
add_action('save_post', 'gifymo_category_transient_flusher');
