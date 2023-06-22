<section class="project-highlights columns-6">


  <?php
  if( have_rows('key_points') ): ?>
    <ul class="highlights-list">

     <?php while ( have_rows('key_points') ) : the_row(); ?>
       <li> <?php echo the_sub_field('key_text'); ?></li>
     <?php endwhile;
     else : ?>
     </ul>
   <?php endif; ?>


 </section>
