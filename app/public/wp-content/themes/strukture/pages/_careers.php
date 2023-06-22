<?php
/*
 *  Template Name: Career Page
 */
get_header();
the_post();
$strukture_class = strukture_style();
$background_variables = background_variables();
?>

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner', 'class' => 'homepage-banner']); ?>
	
<div class="strukture-wrapper <?php echo $strukture_class;?>">
	
	<?php forge_template('components/content/content-image', ['field_name' => 'culture_content']); ?>
	
	<style>
		.job-listings + .blue-background {
			margin-bottom: 0;
		}
	</style>

	<?php forge_template('components/job-listings', ['field_name' => 'jobs']); ?>

	<div class="blue-background">
		<?php forge_template('components/content/content-intro', ['field_name' => 'employment_highlights_headline']); ?>
		<?php forge_template('components/highlights', ['field_name' => 'highlights']); ?>
	</div>

</div>

<?php get_footer(); ?>
