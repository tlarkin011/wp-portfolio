
<?php
/*
 *  Template Name: How It Works Page
 */
get_header();
the_post();
$strukture_class = strukture_style();
$background_variables = background_variables();

?>

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner', 'class' => 'homepage-banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php 
		background_blocks($background_variables);
	?>

	<?php forge_template('components/content/content-image', ['field_name' => 'stage_one']); ?>

<div class="mobile-bg">
	<?php forge_template('components/content/content-image', ['field_name' => 'stage_two']); ?>
	<?php forge_template('components/content/content-image', ['field_name' => 'stage_three']); ?>
</div>

	<?php forge_template('components/content/content-intro', ['field_name' => 'persona_intro']); ?>
	<?php forge_template('components/content/content-background', ['field_name' => 'aspiring_owners']); ?>

	<?php forge_template('components/content/content-background', ['field_name' => 'current_owners']); ?>
	<?php forge_template('components/content/content-background', ['field_name' => 'students']); ?>
	
</div>

<?php get_footer(); ?>
