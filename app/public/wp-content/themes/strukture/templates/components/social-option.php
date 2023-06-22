<?php if( have_rows('footer_social_media', 'option') ) : ?>

    <ul class="social-list">

        <?php while ( have_rows('footer_social_media', 'option') ) : the_row();
            $socialMediaIcon = get_sub_field('platform','option');
            $socialMediaLink = get_sub_field('link','option'); ?>
            <li>
                <a href="<?php echo $socialMediaLink; ?>" target="_blank" rel="noopener">
                    <i class="fa fa-<?php echo $socialMediaIcon; ?>" aria-hidden="true"></i>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php endif;  ?>