<?php get_header(); the_post();?>

<?php forge_template('page-banner');?>

<div class="site-content" role="main">
  <?php forge_template('content/post'); ?>
</div>

<?php get_footer();?>
