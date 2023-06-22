</section>

<?php
$show_footer_callout = get_field('show_footer_callout');

if ($show_footer_callout) {
    $field_name = get_field('use_global_callout') ? 'standard_pre_footer_cta' : 'footer_callout';
    forge_template('components/content/content-background',
        ['option' => get_field('use_global_callout'), 'field_name' => $field_name]);
}

// show callout on category page
if (is_category()) {
    forge_template('components/content/content-background',
        ['option' => true, 'field_name' => 'standard_pre_footer_cta']);
}


$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');

?>

<?php if( have_rows('awards_repeater', 'option') ): ?>

    <div class="footer-awards-wrapper">
        <div class="row row-center footer-awards">
            <div class="columns-12 block-grid-5 footer-awards-container">
                
                        <?php 
                            while ( have_rows('awards_repeater', 'option') ) : the_row(); 
                                $awardIcon = get_sub_field('award_icon','option');
                                $awardDescription = get_sub_field('award_description','option');
                        ?>

                            <div class="award-content">
                                <img src="<?php echo $awardIcon ?>" />
                                <p><?php echo $awardDescription; ?> </p>                
                            </div>


                        <?php endwhile; ?>      
            </div>  
        </div>
    </div>

<?php  endif; ?>

<footer class="site-footer" role="contentinfo">
    <div class="row row-center footer-logo-wrapper">
        <div class="columns-10 block-grid-3">

            <?php
            if (have_rows('footer_logo_blocks', 'option')):

                while (have_rows('footer_logo_blocks', 'option')) : the_row(); ?>

                    <div class="footer-logo-block">
                        <a href="<?php echo the_sub_field('link'); ?>">
                            <img src="<?php echo the_sub_field('logo'); ?>">
                            <p><?php echo the_sub_field('text'); ?></p>
                        </a>
                    </div>

                <?php endwhile;

            endif;
            ?>

        </div>
    </div>

    <div class="row row-center">
        <div class="columns-12 flex">

            <div class="columns-3 footer-logo-column">
                <?php anvil_footer_logo(); ?>

                <div class="site-copyright-desktop">
                    <p class="site-copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.<br> All rights
                    reserved.</p>

                    <?php
                    wp_nav_menu([
                        'theme_location' => 'privacy',
                        'container' => false,
                        'fallback_cb' => false,
                        'menu_class' => 'nav-menu privacy-menu',
                    ]);
                    ?>

                  
                    </div>
                </div>

                <div class="columns-4 footer-menu">
                    <p>Services</p>

                    <?php
                    wp_nav_menu([
                        'theme_location' => 'services',
                        'container' => false,
                        'fallback_cb' => false,
                        'menu_class' => 'nav-menu',
                    ]);
                    ?>
                </div>

                <div class="columns-2 footer-menu">
                    <p>Learn More</p>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'learn',
                        'container' => false,
                        'fallback_cb' => false,
                        'menu_class' => 'nav-menu',
                    ]);
                    ?>
                </div>

                <div class="columns-3 footer-menu address-column ">

                    <h6>Contact</h6>

                    <div class="offices-wIcons-key">
                        <i class="far fa-map-marker-alt icons_footer"></i>
                        <p class="address"><?php the_field('footer_address', 'option'); ?></p>
                    </div>

                    <div class="offices-wIcons-key">
                        <i class="far fa-mobile icons_footer"></i>
                        <a href="tel:<?php echo the_field('footer_phone_number', 'option'); ?>"><?php echo the_field('footer_phone_number', 'option'); ?></a>
                    </div>

                    <div class="offices-wIcons-key">
                        <i class="far fa-envelope icons_footer"></i>
                        <a  class="email-us" href="mailto:<?php echo the_field('footer_email_address', 'option'); ?>">Email Us</a>
                    </div>


                    
                    
                    
                    

                    <?php if (have_rows('footer_social_media', 'option')) : ?>

                        <ul class="social-list">

                            <?php while (have_rows('footer_social_media', 'option')) : the_row();
                                $socialMediaIcon = get_sub_field('platform', 'option');
                                $socialMediaLink = get_sub_field('link', 'option'); ?>

                                <li>
                                    <a href="<?php echo $socialMediaLink; ?>" target="_blank" rel="noopener">
                                        <i style="color:white" class="fab fa-<?php echo $socialMediaIcon; ?>"
                                         aria-hidden="true"></i>
                                     </a>
                                 </li>
                             <?php endwhile; ?>

                         </ul>

                     <?php endif; ?>
                 </div>

                 <div class="site-copyright-mobile">
                    <p class="site-copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.<br> All rights
                    reserved.</p>

                    <?php
                    wp_nav_menu([
                        'theme_location' => 'privacy',
                        'container' => false,
                        'fallback_cb' => false,
                        'menu_class' => 'nav-menu privacy-menu',
                    ]);
                    ?>

                   

                    </div>
                </div>
            </div>
        </footer>

        <?php wp_footer(); ?>
    </body>


    </html>
