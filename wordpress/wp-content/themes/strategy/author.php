<?php

get_header();

$author    = get_queried_object();
$author_id = $author->ID;
$position  = get_field( 'position', 'user_' . $author_id );

$social_links = [
        'facebook'  => get_field( 'facebook_url', 'user_' . $author_id ),
        'x'         => get_field( 'x_url', 'user_' . $author_id ),
        'youtube'   => get_field( 'youtube_url', 'user_' . $author_id ),
        'instagram' => get_field( 'instagram_url', 'user_' . $author_id ),
        'linkedin'  => get_field( 'linkedin_url', 'user_' . $author_id ),
];

$bio        = get_field( 'bio', 'user_' . $author_id );
$user_photo = get_field( 'user_photo', 'user_' . $author_id );
?>

    <section class="author-page">
        <div class="author-card">
            <?php if ( $user_photo && is_array( $user_photo ) ) {
                echo wp_get_attachment_image(
                        $user_photo['ID'],
                        'author-thumbnail',
                        false,
                        array(
                                'alt'   => $user_photo['alt'],
                                'class' => 'author-card__image'
                        )
                );
            } ?>
            <div class="author-card__info">
                <h1 class="author-card__name"><?php echo esc_html( $author->display_name ); ?></h1>
                <?php if ( $position ): ?>
                    <p class="author-card__position"><?php echo esc_html( $position ); ?></p>
                <?php endif; ?>
                <?php get_template_part( 'template-parts/content/socials', null, [ 'social_links' => $social_links ] ); ?>
            </div>
        </div>
        <div class="author-bio author-bio--border-top">
            <h2 class="author-bio__title">About <?php echo esc_html( $author->display_name ); ?></h2>
            <?php if ( $bio ): ?>
                <p class="author-bio__content author-bio__content--trimmed">
                    <?php echo esc_html( wp_trim_words( $bio, 35, '...' ) ); ?>
                </p>
                <p class="author-bio__content author-bio__content--full hide "><?php echo esc_html( $bio ); ?></p>
                <a href="#" class="author-bio__expand-btn"><?php _e('Expand', 'strategy');?></a>
            <?php endif; ?>
        </div>
        <?php
        $paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

        $args = array(
                'author'         => $author_id,
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'paged'          => $paged,
                'posts_per_page' => 3,
        );

        $author_posts = new WP_Query( $args );

        if ( $author_posts->have_posts() ) :?>

            <div class="author-posts">
                <h2 class="author-posts__title">Latest Post
                    from <?php echo esc_html( get_the_author_meta( 'first_name' ) ); ?></h2>
                <?php while ( $author_posts->have_posts() ) : $author_posts->the_post();
                    get_template_part( 'template-parts/content/content', 'article' );
                endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata();
        ?>
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
