<article class="author-post author-post--underlined">
    <?php
    if (has_post_thumbnail()) {
        the_post_thumbnail('post-thumbnail', array('class' => 'author-post__img'));
    }
    ?>
	<div class="author-post__info">
        <a href="<?php the_permalink(); ?>" class="author-post__link">
            <?php the_title( '<h3 class="author-post__title">', '</h3>' ); ?>
        </a>

        <div class="author-post__excerpt"><?php echo wp_trim_words(get_the_content(), 20); ?></div>
	</div>
</article>
