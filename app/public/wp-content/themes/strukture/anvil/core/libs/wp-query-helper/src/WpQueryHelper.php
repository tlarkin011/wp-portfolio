<?php

namespace WpQueryHelper;

class WpQueryHelper
{
    protected $wp_query = null;
    protected $queryArgs = [];
    protected $searchKey = 's';

    public function getWPQuery()
    {
        return $this->wp_query;
    }

    public function withTaxs($args = [])
    {
        if (is_string($args)) {
            $args = [$args];
        }

        $this->queryArgs = $args;

        return $this;
    }

    public function withSearch($key = 's')
    {
        $this->searchKey = $key;

        return $this;
    }

    public function query($post_type, $limit = null, $args = [])
    {
        $limit = is_null($limit)? get_option('posts_per_page') : $limit;
        $paged = get_query_var('paged')? get_query_var('paged') : 1;

        $args = wp_parse_args($args, [
            'post_type' => $post_type,
            'posts_per_page' => $limit,
            'paged' => $paged
        ]);

        $this->maybeAddQueryArgs($args);
        $this->maybeAddSearchArgs($args);

        $this->wp_query = new \WP_Query($args);

        return $this;
    }

    public function random($post_type, $limit = null, $args = [])
    {
        return $this->query($post_type, $limit, wp_parse_args($args, ['orderby' => 'rand']));
    }

    public function latest($post_type, $limit = null, $args = [])
    {
        return $this->query($post_type, $limit, wp_parse_args($args, [
            'orderby' => 'date',
            'order' => 'desc'
        ]));
    }

    public function related($limit, $relatedWith = 'category', $args = [], $excludedTermIds = [], $excludedPostIds = [])
    {
        $current_id = get_the_ID();
        $current_post_type = get_post_type();

        if (is_string($relatedWith)) {
            $relatedWith = [$relatedWith];
        }

        $tax_query = [
            'relation' => 'OR'
        ];

        foreach ($relatedWith as $taxonomy) {
            $the_terms = get_the_terms($current_id, $taxonomy) ?? [];
            if (!$the_terms ) { continue; }

            $term_ids = wp_list_pluck($the_terms, 'term_id');
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => array_diff($term_ids, $excludedTermIds),
            ];
        }

        array_push($excludedPostIds, $current_id);

        $args = wp_parse_args($args, [
            'post__not_in' => $excludedPostIds,
            'tax_query' => $tax_query
        ]);

        return $this->query($current_post_type, $limit, $args);
    }

    protected function maybeAddQueryArgs(& $args)
    {
        if (! $this->queryArgs) {
            return;
        }


        if (! $args['tax_query']) {
            $args['tax_query'] = [];
        }

        foreach ($this->queryArgs as $taxonomy)
        {
            if (! $term = acf_maybe_get($_GET, $taxonomy)) continue;

            if ($term == 'all') continue;

            $args['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term
            ];
        }
    }

    protected function maybeAddSearchArgs(& $args)
    {
        if (! $keywords = trim(acf_maybe_get($_GET, $this->searchKey))) {
            return;
        }

        $args['s'] = $keywords;
    }

    public function getTaxSelect($taxonomy, $queryArgs = [], $class = '')
    {
        $terms = get_terms($taxonomy, $queryArgs)? : [];

        $options = array_map(function($term) use ($taxonomy) {
            $current = acf_maybe_get($_GET, $taxonomy) === $term->slug? 'selected' : '';
            return sprintf('<option %s value="%s">%s</option>', $current, $term->slug, $term->name);
        }, $terms);

        return sprintf('<select name="%s" class="%s">%s</select>', $taxonomy, $class, implode('', $options));
    }

    public function getSearchInput($placeholder = '', $class = '')
    {
        return sprintf('<input type="text" name="%s" value="%s" placeholder="%s" class="%s" />',
            $this->searchKey,
            acf_maybe_get($_GET, $this->searchKey),
            $placeholder,
            $class
        );
    }

    public function loop($template, $before = '', $after = '')
    {
        if (! $this->wp_query) {
            $this->query();
        }
        if ($this->wp_query->have_posts()) {
            echo $before;
            while ($this->wp_query->have_posts()): $this->wp_query->the_post();
                get_template_part($template);
            endwhile;
            echo $after;

        }
        else {
            get_template_part('templates/loop/no-posts');
        }


        wp_reset_query();
    }

    public function __call($method, $args)
    {
        if ($this->wp_query && method_exists($this->wp_query, $method)) {
            return call_user_func_array([$this->wp_query, $method], $args);
        }

        trigger_error(
            sprintf('Error: Call to undefined method %s()', str_replace('__call', $method, __METHOD__)),
            E_USER_ERROR
        );
    }

    public function __get($key)
    {
        if ($this->wp_query && isset($this->wp_query, $key)) {
            return $this->wp_query->{$key};
        }

        trigger_error(
            sprintf('Error: Undefined property %s', $key),
            E_USER_ERROR
        );
    }
}
