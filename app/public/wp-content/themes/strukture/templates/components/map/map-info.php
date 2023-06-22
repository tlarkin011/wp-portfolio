<?php

$field_name = forge_var('field_name');
$contents = stk_get_field($field_name, $option);
$map_info = $contents[0]['mapinfo_google_map'];

$contact_address = get_field('footer_address', 'option');
$phone = get_field('footer_phone_number', 'option');
$email = get_field('footer_email_address', 'option');
$hours = get_field('footer_hours_of_operation', 'option');


$heading = $contents[0]['mapinfo_heading'];
$subheading = $contents[0]['mapinfo_subheading'];
$mapimage = $contents[0]['map_image'];
$address = $map_info['address'];
$lat = $map_info['lat'];
$lng = $map_info['lng'];
$styles = get_field('map_style', 'options');
$image = get_field('map_marker', 'option');
?>


<div class="row row-center single-map-wrapper">
    <div class="columns-8 map-column">
        <img src="<?php echo $mapimage;?>">
    </div>

    <div class="columns-4 content-column contact-container">

        <h6><?php echo $subheading ?></h6>
        <h3><?php echo $heading ?></h3>

        
        <div class="contact-item"><img class="font-icon" src="<?php echo THEME_IMG_PATH; ?>/map-marker-alt.svg" alt=""/><p><?php echo $contact_address ?></p></div>
      
        <div class="contact-item"><img class="font-icon" src="<?php echo THEME_IMG_PATH; ?>/envelope.svg" alt=""/><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></div>
        <div class="contact-item"><img class="font-icon" src="<?php echo THEME_IMG_PATH; ?>/phone-alt.svg" alt=""/><a href="tel:<?php echo $phone ?>"><?php echo $phone ?></a></div>

        <?php if( have_rows('footer_social_media', 'option') ) : ?>

                    <ul class="social-list">
                        <p>Follow Us:</p>
                        <?php while ( have_rows('footer_social_media', 'option') ) : the_row();
                            $socialMediaIcon = get_sub_field('platform','option');
                            $socialMediaLink = get_sub_field('link','option'); ?>

                            <li>
                                <a href="<?php echo $socialMediaLink; ?>" target="_blank" rel="noopener">
                                    <i class="fab fa-<?php echo $socialMediaIcon; ?>" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endwhile; ?>

                    </ul>

        <?php endif;  ?>


    </div>
</div>
</div>




