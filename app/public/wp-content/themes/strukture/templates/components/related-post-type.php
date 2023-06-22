<?php
$related_terms = get_the_terms($post, 'related');
$related_term = $related_terms[0];
$post_number = forge_var('post_number');
$post_type = forge_var('post_type');
$field_name = forge_var('field_name');

$args = [
    'tax_query' => [
        [
            'taxonomy' => 'related',
            'field' => 'term_id',
            'terms' => $related_term->term_id,
        ]
    ]
];
$query = (new ForgeQuery)->query($post_type, $post_number = forge_var('post_number')
    , $args);
?>
<section class="related-resources-container side-button-content">
    <?php forge_template('components/content', ['field_name' => $field_name, 'option' => true, 'heading_tag' => 'h3']); ?>
    <div class="block-grid-<?echo $post_number; ?> row row-center">
        <?php $query->loop('templates/loop/related-post'); ?>
    </div>
</section>
