<div class="post-inner">

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