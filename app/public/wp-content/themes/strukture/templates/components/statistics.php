<?php
if (forge_var('nested')) {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name') ? forge_var('field_name') : 'highlights';
    $contents = stk_get_field($field_name);
}

foreach ($contents as $content) : ?>
    <section class="statistics-container">
        <div class="row row-center">
            <div class="block-grid-3 columns-10">
                <?php foreach ($content["statistics"] as $statistic) : ?>

                    <div class="statistic">
                        <h1 class="stat" data-count="<?= $statistic['statistic']; ?>">0</h1>
                        <h5><?= $statistic["label"]; ?></h5>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class="columns-10">
                <?php forge_template('components/content', ['nested' => true, 'contents' => $content["content"]]); ?>
            </div>
        </div>
    </section>

<?php endforeach; ?>