<?php
if (forge_var('nested')) {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name', 'image_or_video_row');
    $contents = stk_get_field($field_name);
}

if ($contents) : ?>
    <section class="image-or-video-container">
        <div class="row image-or-video-row row-center">
            <?php foreach ($contents as $content) :
                $content_html_class = 'columns-6';
                if (count($content['image_or_video_row']) == 1) {
                    $content_html_class = 'columns-10';
                }

                foreach ($content['image_or_video_row'] as $content_row) :
                    if ($content_row["acf_fc_layout"] === 'image') : ?>
                        <div class="callout-container <?= $content_html_class; ?>">
                            <div class="image-column">
                                <img src="<?= $content_row["image"]["url"]; ?>"
                                     alt="<?= $content_row["image"]["alt"]; ?>">
                            </div>
                            <div class="description-container">
                                <p><?php echo $content_row["description"] ?></p>
                            </div>
                        </div>
                    <?php elseif ($content_row["acf_fc_layout"] === 'video') : ?>
                        <div class="callout-container <?= $content_html_class; ?>">
                            <a class="image-column fancy-box-container"
                               data-fancybox
                               href="<?= $content_row['video_link']; ?>"
                            >
                                <img src="<?= $content_row["thumbnail_image"]["url"]; ?>" alt="">
                                <i class="far fa-play-circle"></i>
                            </a>
                            <div class="description-container">
                                <p><?php echo $content_row["description"] ?></p>
                            </div>
                        </div>
                    <?php endif;
                endforeach;

            endforeach; ?>
        </div>
    </section>
<?php endif; ?>
