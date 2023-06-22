<article class="standard-team-member">

  <div class="grid-item">


    <div class="grid-image">

      <?php echo the_post_thumbnail(); ?>

    </div>


    <div class="grid-content">

      <h4><?php the_title() ?></h4>
      <p><?php echo get_field('team_member_position') ?></p>

      <div class="team-contact">

        <a href="<?php echo get_field('team_member_li') ?> " target="_blank">
          <i class="fab fa-linkedin" aria-hidden="true"></i>
        </a>

        <a href="mailto:<?php echo get_field('team_member_email') ?>">
          <?php echo get_field('team_member_email'); ?>
        </a>

      </div>

      <?php if(get_field('team_member_short_bio')) : ?>

        <p><?php echo get_field('team_membet_short_bio') ?></p>

        <?php else : ?>

          <?php excerpt(15) ?>

        <?php endif; ?>

      </div>


    </div>

  </article>
