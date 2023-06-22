<?php
// excerpt(20); OR:
// excerpt('acf=blah&id=3'); OR:
// excerpt(array('acf' => 'blah', 'id' => 3));
function excerpt($args = []) {
    // quick cheat
    if (is_int($args)) {
        $args = [
            'limit' => $args,
        ];
    }

    $args = wp_parse_args($args, [
		'string'       => '',
		'id'           => null,
		'more'         => '...',
		'limit'        => 15,
		'acf'          => '',
		'echo'         => true,
		'autop'        => true,
		'true_excerpt' => true,
    ]);

    $has_excerpt = false;

    // is there a acf set?
    if (! $args['string'] && $args['acf']) {
        // acf takes care of the id if it's null already, alternitively you can pass something like, "category_4", "people-types_3", "options"
        $args['string'] = get_field($args['acf'], $args['id']);
    }

    // if no acf, is a id being passed? if no, user the current post
    if (! $args['string'] && ! $args['id']) {
        global $post;
        $args['id'] = isset($post->ID) ? $post->ID : null;
    }

    // now we use the id to fetch the excerpt
    if (! $args['string'] && $args['id']) {
        $the_post = get_post($args['id']);

        if ($the_post) {
            if ($the_post->post_excerpt) {
                $has_excerpt = $args['true_excerpt'] ? true : false;
                $args['string'] = $the_post->post_excerpt;
            } else {
                $args['string'] = apply_filters('the_excerpt', $the_post->post_content); // get_the_excerpt();
            }
        }
    }

    // trim the conent only if true_excerpt is not set to true
    if (! $has_excerpt) {
        $args['string'] = strip_shortcodes($args['string']);
        $args['string'] = wp_trim_words($args['string'], $args['limit'], $args['more']);
    }

    // check if it needs to warp with p tag
    if ($args['autop']) {
        $args['string'] = wpautop($args['string']);
    }

    if ($args['echo']) {
        echo $args['string'];
    }

    // last, return the result (doesn't matter if it's been echoed)
    return $args['string'];
}
