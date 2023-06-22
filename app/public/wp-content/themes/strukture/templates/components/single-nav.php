<?php

// If there is an "All posts" button in the design, create  fields in the
//options > general tab of "single_" followed by whatever post type.
// just add an "s" to $post_lionk if grammatically correct, but if it is a post type
//like "case studies", use the link title to create basic conditional logic for the
//view all button title

$post_link = forge_var('post');
$link = get_field('single_' . $post_link, 'option');
$link_title;

?>

<section class="page-section section-bottom page-nav single">
  <div class="row row-center">



    <?php $prev = get_adjacent_post( false, '', true ); ?>
    <?php if($prev) { ?>
      <div class="columns-4 prev-column">

        <a href="<?php echo get_permalink($prev); ?>" class="prev-link" >
          <h5 class="prev">  Previous </h5>
          <p> <?php echo get_the_title($prev); ?></p>

        </a>
      </div>

    <?php } else { ?>

       <div class="columns-4 prev-column disabled">

        <a href="<?php echo get_permalink($prev); ?>" class="prev-link" >
          <h5 class="prev">  Previous </h5>
          <p> <?php echo get_the_title($prev); ?></p>

        </a>
      </div>

    <?php } ?>



    <?php if($post_link) : ?>
      <div class="all-posts columns-4">

        <a class="button " href="<?php echo home_url('/projects/');?>">View All Projects</a>

      </div>
    <?php endif; ?>


    <?php $next = get_adjacent_post( false, '', false ); ?>

    <?php if($next) { ?>


        <div class="columns-4 next-column">

        <a href="<?php echo get_permalink($next); ?>" class="next-link" >
          <h5 class="next">Next </h5>
          <p> <?php echo get_the_title($next); ?></p>

        </a>
      </div>



      </div>
     <?php } else { ?>

     <div class="columns-4 next-column disabled">

        <div href="<?php echo get_permalink($next); ?>" class="next-link">

          <h5 class="next">Next </h5>
          <p> <?php echo get_the_title($next); ?></p>

        </div>


    <?php } ?>


  </div>
</section>





