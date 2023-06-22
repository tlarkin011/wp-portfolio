<?php
/**
 * This component takes a taxonomy and loops through each term and queries for posts
 * in that term
 *
 * vars:
 * taxonomy: wp taxonomy, default: category
 * post_template: path to the post template to be used, default: templates/loop/post
 * post_type: Post type to be queried, default: post
 *
 *
 **/
$taxonomy = forge_var('taxonomy', 'category');
$post_template = forge_var('post_template', 'templates/loop/post');
$post_type = forge_var('post_type', 'post');
$terms = get_terms(['taxonomy' => $taxonomy, 'order' => 'desc']);
if ($terms) :
    foreach ($terms as $term) :
        $args = [
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'terms' => $term->term_id,
                    'field' => 'term_id'
                ]
            ]
        ];
        $before = '<section class="taxonomy-loop"><div class="row"><div class="block-grid-3">';
        $after = '</section></div></div>';
        $query = (new ForgeQuery)->query($post_type, -1, $args);

        $query->loop($post_template, $before, $after);
    endforeach;
endif;
