<?php
/*
 * Usage:
 * This requires 2 acf fields:
 * comparison_posts is a relationship field where the user can select posts to appear in the table
 *
 * comparison_table is where the table data is entered, it is a flex content component where each layout contains subfields for each table row
 * this allows different posts with different data to use this component, but all posts selected need to use the same flex layout
 * the query checks for this just in case
 *
 * In order to work, all posts selected need to have the same flex layout, and the current post needs to be selected in the relationship field
 *
 * */

$table_data = get_field('comparison_table');
$layout_name = $table_data[0]['acf_fc_layout'];
$comparison_posts = get_field('comparison_posts');

if ($comparison_posts) {
    // user can select the posts to be compared
    // the meta query ensures that all posts selected use the
    // same flex layout for the comparison table as the current post
    $args = [
        'post__in' => $comparison_posts,
        'orderby' => 'post__in',

        'meta_query' => [
            [
                'key' => 'comparison_table',
                'value' => '"' . $layout_name . '"',
                'compare' => 'LIKE'
            ]
        ]
    ];

    $product_query = (new ForgeQuery)->query('product', null, $args)->getWPQuery();
    if ($product_query->have_posts()) {
        $table_rows = stk_construct_table_rows_array('comparison_table', $product_query->posts);
        ?>
        <section class="comparison-table">
            <div class="row">
                <div class="columns-12">
                    <table>
                        <thead>
                        <th></th>
                        <?php foreach ($product_query->posts as $product) { ?>
                            <th><?php echo get_the_title($product->ID); ?></th>
                        <?php } ?>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($table_rows as $table_row) : ?>
                            <tr>
                                <td><?= $table_row['label']; ?></td>
                                <?php foreach ($table_row['data'] as $data) { ?>
                                    <td><?= $data; ?></td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td></td>
                            <?php foreach ($product_query->posts as $product) { ?>
                                <td><?php echo get_the_ID() === $product->ID ? 'Current Product' : '<a href="' . get_the_permalink($product->ID) . '">View Product</a>'; ?></td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    <?php }
} ?>