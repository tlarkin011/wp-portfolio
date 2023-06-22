<?php
$field_name = forge_var('field_name');
$class;
$contents = forge_var('contents');



if( $field_name ) {
  $testimonials = get_field($field_name)[0]['featured_testimonials'];
} elseif( $contents ) {
  $testimonials = $contents[0]['featured_testimonials'];
}



if( sizeof($testimonials) > 1) {
  $class = 'testimonial-slider';
} else {
  $class = '';
};

$args = array(
  'post_type' => 'testimonial',
  'posts_per_page' => -1,
  'post__in' => $testimonials
);

$query = new WP_Query($args);

$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');


?>

<?php if( $testimonials ) : ?>

  <section class="featured-testimonials">

    <div class="row row-center">

      <div class="testimonials columns-10 right-2 <?php echo $class ?>">

        <?php while($query->have_posts()) : $query->the_post(); ?>
          <?php // check for thumbnail image
            $has_thumbnail = has_post_thumbnail();
          ?>

         <div class="testimonial flex <?php echo $has_thumbnail? '' : 'center-text'; ?>">

          <?php if ($has_thumbnail) : ?>
          <div class="image columns-3">
            <?php the_post_thumbnail('medium'); ?>
          </div>
          <?php endif; ?>

          <div class="content columns-8">
            <p><?php echo get_field('quote'); ?></p>
            <h5 ><?php echo get_field('source'); ?></h5>
          </div>

        </div>

      <?php endwhile; wp_reset_postdata(); ?>
    </div>

  </div>

</section>

<?php endif; ?>
