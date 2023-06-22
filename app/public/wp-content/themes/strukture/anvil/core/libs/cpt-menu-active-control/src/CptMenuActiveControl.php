<?php

namespace CptMenuActiveControl;

class CptMenuActiveControl
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'register_reading_fields']);
        add_filter('nav_menu_css_class', [$this, 'fix_menu_current_item_class'], 10, 2);
    }

    public function register_reading_fields()
    {
        add_settings_section(
            'anvil_ctp_parent_page',
            'Custom Post Type Page Displays',
            [$this, 'section_description'],
            'reading'
        );

        $post_types = get_post_types([
            'public' => true,
            '_builtin' => false
        ], 'objects');

        foreach ($post_types as $slug => $post_type) {
            $field_name = "anvil_page_for_{$slug}";

            add_settings_field(
                $field_name,
                "Page for {$post_type->label}",
                [$this, 'generate_cpt_dropdown'],
                'reading',
                'anvil_ctp_parent_page',
                [$field_name]
            );

            register_setting('reading', $field_name, 'intval');
        }
    }

    public function section_description()
    {
        echo '<p>Determined which page should be highlighted in the menu when on custom post type\'s single.</p>';
    }

    public function generate_cpt_dropdown($args)
    {
        wp_dropdown_pages([
            'name' => $args[0],
            'show_option_none' => __( '&mdash; Select &mdash;' ),
            'option_none_value' => '0',
            'selected' => get_option($args[0])
        ]);
    }

    public function fix_menu_current_item_class($classes, $item)
    {
        if (is_singular('post') || is_home()) {
            return $this->globalized_menu_class($classes);
        }

        if (is_singular() || is_post_type_archive()) {
            $classes = $this->remove_current_class_on_blog_page($classes, $item);
            $classes = $this->maybe_add_post_type_current_class($classes, $item);
        }

        if (is_category() || is_tag()) {
            $classes = $this->maybe_add_taxonomy_current_class($classes, $item);
        }

        if (is_tax()) {
            $classes = $this->remove_current_class_on_blog_page($classes, $item);
            $classes = $this->maybe_add_taxonomy_current_class($classes, $item);
        }

        return $this->globalized_menu_class($classes);
    }

    protected function globalized_menu_class($classes)
    {
        if (in_array('current_page_parent', $classes)) {
            array_push($classes, 'current-menu-item');
        }

        if (in_array('current-page-ancestor', $classes)) {
            array_push($classes, 'current-menu-item');
        }

        return array_unique($classes);
    }

    protected function remove_current_class_on_blog_page($classes, $item)
    {
        if ($item->object_id == get_option('page_for_posts')) {
            $ind = array_search("current_page_parent", $classes);

            if (false !== $ind) {
                unset($classes[$ind]);
            }
        }

        return $classes;
    }

    protected function maybe_add_post_type_current_class($classes, $item)
    {
        $parent_page = get_option('anvil_page_for_' . get_query_var('post_type'));

        if ($parent_page && $item->object_id == $parent_page) {
            array_push($classes, 'current-menu-item');
        }

        return $classes;
    }

    protected function maybe_add_taxonomy_current_class($classes, $item)
    {
        $post_type = $this->get_taxonomy_post_type();

        $parent_page = get_option($post_type == 'post'? 'page_for_posts' : 'anvil_page_for_' . $post_type);

        if ($parent_page && $item->object_id == $parent_page) {
            array_push($classes, 'current-menu-item');
        }

        return $classes;
    }

    protected function get_taxonomy_post_type()
    {
        $taxonomy = get_taxonomy(get_queried_object()->taxonomy);

        return $taxonomy->object_type? $taxonomy->object_type[0] : '';
    }
}
