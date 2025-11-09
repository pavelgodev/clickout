<?php

get_header();

$author = get_queried_object(); ?>

    <section class="author-page">
        <div class="author-card">
            <img src="<?php echo get_theme_file_uri() . '/public/images/author.jpg'; ?>" alt=""
                 class="author-card__image">
            <div class="author-card__info">
                <h1 class="author-card__name"><?php echo esc_html( $author->display_name );?></h1>
                <p class="author-card__position">Poker Expert</p>
                <?php get_template_part( 'template-parts/content/socials' ); ?>
            </div>
        </div>
        <div class="author-bio author-bio--border-top">
            <h2 class="author-bio__title">About Barry</h2>
            <p class="author-bio__content">Barry Carter is a poker writer, author and editor from Sheffield, England. He
                first discovered poker through a workmate who was winning a lot at the time and who taught him the game.
                This was back at a time which he describes as when "poker was easy and there was no such thing as the
                poker...</p>
        </div>
        <div class="author-posts">
            <h2 class="author-posts__title">Latest Post from Barry</h2>
            <?php for ( $i = 0; $i < 10; $i ++ ) {
                get_template_part( 'template-parts/content/content', 'article' );
            }
            ?>
        </div>
    </section>
    <aside class="sidebar">
        <div class="latest-news">
            <h2 class="latest-news__title">Latest News</h2>
            <div class="latest-news__items">
            <?php for ( $i = 0; $i < 5; $i ++ ) {
                get_template_part( 'template-parts/content/content', 'news' );
            }
            ?>
            </div>
            <a href="#" class="latest-news__link">Show all news</a>
        </div>
    </aside>

<?php
get_footer();
