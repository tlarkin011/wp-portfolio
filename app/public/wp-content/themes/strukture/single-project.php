<?php get_header(); the_post();?>

<?php forge_template('single/page-banner');?>

<div class="site-content row" role="main">

	<section class="project-info-wrapper columns-12">
		
		<?php custom_breadcrumbs(); ?>
		<?php the_title(); ?>

		<?php forge_template('components/featured-testimonials', ['field_name' => 'featured_testimonials']); ?>

	</section>



	<?php forge_template('components/single-nav', ['post' => 'project']); ?>

</div>

<?php get_footer();?>
