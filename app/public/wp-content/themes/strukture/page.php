<?php get_header(); the_post();?>

	<?php forge_template('components/page-banner', ['field_name' => 'page_banner']); ?>

    <div class="site-content spacer-top" role="main">
        <?php forge_template('content/page'); ?>
    </div>

<?php get_footer();?>
