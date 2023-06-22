<?php get_header(); the_post();?>

<?php forge_template('single/faq-banner'); ?>

<?php if(have_posts() ) : ?>

	<section class="faq-postings" id="opportunities">


	  <div class="row row-center">

	   <div class="accordion-holder columns-8">


    <?php while (have_posts()): the_post(); ?>
   
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


    <?php endwhile; ?>

			</div>
		</div>
	</section>





   <?php forge_template('components/pagination'); ?>





  <?php else : ?>

    <div class="no-posts-found">
      <h2>No Posts Found</h2>
    </div>

  <?php endif; ?>




<?php get_footer();?>