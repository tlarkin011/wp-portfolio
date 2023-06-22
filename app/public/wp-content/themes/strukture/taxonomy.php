<?php get_header();?>

<?php forge_template('page-banner');?>

<?php if(have_posts() ) : ?>

  <div class="columns-12 loop-column block-grid-3">
    <?php while (have_posts()): the_post(); ?>
      <?php forge_template('loop/post'); ?>
    <?php endwhile; ?>

    <?php forge_template('components/pagination'); ?>
  </div>

  <?php else : ?>

    <div class="no-posts-found">
      <h2>No Posts Found</h2>
    </div>

  <?php endif; ?>

  <?php get_footer();?>
