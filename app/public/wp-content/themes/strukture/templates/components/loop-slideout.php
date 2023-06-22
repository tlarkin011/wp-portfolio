<?php
$post_type = forge_var('post-type') ? forge_var('post-type') : 'post';
$block_grid = forge_var('block-grid');
$posts_per_page = forge_var('posts_per_page') ? forge_var('posts_per_page') : -1;
$hidden = forge_var('hidden');
$content = forge_var('content');

?>

<section class="<?php echo $post_type ?>-slideout">
    <div class="row row-center">

        <div class="slideout-container block-grid-<?php echo $block_grid ?>">

            <?php
            $args = wp_parse_args(forge_var('args'), [
                'post_type' => $post_type,
                'posts_per_page' => $posts_per_page
            ]);

            $query = new WP_Query($args);

            while ($query->have_posts()) : $query->the_post();

                forge_template('loop/slideout', ['block-grid' => $block_grid, 'hidden' => $hidden, 'content' => $content]);

            endwhile;
            wp_reset_query();
            ?>

        </div>

    </div>
</section>
