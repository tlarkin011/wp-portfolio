<?php
if (forge_var('nested')) {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name', 'content_with_categories');
    $contents = stk_get_field($field_name);
}
if ($contents) {
    foreach ($contents as $content) {
        ?>
        <section class="content-with-categories">
            <div class="row row-center">
                <div class="columns-6">
                    <?php ForgeAcf::nested_content_block($content['content'][0], 'content-with-categories-content'); ?>
                </div>
                <div class="columns-6">
                    <ul class="block-grid-2 category-grid">
                        <?php foreach ($content['categories_grid'] as $category_item) : ?>
                            <?php if ($category_item['link']) : ?>
                                <a href="<?= $category_item['link']; ?>">
                            <?php endif; ?>
                            <article>
                                <div class="background-container row row-center">
                                    <?php if ($category_item["icon"]) : ?>
                                        <img src="<?= $category_item["icon"]["url"]; ?>"
                                             alt="<?= $category_item["icon"]["alt"]; ?>">
                                    <?php endif; ?>
                                    <?php if ($category_item["title"]) : ?>
                                        <h4 class="heading columns-11"><?= $category_item["title"]; ?></h4>
                                    <?php endif; ?>
                                </div>
                            </article>
                            <?php if ($category_item['link']) : ?>
                                </a>
                            <?php endif; ?>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php }
}
?>