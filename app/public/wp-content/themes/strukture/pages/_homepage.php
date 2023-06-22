<?php
/*
 *  Template Name: Home Page
 */
get_header();
the_post(); 
$strukture_class = strukture_style();
$background_variables = background_variables();
?>

<?php forge_template('components/page-banner', ['field_name' => 'page_banner', 'class' => 'homepage-banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">


	<?php forge_template('components/content/content-image', ['field_name' => 'who_we_are_overview', 'heading_tag' => 'h2']); ?>

	<div class="blue-background">
		<?php forge_template('components/content/content-intro', ['field_name' => 'how_it_works_intro']); ?>
		<?php forge_template('components/icon-posts', ['nested' => false, 'field_name' => 'how_it_works_highlights', 'block_grid' => '3']); ?>
	</div>

	<?php forge_template('components/content/content-intro', ['field_name' => 'how_we_help_intro']); ?>
	<?php forge_template('components/icon-posts', ['nested' => false, 'field_name' => 'how_we_help_highlights', 'block_grid' => '4']); ?>


	<div class="featured-case-study-wrapper">
		<div class="row row-center">
			<?php 

			$posts = get_field('featured_case_study');
			$show_case_study_link = get_field('show_case_study_link');

			if( $posts ): ?>
				<?php foreach( $posts as $post): ?>
					<?php setup_postdata($post); ?>

					<div class="featured-case-study columns-12 flex">

						<div class="image-column columns-6">
							<?php the_post_thumbnail();?>

						</div>

						<div class="content-column columns-6">
							<h6>Featured Case Study</h6>
							<h2><?php the_title();?></h2>
							<p><?php the_excerpt();?></p>
							<div class="quote-block">
								<p><?php echo the_field('quote');?></p>
								<h6><?php echo the_field('source');?></h6>
							</div>

							<div class="cta-container">
								<?php if (get_field('video_link')) {?>
									<a class="button one" href="<?php echo the_field('video_link');?>" data-fancybox>Watch Video<i class="far fa-play-circle"></i>
										<?php } ?></a>
										

										<?php if( $show_case_study_link ) : ?>
											<a class="button three" href="<?php the_permalink();?>">Read More</a>
										<?php endif; ?>


									</div>
								</div>
							</div>
						<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
			</div>
			<!-- <div class="mobile-bg"> -->
				<?php //forge_template('components/content/content-intro', ['field_name' => 'recent_posts_intro']); ?>
				<?php //forge_template('components/posts/standard-posts', ['post_type' => 'post', 'posts_per_page' => 3, 'block_grid' => '3']); ?>
				<!-- </div> -->
			</div>
			<?php get_footer(); ?>
