<?php get_header(); ?>

    <?php forge_template('page-banner'); ?>

    <div class="site-content" role="main">
        <div class="row">
            <div class="columns-12 loop-column">
                <?php while (have_posts()): the_post(); ?>
                    <?php forge_template('loop/post'); ?>
                <?php endwhile; ?>

                <?php forge_template('components/pagination'); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
