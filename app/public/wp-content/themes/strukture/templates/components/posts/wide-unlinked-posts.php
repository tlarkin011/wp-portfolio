
<?php

$post_type = forge_var('post_type');

$posts_per_page = forge_var('posts_per_page');
$block_grid = forge_var('block_grid');
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');


?>

	<div class="row row-center blog-post-wrapper wide-post unlinked-post">
		<div class="columns-12 blog-post-loop">

				  <?php
			        $args = array(
			          'post_type' => $post_type,
			          'posts_per_page' => $posts_per_page
			        );

			        $query = new WP_Query($args);

			        while($query->have_posts()) : $query->the_post();?>

			        	<?php

			        	$optional_color = "";

			        	 if  (get_field('optional_color')) {
							$optional_color = get_field('optional_color');
						} ?>

				<article style="background-color: <?php echo $optional_color;?>;" class="loop-content loop-post columns-12">
				    <div class="columns-3 image-column">
				        <?php the_post_thumbnail(); ?>
				    </div>

				    <div class="columns-9 content-column">




			        <h3 class="loop-title"><?php the_title(); ?></h3>

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

				    </div>
				</article>

	<? endwhile; wp_reset_query(); ?>				

		</div>
    </div>

