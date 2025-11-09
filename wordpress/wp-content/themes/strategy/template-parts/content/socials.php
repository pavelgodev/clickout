<?php if ( ! empty( $args['social_links'] ) ) : ?>
    <div class="socials">
        <?php foreach ( $args['social_links'] as $label => $link ) : ?>
            <a href="<?php echo esc_url( $link ); ?>" class="socials__link" target="_blank">
                <img src="<?php echo get_theme_file_uri( "/public/images/socials/{$label}.png" ); ?>"
                     alt="<?php echo esc_html( $label ); ?>" class="socials__icon">
            </a>
        <?php endforeach; ?>
    </div>
<?php endif;
