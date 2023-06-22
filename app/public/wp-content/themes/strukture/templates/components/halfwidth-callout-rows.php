<?php
$field_name = forge_var('field_name');
$option = forge_var('option');
$content_rows  = stk_get_field($field_name, $option); ?>
<section class="halfwidth-callouts">
    <?php foreach ($content_rows as $content_row) :
        forge_template('components/halfwidth-callouts', ['content_row' => $content_row, 'nested' => true]);
    endforeach; ?>
</section>
