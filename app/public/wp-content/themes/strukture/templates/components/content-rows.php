<?php 
/* 
// Content rows component 
// How to use:
// <?php forge_template('components/content-rows', ['field_name' => 'acf_field_name']); ?>
// COMPONENT CANNOT BE NESTED
// Accepted vars 
// field_name <- Self explanatory
// options <- Set to "true" if field is on an options page
// id <- id for wrapper div, useful for specific customizations 
// class <- class for wrapper div, useful for specific customizations. Component type and field name are added automatically.
// heading_tag <-- the heading tag to be used, defaults to h2
*/

$field_name = forge_var('field_name');
$option = forge_var('option');
$id = forge_var('id');
$class = forge_var('class');
$child_class = forge_var('child_class');
$heading_tag = forge_var('heading_tag') ? forge_var('heading_tag') : 'h2';
$content_columns = forge_var('content_columns');

$contents = stk_get_field($field_name, $option);
$alignment = $contents[0]['content_rows_alignment'];
$content_rows = $contents[0]['content_rows_row'];
?>
<div <?php if($id) { echo 'id="'.$id.'"'; } ?> class="<?php $field_name; ?>  <?php $class; ?> <?php echo " content-rows-component stk-component"; ?>">
	<?php forge_template('components/content', ['nested' => "true", 'alignment' => $alignment, 'contents' => $content_rows, 'heading_tag' => $heading_tag, 'content_columns' => $content_columns, 'class' => $child_class]); ?>
</div>
<?php
// Reset $contents to avoid variable repeating bugs
$contents = '';

?>