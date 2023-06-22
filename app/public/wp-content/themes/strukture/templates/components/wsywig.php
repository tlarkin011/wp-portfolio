<?php
/*
// Generic content component
// How to use:
// <?php forge_template('components/content', ['field_name' => 'acf_field_name']); ?>
// Accepted vars
// field_name <- Self explanatory
// options <- Set to "true" if field is on an options page
// id <- id for wrapper div, useful for specific customizations
// class <- class for wrapper div, useful for specific customizations. Component type and field name are added automatically.
// nested <-- set to "true" if using this component inside another component, will bypass ACF functions. See components/content-rows.php for use case.
// contents <-- used together with 'nested' to pass content directly to the component. Useful when nesting. See components/content-rows.php for use case.
// alignment <-- used together with 'nested' to pass content alignment. See components/content-rows.php for use case.
*/

$nested = forge_var('nested');
if ($nested == "true") {
    $contents = forge_var('contents');
} else {
    $field_name = forge_var('field_name');
    $option = forge_var('option');
    $id = forge_var('id');
    $contents = stk_get_field($field_name, $option);
}

$class = forge_var('class');
$heading_tag = forge_var('heading_tag') ? forge_var('heading_tag') : 'h2';

// variables for text colors

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');

  ?>

  
    <article class="content-component row row-center wsywig-flex">
        <div class="columns-10">
                     <?php echo $contents; ?>
        </div>

    </article>

 

