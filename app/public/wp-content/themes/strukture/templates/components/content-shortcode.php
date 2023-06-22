<?php
/*
// Content w/ Shortcode
// How to use:
// <?php forge_template('components/content-shortcode', ['field_name' => 'acf_field_name']); ?>
// Accepted vars
// field_name <- Self explanatory
// options <- Set to "true" if field is on an options page
// id <- id for wrapper div, useful for specific customizations
// class <- class for wrapper div, useful for specific customizations. Component type and field name are added automatically.
// COMPONENT CANNOT BE NESTED
*/

$nested = forge_var('nested');
if($nested == "true") {
	$contents = forge_var('contents');
	$alignment = forge_var('alignment');
} else {
	$field_name = forge_var('field_name');
	$option = forge_var('option');
	$id = forge_var('id');
	$class = forge_var('class');
	$contents = stk_get_field($field_name, $option);

}

$row = 0;
foreach ($contents as $content) {


// row alignment

	if($nested == "true") {
		$row_alignment = "center";
	}else {
		$row_alignment = $content['callout_component_align_column'];
	}
// columns

	if(!$content['callout_component_content_columns']) {
		$content_cols_num = 6;
		$cta_cols_num = 6;
		$img_cols_num = 6;
	} else {
		$content_cols_num = $content['callout_component_content_columns'];
		$remainder_cols = 12 - $content_cols_num;
		$cta_cols_num = $remainder_cols;
		$img_cols_num = $remainder_cols;
	}

// alignment

	if($alignment == 'alt') {
		if($row % 2 == 0){
			$flex_align = 'row-normal';
		}
		else{
			$flex_align = 'row-reverse';
		}
	}elseif($alignment == 'reverse') {
		$flex_align = 'row-reverse';
	}else {
		$flex_align = 'row-normal';
	}

	?>
	<div <?php if($id) { echo 'id="'.$id.'"'; } ?> class="<?= $field_name; ?>  <?= $class; ?> <?php if($field_name == 'page_banner') { echo " page-banner"; } else { echo " content-shortcode-component stk-component"; } ?>" <?php if($content['callout_component_image']) { forge_bg($content['callout_component_image']); }?> >
		<div class="row row-center <?= $flex_align; ?>">
			<div class="contact-heading columns-<?= $content_cols_num; ?> content-column">

				<!-- subtitle -->
				<?php if($content['callout_component_subtitle']) { ?>
					<p class="subtitle"><?= $content['callout_component_subtitle']; ?></p>
				<?php } ?>

				<!-- heading -->
				<?php if($content['callout_component_heading']) { ?>
					<h2 class="title"><?= $content['callout_component_heading']; ?></h2>
				<?php } ?>

				<!-- text -->
				<?php if($content['callout_component_text']) { ?>
					<p><?= $content['callout_component_text']; ?></p>
				<?php } ?>

			</div>

			<div class="contact-form-container columns-<?= $content_cols_num; ?> shortcode-column">
				<?php if($content['callout_component_shortcode']) { ?>
					<?php echo do_shortcode($content['callout_component_shortcode']); ?>
				<?php } ?>
			</div>

		</div>
	</div>

	<?php
	$row++;
}

// Reset $contents to avoid variable repeating bugs
$contents = '';


?>
