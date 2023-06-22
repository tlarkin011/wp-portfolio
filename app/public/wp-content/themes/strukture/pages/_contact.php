<?php
/*
 *  Template Name: Contact
 */
get_header(); the_post();
$strukture_class = strukture_style();
$background_variables = background_variables();?>


<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">
	
	<?php 
		background_blocks($background_variables);
	?>

	<?php forge_template('components/map/map-info', ['field_name' => 'contact_map']); ?>
	<?php forge_template('components/content-shortcode', ['field_name' => 'get_in_touch_form']); ?>

</div>

<?php get_footer();?>
