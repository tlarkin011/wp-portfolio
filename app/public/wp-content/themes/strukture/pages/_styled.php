<?php
/*
 *  Template Name: Styled Page
 */
get_header();
the_post();

$strukture_class = strukture_style();

?>




<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>
	<?php forge_template('components/content/content-intro', ['field_name' => 'intro_standard_centre']); ?>
	<?php forge_template('components/content/content-intro', ['field_name' => 'intro_standard_left']); ?>
	<?php forge_template('components/content/content-image', ['field_name' => 'left_content_standard_image']); ?>
	<?php forge_template('components/content/content-image', ['field_name' => 'right_content_standard_image']); ?>
	<?php forge_template('components/content/content-image', ['field_name' => 'left_content_full_image']); ?>
	<?php forge_template('components/content/content-image', ['field_name' => 'right_content_full_image']); ?>
	<?php forge_template('components/content/content-background', ['field_name' => 'full_width_background_callout', 'heading_tag' => 'h3']); ?>
	<?php forge_template('components/content/content-background', ['field_name' => 'centered_background_full']); ?>
	<?php forge_template('components/highlights', ['field_name' => 'highlights']); ?>
	<?php forge_template('components/accordion', ['field_name' => 'accordion']); ?>

</div>



<?php get_footer(); ?>
