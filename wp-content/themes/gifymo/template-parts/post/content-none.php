<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'gifymo' ); ?></h1>
    </header>
    <div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf( esc_html__( 'Ready to publish your first post?', 'gifymo' ) . '<a href="%1$s">' . esc_html__( 'Get started here', 'gifymo' ) . '</a>.', esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php else : ?>

            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'gifymo' ); ?></p>
			<?php
			get_search_form();

		endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->