<?php get_header(); the_post();

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



	<?php forge_template('components/content/content-intro', ['field_name' => 'related_posts_headline', 'option' => true]); ?>
 	<?php example_cats_related_background()?>

 	<?php forge_template('components/content/content-background', ['field_name' => 'services_footer_callout', 'option' => true]); ?>

</div>
<?php get_footer();?>
