<?php 
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');
?>


<article class="team-slideout-content">
  <h4><?php the_title() ?></h4>

  <?php if(get_field('team_member_position')) : ?>
    <p><?php echo get_field('team_member_position'); ?></p>
  <?php endif; ?>

</article>
