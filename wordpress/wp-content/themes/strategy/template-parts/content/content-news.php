<article class="author-news author-post--underlined">
    <?php if (has_post_thumbnail()) {
        the_post_thumbnail('thumb-mini', array('class' => 'author-news__img'));
    } ?>
    <div class="author-news__info">
        <?php the_title('<h4 class="author-news__title">', '</h4>'); ?>
    </div>
</article>
