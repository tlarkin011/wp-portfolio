<?php
$article_id = stk_format_string_to_html_id_or_class(get_the_title());
$map = get_field('location');

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');


?>
<article class="loop-content loop-post row" id="<?php echo $article_id; ?>">

    <div class="columns-4 image-column">
        <?php the_post_thumbnail(); ?>
    </div>

    <div class="columns-8 content-column">
        <h3 style="color: <?php echo $highlight_one;?>" class="loop-title"><?php the_title(); ?></h3>
        <?php if ($map): ?>
        <a href="#locations-map" class="map-data view-map-link" data-map-address="<?php echo $map['address']; ?>"
           data-map-lat="<?php echo $map['lat']; ?>" data-map-lng="<?php echo $map['lng']; ?>"
           data-article-id="<?php echo $article_id; ?>" data-title="<?php the_title(); ?>">View Map</a>
        <?php endif; ?>

    </div>

</article>
