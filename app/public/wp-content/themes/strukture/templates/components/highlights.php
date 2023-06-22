<?php
if (forge_var('nested')) {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name') ? forge_var('field_name') : 'highlights';
    $contents = stk_get_field($field_name);

}

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');



if ($contents) :
    foreach ($contents as $content) : ?>
        <section class="highlights">
            <div class="row row-center">
            <div class="columns-12  highlights-grid block-grid-2">
                <?php foreach ($content['highlights'] as $highlight) : ?>
                    <article class="row loop-object">
                        <?php if ($highlight["image"]): ?>
                            <div class="image-container image-column columns-4">
                                <img src="<?= $highlight["image"]["url"] ?>" alt="<?= $highlight["image"]["alt"] ?>">
                            </div>
                        <?php endif; ?>
                        <div class="content-column columns-8">
                        <?php if ($highlight["heading"]): ?>
                            <h3 style="color:<?php echo $highlight_one ;?>"><?= $highlight["heading"]; ?></h3>
                        <?php endif; ?>
                        <?php if ($highlight["content"]): ?>
                            <p><?= $highlight["content"]; ?></p>
                        <?php endif; ?>
                        </div>

                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        </section>
    <?php
    endforeach; ?>
<?php
endif;
