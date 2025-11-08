<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1>', '</h1>' ); ?>
		<?php else : ?>
			<?php the_title( sprintf( '<h2><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>

		<?php the_post_thumbnail( 'thumbnail', array( 'loading' => false ) ); ?>
    </header>

    <div class="entry-content">
		<?php the_content(); ?>
    </div>
</article>
