<?php get_header(); the_post();


$strukture_class = strukture_style();
$background_variables = background_variables();

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');
?>

<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>


<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php 
		background_blocks($background_variables);
	?>

	<?php forge_template('components/content/content-image', ['field_name' => 'overview']); ?>
	<?php forge_template('components/content/content-intro', ['field_name' => 'benefits_intro']); ?>
	<?php forge_template('components/highlights', ['field_name' => 'benefits']); ?>

	<div class="featured-case-study-wrapper">
			<div class="row row-center">
				<?php 
				$posts = get_field('featured_case_study');
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
										<a class="button one" href="<?php echo the_field('video_link');?>">Watch Video<i class="far fa-play-circle"></i></a>
										<a class="button three" href="<?php the_permalink();?>">Read More</a>
									</div>
								</div>
							</div>
				    <?php endforeach; ?>
				    <?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		</div>


<?php forge_template('components/content/content-intro', ['field_name' => 'related_posts_headline', 'option' => true]); ?>	










<?php 

// get only first 3 results
$ids = get_field('related_posts', false, false);
  $query = new WP_Query(array(
	'post_type'      	=> 'post',
	'posts_per_page'	=> 2,
	'post__in'			=> $ids,
	'post_status'		=> 'any',
	'orderby'        	=> 'post__in',
));


   if ($query->have_posts()):?>

        <div class="row row-center blog-post-wrapper">
            <div class="columns-12 blog-post-loop block-grid-2">

                <?php while ($query->have_posts()):$query->the_post(); ?>


                         <article class="loop-content loop-post row">
            <div class="columns-12 image-column">
                <?php forge_thumbnail_link(); ?>
            </div>

            <div class="columns-12 content-column">

                  <?php  

                                  $terms = get_the_terms( $query->ID , 'category' );
                                
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
                         
                                  ?>

              <h3 style="color:<?php echo $highlight_one;?>"  class="loop-title"><?php forge_title_link(); ?></h3>

              <?php excerpt(); ?>

                 <a style="color:<?php echo $highlight_two;?>;"  href="<?php the_permalink(); ?>" class="read-more">Read More</a>
            </div>
        </article>
                <?php endwhile; ?>

            </div>
        </div>

        <?php wp_reset_postdata();
    endif; ?>




 

 		<?php forge_template('components/content/content-background', ['field_name' => 'services_footer_callout', 'option' => true]); ?>

</div>
<?php get_footer();?>
