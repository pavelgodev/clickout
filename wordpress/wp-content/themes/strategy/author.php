<?php

get_header();

$author = get_queried_object();
$author_id = $author->ID;
$position = get_field('position', 'user_' . $author_id);

$social_links = [
        'facebook' => get_field('facebook_url', 'user_' . $author_id),
        'x' => get_field('x_url', 'user_' . $author_id),
        'youtube' => get_field('youtube_url', 'user_' . $author_id),
        'instagram' => get_field('instagram_url', 'user_' . $author_id),
        'linkedin' => get_field('linkedin_url', 'user_' . $author_id),
];

$bio = get_field('bio', 'user_' . $author_id);
$user_photo = get_field('user_photo', 'user_' . $author_id);
?>

    <section class="author-page">
        <div class="author-card">
            <?php if ($user_photo && is_array($user_photo)) {
                echo wp_get_attachment_image(
                        $user_photo['ID'],
                        'author-thumbnail',
                        false,
                        array(
                                'alt' => $user_photo['alt'],
                                'class' => 'author-card__image'
                        )
                );
            } ?>
            <div class="author-card__info">
                <h1 class="author-card__name"><?php echo esc_html($author->display_name); ?></h1>
                <?php if ($position): ?>
                    <p class="author-card__position"><?php echo esc_html($position); ?></p>
                <?php endif; ?>
                <?php get_template_part('template-parts/content/socials', null, ['social_links' => $social_links]); ?>
            </div>
        </div>
        <div class="author-bio author-bio--border-top">
            <h2 class="author-bio__title">About <?php echo esc_html($author->display_name); ?></h2>
            <?php if ($bio): ?>
                <p class="author-bio__content author-bio__content--trimmed">
                    <?php echo esc_html(wp_trim_words($bio, 35, '...')); ?>
                </p>
                <p class="author-bio__content author-bio__content--full hide "><?php echo esc_html($bio); ?></p>
                <a href="#" class="author-bio__expand-btn"><?php esc_html_e('Expand', 'strategy'); ?></a>
            <?php endif; ?>
        </div>
        <?php
        if (have_posts()) : ?>
            <div class="author-posts">
                <h2 class="author-posts__title"><?php printf(esc_html__('Latest Posts from %s', 'strategy'),
                            esc_html(get_the_author_meta('first_name'))); ?></h2>
                <?php while (have_posts()) : ?>
                    <?php the_post(); ?>
                    <?php get_template_part('template-parts/content/content', 'article'); ?>
                <?php endwhile; ?>

                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <?php get_template_part('template-parts/content/content-none'); ?>
        <?php endif; ?>
    </section>
    <aside class="sidebar">
        <?php $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'author__not_in' => array($author_id),
                'orderby' => 'date',
                'order' => 'DESC',
        );

        $latest_posts = new WP_Query($args);

        if ($latest_posts->have_posts()) : ?>
            <div class="latest-news">
                <h2 class="latest-news__title"><?php esc_html_e('Latest News', 'strategy');?></h2>
                <div class="latest-news__items">
                    <?php while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        get_template_part('template-parts/content/content', 'news');
                    endwhile; ?>
                </div>
                <a href="<?php echo get_post_type_archive_link( 'post' ); ?>" class="latest-news__link"><?php esc_html_e('Show all news', 'strategy'); ?></a>
            </div>
        <?php endif; ?>
    </aside>
<?php
get_footer();
