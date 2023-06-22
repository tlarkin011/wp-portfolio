<?php
/*
 *  Template Name: Post Page
 */
get_header();
the_post(); 
$strukture_class = strukture_style();

?>


<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>


<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php forge_template('components/loop-slideout', ['post-type' => 'team_member', 'block-grid' => 3, 'hidden' => 'components/slideout/team-slideout-hidden', 'content' => 'components/slideout/team-slideout-content']); ?>
	<?php forge_template('components/posts/background-posts', ['post_type' => 'service', 'posts_per_page' => 6, 'block_grid' => '3']); ?>
	<?php forge_template('components/featured-testimonials', ['field_name' => 'featured_testimonial']);?>
	<?php forge_template('components/icon-posts', ['nested' => false, 'field_name' => 'icon_post_test', 'block_grid' => '4']); ?>

	<?php forge_template('components/posts/standard-posts', ['post_type' => 'service', 'posts_per_page' => -1, 'block_grid' => '2']); ?>

</div>


<?php get_footer(); ?>
