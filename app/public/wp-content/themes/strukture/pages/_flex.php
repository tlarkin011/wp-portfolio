<?php
/*
 *  Template Name: Flex Content
 */
get_header(); the_post();
$strukture_class = strukture_style();
$background_variables = background_variables();
?>

<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">
	<?php 
		background_blocks($background_variables);
	?>
	
	<?php forge_template('components/flex-content', ['field_name' => 'flex_content']); ?>

</div>

<?php get_footer();?>
