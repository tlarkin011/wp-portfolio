<?php get_header(); the_post();
$strukture_class = strukture_style();
?>


    <?php forge_template('single/page-banner');?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">

<article class="row row-center single-post-content">

	<div class="columns-10">
		<?php the_content();?>
		 <?php forge_template('components/social-share'); ?>
	</div>

</article>

<div class="blue-blog-bg">

	<?php forge_template('components/content/content-intro', ['field_name' => 'related_posts_headline', 'option' => true]); ?>

 	<?php example_cats_related_post()?>
</div>
 	
</div>

<?php get_footer();?>
