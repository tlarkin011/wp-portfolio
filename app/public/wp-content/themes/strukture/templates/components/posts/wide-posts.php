
<?php

$post_type = forge_var('post_type');

$posts_per_page = forge_var('posts_per_page');
$block_grid = forge_var('block_grid');
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');
?>

	<div class="row row-center blog-post-wrapper wide-post">
		<div class="columns-12 blog-post-loop">

				  <?php
			        $args = array(
			          'post_type' => $post_type,
			          'posts_per_page' => $posts_per_page
			        );

			        $query = new WP_Query($args);

			        while($query->have_posts()) : $query->the_post();?>


				<article class="loop-content loop-post right-1 columns-11">
				    <div class="columns-3 image-column">
				        <?php forge_thumbnail_link(); ?>
				    </div>

				    <div class="columns-9 content-column">




			        <h3 class="loop-title"><?php forge_title_link(); ?></h3>

			        <p><?php echo the_field('service_main_content');?></p>
						<ul class="service-list block-grid-2">


					    <?php
							if( have_rows('service_highlights_list') ):
							    while ( have_rows('service_highlights_list') ) : the_row();?>
							        <li><?php echo the_sub_field('highlight');?></li>
							 <?php   endwhile;
							else :
							endif;
						?>
  							
  						</ul>

				       <a href="<?php the_permalink(); ?>" class="button one">Learn More</a>
				    </div>
				</article>

	<? endwhile; wp_reset_query(); ?>				

		</div>
    </div>

