<?php get_header();?>

<?php forge_template('page-banner');?>

<div class="row row-center">

	<?php if( have_posts() ) : ?>

		<div class="block-grid-1">
			<?php while (have_posts()): the_post(); ?>
				<?php forge_template('loop/search'); ?>
			<?php endwhile; ?>

			<?php forge_template('components/pagination'); ?>
		</div>

		<?php else : ?>

			<div class="no-results">
				<h3>No results turned up! Try something else below</h3>
				<?php echo get_search_form(); ?>
			</div>

		<?php endif; ?>
	</div>

	<?php get_footer();?>
