<?php
$option = forge_var('option');
$contents = forge_var('content_row') ? forge_var('content_row') : stk_get_field(forge_var('field_name'), $option);
$nested = forge_var('nested');

if ($nested) {
    $firstCallout = $contents['left_callout'];
    $secondCallout = $contents['right_callout'];
}
else {
    $firstCallout = $contents[0]['left_callout'];
    $secondCallout = $contents[0]['right_callout'];
}

?>

<div class="callout-columns page-section">
    <div class="row columns-12">
        <div class="columns-6 bg-brand-color-main half-width-callout">
            <?php forge_template('components/content', ['nested' => true, 'contents' => $firstCallout, 'class' => 'halfwidth-callout use-bg', 'heading_tag' => 'h3']); ?>
        </div>
        <div class="columns-6 bg-brand-color-secondary half-width-callout">
            <?php forge_template('components/content', ['nested' => true, 'contents' => $secondCallout, 'class' => 'halfwidth-callout use-bg', 'heading_tag' => 'h3']); ?>
        </div>
    </div>
</div>
