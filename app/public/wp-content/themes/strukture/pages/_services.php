<?php
/*
 *  Template Name: Service Page
 */
get_header();
the_post(); 
$strukture_class = strukture_style();
?>

<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php forge_template('components/posts/wide-unlinked-posts', ['post_type' => 'service', 'posts_per_page' => -1, 'block_grid' => '2']); ?>
	
</div>


<?php get_footer(); ?>
