
<?php

$post_type = forge_var('post_type');
$posts_per_page = forge_var('posts_per_page');
$block_grid = forge_var('block_grid');
$taxonomy = forge_var('taxonomy');
$term = forge_var('term');
?>

	<div class="row row-center blog-post-wrapper">
		<div class="columns-12 blog-post-loop block-grid-<?php echo $block_grid;?>">

				  <?php
			        $args = array(
			          'post_type' => $post_type,
			          'posts_per_page' => $posts_per_page,
			          'tax_query' => array(
				        array (
				            'taxonomy' => $taxonomy,
				            'field' => 'slug',
				            'terms' => $term,
				        )
				    ),
							        );

			        $query = new WP_Query($args);

			        while($query->have_posts()) : $query->the_post();?>


				<article class="loop-content loop-post row">
				    <div class="columns-12 image-column">
				        <?php forge_thumbnail_link(); ?>
				    </div>

				    <div class="columns-12 content-column">


			    			  <?php  

			    			  		if($post_type == 'post') {
			                            $terms = get_the_terms( $post->ID , 'category' );
			                          
			                            if ( $terms != null ){
			                              foreach( $terms as $term ) {
			                              $term_link = get_term_link( $term, 'category'  );
			                          
			                              echo '<div class="single-post-cat-list">';
			                              echo '<a href="' . $term_link . '">' . $term->name . '</a><p>,</p>';
			                           
			                              echo the_tags("");
			                              $post_date = get_the_date( 'F j, Y' );?>
			                              <p class="post-date"><?php echo $post_date;?></p>
			                              
			                              <?php echo '</div>';
			                              unset($term); } } 
			                            } 

			                        else {

			                        	  $terms = get_the_terms( $post->ID , $post_type . '_type' );
			                          
			                            if ( $terms != null ){
			                              foreach( $terms as $term ) {
			                              $term_link = get_term_link( $term, $post_type . '_type' );
			                          
			                              echo '<div class="single-post-cat-list">';
			                              echo '<a href="' . $term_link . '">' . $term->name . '</a><p>,</p>';
			                           
			                              echo the_tags("");
			                              $post_date = get_the_date( 'F j, Y' );?>
			                              <p class="post-date"><?php echo $post_date;?></p>
			                              
			                              <?php echo '</div>';
			                              unset($term); } } 

			                        }
			                            ?>



			        <h4 class="loop-title"><?php forge_title_link(); ?></h4>

			        <?php excerpt(); ?>

				        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
				    </div>
				</article>

	<? endwhile; wp_reset_query(); ?>				

		</div>
    </div>

