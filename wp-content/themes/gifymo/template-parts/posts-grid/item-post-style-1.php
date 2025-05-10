<div class="post-inner">

    <?php if (has_post_thumbnail() && '' !== get_the_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('gifymo-featured-image-large'); ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="post-content">

        <header class="entry-header">
            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

            <?php if ('post' === get_post_type()) : ?>
                <div class="entry-meta">
                    <?php echo gifymo_entry_meta(); ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>

        </header><!-- .entry-header -->

    </div><!-- .post-content -->
</div><!-- .post-inner-->