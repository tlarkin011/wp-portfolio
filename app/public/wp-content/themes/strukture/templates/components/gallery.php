<?php
$field = forge_var('field_name');
$images = forge_var('contents') ? forge_var('contents') : get_field($field);




// Slider with thumbnails

if( $images ): ?>

    <div id="gallery-loader" class="gallery row row-center">
        <div class="columns-10 gallery-holder">
            
            <div class="gallery-wrapper columns-8 slick">

                <?php foreach( $images as $image ): ?>
                    <?php $link = get_field('video_link', $image['ID']) ? get_field('video_link', $image['ID']) : $image['url']; ?>
                    <div class="gallery-image">

                        <?php $link_video = $image['caption'];

                        if ( $link_video != "") { ?>

                            <a class="grouped_elements" rel="group1" href="<?php echo $link_video; ?>" data-fancybox="gallery">
                           <img class="play-logo" src="<?php bloginfo('template_url'); ?>/images/play-button.png;?>">
                        <?php

                        $link_video = "";

                         } else { ?>

                            <a class="grouped_elements" rel="group1" href="<?php echo $link; ?>" data-fancybox="gallery">

                        <?php } ?>
                               
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                            <?php echo $image['caption']; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($images) > 1) : ?>
            <div class="slick-thumbnail-grid columns-8">
                <?php foreach( $images as $image ): ?>
                    <div class="gallery-nav-image">
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>