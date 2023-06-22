<?php
$article_id = stk_format_html_id(get_the_title());
$map = get_field('location');
?>

<article class="columns-12 flex store location-loop-item loop-content map-loop-container"
id="<?php echo $article_id; ?>" data-location-id="<?php echo get_the_ID(); ?>">

<div class="columns-7 image-column">
    <?php the_post_thumbnail(); ?>

    <div class="your-location-banner">
        <i class="fa fa-star" aria-hidden="true"></i>
        <p>Your Location</p>
    </div>

</div>

<?php if ($map): ?>
    <a href="#locations-map" class="map-data view-map-link" data-map-address="<?php echo $map['address']; ?>"
     data-map-lat="<?php echo $map['lat']; ?>" data-map-lng="<?php echo $map['lng']; ?>"
     data-article-id="<?php echo $article_id; ?>" data-title="<?php the_title(); ?>"
     data-link="<?php the_permalink(); ?>"></a>
 <?php endif; ?>

 <div class="columns-5 content-column">
    <div class="columns-12">

        <h4 class="columns-8 loop-title map-info-block"><?php echo the_title(); ?></h4>
        <a class="phone" href="tel:<?php the_field('phone_number'); ?>"><i
            class="fas fa-phone"></i><?php the_field('phone_number'); ?></a>

            <div class="hours flex">
                <i class="fas fa-clock"></i>
                <div>
                    <p><?php the_field('hours'); ?></p>
                </div>
            </div>

            <p class="address"><i class="fas fa-map-marker-alt"></i><?php the_field('address'); ?></p>

            <a class="directions" target="_blank" href="<?php the_field('directions_link'); ?>">Get Directions<i
                class="fas fa-angle-right"></i></a>


            </div>
            <a href="<?php the_field('order_online_link');?>" class="store-button button">Order Online</a>

        </div>
    </article>

