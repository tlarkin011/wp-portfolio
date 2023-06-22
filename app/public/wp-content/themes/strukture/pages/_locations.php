<?php
/*
 *  Template Name: Locations Page
 */
get_header();
the_post();
$strukture_class = strukture_style();
?>

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">

		<?php forge_template('components/map/map'); ?>
		<?php forge_template('components/map/map-loop', ['post_type' => 'location']); ?>

</div>

<?php get_footer(); ?>
