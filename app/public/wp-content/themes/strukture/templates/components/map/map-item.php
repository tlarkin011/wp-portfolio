<?php
$article_id = stk_format_string_to_html_id_or_class(get_the_title());
$map = get_field('location');
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');

?>

<article class="loop-content loop-post row" id="<?php echo $article_id; ?>">

    <div class="columns-6 image-column">
        <?php the_post_thumbnail(); ?>
    </div>

    <div class="columns-6 content-column">
        <h3 style="color: <?php echo $highlight_one;?>" class="loop-title"><?php the_title(); ?></h3>

        <div class="location-info block-grid-2">

            <div class="location-block">
                <i style="color: <?php echo $highlight_two;?>" class="fal fa-map-marker-alt"></i>
                <p><?php echo the_field('address');?></p>
            </div>

               <div class="location-block">
             <i style="color: <?php echo $highlight_two;?>" class="fal fa-envelope"></i>
                <a href="mailto:<?php echo the_field('email');?>"><?php echo the_field('email');?></a>
            </div>

             <div class="location-block">
               <i style="color: <?php echo $highlight_two;?>" class="fal fa-clock"></i>
                <p><?php echo the_field('hours');?></p>
            </div>

               <div class="location-block">
               <i style="color: <?php echo $highlight_two;?>" class="fal fa-phone"></i>
                <a href="tel:<?php echo the_field('phone_number');?>"><?php echo the_field('phone_number');?></a>
            </div>

        </div>

        <p><?php excerpt(); ?></p>

        <?php if ($map): ?>
        <a style="border-bottom: 1px solid <?php echo $highlight_two;?>; color: <?php echo $highlight_two;?>" href="<?php the_permalink();?>" class="read-more map-data view-map-link" data-map-address="<?php echo $map['address']; ?>"
           data-map-lat="<?php echo $map['lat']; ?>" data-map-lng="<?php echo $map['lng']; ?>"
           data-article-id="<?php echo $article_id; ?>" data-title="<?php the_title(); ?>">Learn More</a>
        <?php endif; ?>

    </div>

</article>
