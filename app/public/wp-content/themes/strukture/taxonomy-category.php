<?php get_header(); the_post();?>

<?php forge_template('components/search-banner'); ?>

<?php if(have_posts() ) : ?>

	<div class="row row-center blog-post-wrapper">
		<div class="columns-12 blog-post-loop block-grid-2">

    <?php while (have_posts()): the_post(); ?>
   
				<article class="loop-content loop-post row">
				    <div class="columns-12 image-column">
				        <?php forge_thumbnail_link(); ?>
				    </div>

				    <div class="columns-12 content-column">

				    	   <h4 class="loop-title"><?php forge_title_link(); ?></h4>

								<?php   
										$terms = get_the_terms( $post->ID , 'category' );
									
										if ( $terms != null ){
											foreach( $terms as $term ) {
												$term_link = get_term_link( $term, 'category' );
												
												echo '<div class="product-cat">';
												echo '<a href="' . $term_link . '">' . $term->name . '</a>';
												
												echo the_tags("");
												echo '</div>';
												unset($term);

											 } 
										} 
								?>

			        	<?php excerpt(); ?>

				        <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
				    </div>
				</article>


    <?php endwhile; ?>

  </div>

   <?php forge_template('components/pagination'); ?>

</div>



  <?php else : ?>

    <div class="no-posts-found">
      <h2>No Posts Found</h2>
    </div>

  <?php endif; ?>




<?php get_footer();?>