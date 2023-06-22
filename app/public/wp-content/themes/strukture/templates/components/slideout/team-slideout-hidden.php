<article class="team-slideout-hidden">

  <div class="columns-4">
   <h4><?php the_title(); ?></h4>
   <p><?php echo get_field('team_member_position'); ?></p>

   <div class="team-slideout-contact">

    <?php if (get_field('team_member_li')) : ?>
    <a href="<?php echo get_field('team_member_li'); ?> " target="_blank">
      <i class="fab fa-linkedin" aria-hidden="true"></i>
    </a>
    <?php endif; ?>

    <?php if (get_field('team_member_email')) : ?>
    <a href="mailto:<?php echo get_field('team_member_email'); ?>">
      <?php echo get_field('team_member_email'); ?>
    </a>
    <?php endif; ?>
  </div>

</div>

<div class="columns-7">

  <?php the_content(); ?>

</div>


</article>
