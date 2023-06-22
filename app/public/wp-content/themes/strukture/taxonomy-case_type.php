<?php get_header(); the_post();?>

<?php forge_template('single/case-search'); ?>

<?php if(have_posts() ) : ?>


  <article class="background-post-wrapper">
  	<div class="row row-center">
  		<div class="columns-12 background-post-loop block-grid-2">

    <?php while (have_posts()): the_post(); ?>
   
				 <article class="content-component loop-content loop-post thumbnail-bg" <?php forge_bg(get_post_thumbnail_id()); ?>>
              
                  <div class="content-column ">

                    <h4 style="color:<?php echo $highlight_one;?>" class="loop-title"><?php forge_title_link(); ?></h4>
                    <p><?php excerpt(); ?></p>

                     <a style="color:<?php echo $highlight_one;?>; border-bottom:1px solid <?php echo $highlight_one;?>;"  href="<?php the_permalink(); ?>" class="read-more">Learn More</a>
                   </div>
            </article>


    <?php endwhile; ?>

  </div>

   <?php forge_template('components/pagination'); ?>

</div>

</article>

  <?php else : ?>

    <div class="no-posts-found">
      <h2>No Posts Found</h2>
    </div>

  <?php endif; ?>


  <?php forge_template('components/content/content-background', ['field_name' => 'services_footer_callout', 'option' => true]); ?>

<?php get_footer();?>