<?php
/*
 *  Template Name: Patients Page
 */
get_header();
the_post();
$strukture_class = strukture_style();
$background_variables = background_variables();

?>

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

<div class="strukture-wrapper <?php echo $strukture_class;?>">

	<?php 
		background_blocks($background_variables);
	?>

	<?php forge_template('components/content/content-image', ['field_name' => 'block_one']); ?>

<div class="mobile-bg">
	<?php forge_template('components/content/content-image', ['field_name' => 'block_two']); ?>
	<?php forge_template('components/content/content-image', ['field_name' => 'block_three']); ?>
</div>

	<?php forge_template('components/content/content-intro', ['field_name' => 'registration_intro']); ?>
	<?php forge_template('components/icon-posts', ['field_name' => 'registration_info_blocks', 'block_grid' => '4']); ?>

	<?php forge_template('components/content/content-background', ['field_name' => 'content_block']); ?>

<div class="mobile-bg">
	<?php forge_template('components/content/content-intro', ['field_name' => 'faq_intro']); ?>

<section class="faq-postings" id="opportunities">


	  <div class="row row-center">

	   <div class="accordion-holder columns-8">

	     <?php
	        $args = array(
	          'post_type' => 'faq',
	          'posts_per_page' => -1
	        );

	        $query = new WP_Query($args);

	        while($query->have_posts()) : $query->the_post();?>
	   
	           <div class="accordion-entry">

			        <div class="accordion-label">
			          <h5><?php echo the_title(); ?></h5>
			          <?php if( get_field('additional_label')) : ?>
			            <p ><?php echo the_field('additional_label') ?></p>
			          <?php endif; ?>
			        </div>

	       			 <div class="accordion-content">
				          <p><?php the_content();  ?></p>

				         <?php if( get_field('button_link' ) ) : ?>
				          <a style="background: <?php echo $highlight_one;?>;" class="button one" href="<?php echo the_field('button_link') ?>" target="_blank">Apply Now</a>
				          <?php endif; ?>

				      </div>
	      		</div>

	       <? endwhile; wp_reset_query();
	        ?>

			</div>
		</div>
	</section>
</div>

	
</div>

<?php get_footer(); ?>
