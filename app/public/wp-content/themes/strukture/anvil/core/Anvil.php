<?php

class Anvil
{
    protected static $_instance;
    protected $config = [];

    protected function __construct()
    {
        $this->load_config();
        $this->clean_up_wp_head();
        $this->setup_typekit();
        $this->add_acf_option_pages();

        add_action('after_switch_theme', [$this, 'after_switch_theme']);
        add_action('after_setup_theme', [$this, 'after_setup_theme']);
        add_action('init', [$this, 'init'], 0);
        add_action('wp_enqueue_scripts', [$this, 'register_frontend_scripts'], 15);
        add_action('wp_head', [$this, 'wp_head']);
        add_filter('oembed_dataparse', [$this, 'flex_oembed_frame'], 50, 3);

        // admin
        $this->load_tinymce_additional_styles();
        $this->load_tinymce_text_colors();
        add_action('login_head', [$this, 'theme_admin_logo']);
        add_action('admin_enqueue_scripts', [$this, 'register_admin_scripts']);
        add_action('wp_prepare_themes_for_js', [$this, 'disable_theme_update']);

        $this->load_chisel_libraries();
    }

    public static function instance()
    {
        if (!static::$_instance) {
            static::$_instance = new static;
        }

        return static::$_instance;
    }

    public function config($key, $default = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $default;
    }

    protected function load_config()
    {
        $config_file = get_stylesheet_directory() . '/.config.php';

        if (!file_exists($config_file)) {
            trigger_error('[Anvil] Unable to locate the config file at: ' . $config_file);
        }

        $this->config = require($config_file);
    }

    protected function clean_up_wp_head()
    {
        remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
        remove_action('wp_head', 'wp_generator'); // remove wordpress version

        remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
        remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links

        remove_action('wp_head', 'index_rel_link'); // remove link to index page
        remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)

        remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
        remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    }

    protected function setup_typekit()
    {
        if (!$this->config('typekit_id')) {
            return false;
        }

        add_filter('mce_external_plugins', [$this, 'typekit_tinymce_plugin']);
        add_filter('tiny_mce_before_init', [$this, 'typekit_tinymce_config']);
        add_action('wp_head', [$this, 'add_typekit_script']);
    }

    protected function add_acf_option_pages()
    {
        if (!$this->config('acf_option_pages')) {
            return;
        }

        if (!function_exists('acf_add_options_page')) {
            return;
        }

        acf_add_options_page();

        foreach ($this->config('acf_option_pages') as $pageName) {
            acf_add_options_sub_page($pageName);
        }
    }

    protected function load_tinymce_additional_styles()
    {
        if (!$this->config('enable_tinymce_additional_styles')) {
            return;
        }

        add_filter('mce_buttons_2', [$this, 'tinymce_add_style_dropdown'], 20);
        add_filter('teeny_mce_buttons', [$this, 'tinymce_add_style_dropdown'], 20);
        add_filter('tiny_mce_before_init', [$this, 'mce_before_init_insert_styles'], 20);
    }

    protected function load_tinymce_text_colors()
    {
        if (!$this->config('enable_tinymce_text_colors')) {
            add_filter('mce_buttons_2', [$this, 'tinymce_add_remove_forecolor']);
            return;
        }

        add_filter('teeny_mce_buttons', [$this, 'tinymce_add_forecolor']);
        add_filter('tiny_mce_before_init', [$this, 'mce_before_init_custom_colors']);
    }

    public function after_switch_theme()
    {
        update_option('rg_gforms_disable_css', '1');
        update_option('rg_gforms_enable_html5', '1');
    }

    public function after_setup_theme()
    {
        $this->enable_theme_supports();
        $this->register_nav_menus();
        $this->register_thumbnail_sizes();
    }

    public function init()
    {
        $this->register_post_types();
        $this->register_taxonomies();
        $this->register_editor_styles();
    }

    public function wp_head()
    {
        $this->inject_favicons();
        $this->ping_back_meta();
    }

    public function theme_admin_logo()
    {
        if (!$this->config('admin_logo')) {
            return false;
        }

        printf(
            '<style type="text/css">
            h1 a{background:0 0!important;height:auto!important;width:100%%!important;text-indent:0!important}
            h1 a img{max-width:240px;width:auto}
            </style>
            <script type="text/javascript">
            window.onload = function(){
                var aTag = document.getElementById("login").getElementsByTagName("a")[0];
                aTag.innerHTML = \'<img src="%s" alt="%s">\';
                aTag.href = "%s";
                aTag.title = "Go to site";
            }
            </script>',
            trailingslashit(get_stylesheet_directory_uri()) . $this->config('admin_logo'),
            get_bloginfo('name'),
            home_url()
        );
    }

    public function flex_oembed_frame($output, $data, $url)
    {
        return '<div class="flex-video">' . $output . '</div>';
    }

    //
    protected function enable_theme_supports()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
    }

    protected function register_nav_menus()
    {
        register_nav_menus($this->config('menus') ?: []);
    }

    protected function register_thumbnail_sizes()
    {
        foreach ($this->config('thumbnail_sizes') ?: [] as $name => $sizes) {
            array_unshift($sizes, $name);
            call_user_func_array('add_image_size', $sizes);
        }
    }

    protected function register_post_types()
    {
        if (!$cpts = $this->config('custom_post_types') ?: []) {
            return false;
        }

        foreach ($this->config('custom_post_types') ?: [] as $slug => $props) {
            $labels = $this->generate_cpt_labels($props);
            $args = $this->merge_cpt_props($props, $labels);
            register_post_type($slug, $args);
        }
    }

    protected function register_taxonomies()
    {
        if (!$taxonomies = $this->config('custom_taxonomies') ?: []) {
            return false;
        }

        foreach ($taxonomies as $slug => $props) {
            if (!$post_types = $props['post_types']) {
                continue;
            }

            $labels = $this->generate_taxonomy_labels($props);
            $args = $this->merge_taxonomy_props($props, $labels);

            register_taxonomy($slug, $post_types, $args);
        }
    }

    protected function register_editor_styles()
    {
        if ($this->config('google_fonts')) {
            add_editor_style(str_replace(',', '%2C', $this->config('google_fonts')));
        }

        foreach ($this->config('editor_styles') ?: [] as $path) {
            add_editor_style(
                $this->is_external_url($path) ?
                    $path :
                    trailingslashit(get_template_directory_uri()) . $path . '?v=' . filemtime(trailingslashit(get_template_directory()) . $path)
            );
        }
    }

    public function register_frontend_scripts()
    {
        wp_deregister_script('jquery');

        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array());

        if ($this->config('google_fonts')) {
            wp_enqueue_style('google-fonts', $this->config('google_fonts'), [], false);
        }

        $this->enqueue_scripts(
            $this->config('frontend_scripts') ?: [],
            $this->config('frontend_styles') ?: []
        );
    }

    public function register_admin_scripts()
    {
        $this->enqueue_scripts(
            $this->config('admin_scripts') ?: [],
            $this->config('admin_styles') ?: []
        );
    }

    public function disable_theme_update($prepared_themes)
    {
        $prepared_themes[$this->config('theme_slug')]['hasUpdate'] = false;
        return $prepared_themes;
    }

    protected function inject_favicons()
    {
        if ($this->config('favicon') && file_exists(trailingslashit(get_stylesheet_directory()) . $this->config('favicon'))) {
            printf(
                '<link rel="shortcut icon" href="%s?v=%s">',
                trailingslashit(get_stylesheet_directory_uri()) . $this->config('favicon'),
                filemtime(trailingslashit(get_template_directory()) . $this->config('favicon'))
            );
        }

        if ($this->config('phone_icon') && file_exists(trailingslashit(get_stylesheet_directory()) . $this->config('phone_icon'))) {
            printf(
                '<link rel="apple-touch-icon" href="%s?v=%s">',
                trailingslashit(get_stylesheet_directory_uri()) . $this->config('phone_icon'),
                filemtime(trailingslashit(get_template_directory()) . $this->config('phone_icon'))
            );
        }
    }

    protected function ping_back_meta()
    {
        if (is_singular() && pings_open(get_queried_object())) {
            printf('<link rel="pingback" href="%s">', get_bloginfo('pingback_url'));
        }
    }

    public function typekit_tinymce_plugin($plugins)
    {
        $plugins['fs_typekit'] = get_stylesheet_directory_uri() . '/scripts/tinymce.fs_typekit.js';
        return $plugins;
    }

    public function typekit_tinymce_config($mceInit)
    {
        $mceInit['fs_typekit_id'] = $this->config('typekit_id');
        return $mceInit;
    }

    public function add_typekit_script()
    {
        printf('<script src="https://use.typekit.net/%s.js"></script><script>try{Typekit.load({async: true});}catch(e){}</script>', $this->config('typekit_id'));
    }

    protected function generate_cpt_labels($props)
    {
        $singular = $props['singular'];
        $plural = $props['plural'];

        return [
            'name' => __($plural, $this->config('theme_slug')),
            'singular_name' => __($singular, $this->config('theme_slug')),
            'add_new' => __('Add New', $this->config('theme_slug')),
            'add_new_item' => __('Add New ' . $singular, $this->config('theme_slug')),
            'edit_item' => __('Edit ' . $singular, $this->config('theme_slug')),
            'new_item' => __('New ' . $singular, $this->config('theme_slug')),
            'view_item' => __('View ' . $singular, $this->config('theme_slug')),
            'search_items' => __('Search ' . $singular, $this->config('theme_slug')),
            'not_found' => __('Nothing found in the Database.', $this->config('theme_slug')),
            'not_found_in_trash' => __('Nothing found in Trash', $this->config('theme_slug')),
            'parent_item_colon' => __('Parent ' . $singular . ':', $this->config('theme_slug')),

            'all_items' => __('All ' . $plural, $this->config('theme_slug')),
            'archives' => __($singular . ' Archives', $this->config('theme_slug')),
            'insert_into_item' => __('Insert into ' . $singular, $this->config('theme_slug')),
            'uploaded_to_this_item' => __('Uploaded to this ' . $singular, $this->config('theme_slug')),

            'filter_items_list' => __('Filter ' . $plural . ' list', $this->config('theme_slug')),
            'items_list_navigation' => __($plural . ' list navigation', $this->config('theme_slug')),
            'items_list' => __($plural . ' list', $this->config('theme_slug')),
        ];
    }

    protected function merge_cpt_props($props, $labels)
    {
        return wp_parse_args($props, [
            'labels' => $labels,
            'public' => true,
            'menu_position' => 46,
            'supports' => ['title', 'editor', 'thumbnail', 'revisions', 'excerpt'],
            'rewrite' => [
                'slug' => $props['url_slug'] ?: '',
                'with_front' => false
            ],
        ]);
    }

    protected function generate_taxonomy_labels($props)
    {
        $singular = $props['singular'];
        $plural = $props['plural'];

        return [
            'name' => __($plural, $this->config('theme_slug')),
            'singular_name' => __($singular, $this->config('theme_slug')),
            'search_items' => __('Search ' . $plural, $this->config('theme_slug')),
            'popular_items' => __('Popular ' . $plural, $this->config('theme_slug')),
            'all_items' => __('All ' . $plural, $this->config('theme_slug')),
            'parent_item' => __('Parent ' . $singular, $this->config('theme_slug')),
            'parent_item_colon' => __('Parent ' . $singular . ':', $this->config('theme_slug')),
            'edit_item' => __('Edit ' . $singular, $this->config('theme_slug')),
            'view_item' => __('View ' . $singular, $this->config('theme_slug')),
            'update_item' => __('Update ' . $singular, $this->config('theme_slug')),
            'add_new_item' => __('Add New ' . $singular, $this->config('theme_slug')),
            'new_item_name' => __('New ' . $singular . ' Name', $this->config('theme_slug')),

            'separate_items_with_commas' => __('Separate ' . $plural . ' with commas', $this->config('theme_slug')),
            'add_or_remove_items' => __('Add or remove ' . $plural, $this->config('theme_slug')),
            'choose_from_most_used' => __('Choose from the most used ' . $plural, $this->config('theme_slug')),
            'not_found' => __('No ' . $plural . ' found.', $this->config('theme_slug')),
            'no_terms' => __('No ' . $plural, $this->config('theme_slug')),
            'items_list_navigation' => __($plural . ' list navigation', $this->config('theme_slug')),
            'items_list' => __($plural . ' list', $this->config('theme_slug')),
        ];
    }

    protected function merge_taxonomy_props($props, $labels)
    {
        return wp_parse_args($props, [
            'labels' => $labels,
            'show_admin_column' => true,
            'hierarchical' => true,
            'rewrite' => [
                'slug' => $props['url_slug'],
                'with_front' => false
            ],
        ]);
    }

    protected function enqueue_scripts($javascripts, $stylessheets)
    {
        if ($javascripts) {
            foreach ($javascripts as $name => $path) {
                $isExternal = $this->is_external_url($path);

                wp_enqueue_script(
                    $name,
                    $isExternal ? $path : trailingslashit(get_stylesheet_directory_uri()) . $path,
                    [],
                    $isExternal ? false : filemtime(trailingslashit(get_template_directory()) . $path),
                    true
                );
            }
        }

        if ($stylessheets) {
            foreach ($stylessheets as $name => $path) {
                $isExternal = $this->is_external_url($path);

                wp_enqueue_style(
                    $name,
                    $isExternal ? $path : trailingslashit(get_stylesheet_directory_uri()) . $path,
                    [],
                    $isExternal ? false : filemtime(trailingslashit(get_template_directory()) . $path)
                );
            }
        }
    }

    protected function is_external_url($src)
    {
        return strpos($src, '//') === 0 || strpos($src, 'http') === 0;
    }

    public function tinymce_add_style_dropdown($buttons)
    {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    public function mce_before_init_insert_styles($init_array)
    {
        $init_array['style_formats'] = json_encode($this->config('tinymce_additional_styles'));
        return $init_array;
    }

    public function tinymce_add_remove_forecolor($buttons)
    {
        $flipped = array_flip($buttons);

        if (array_key_exists('forecolor', $flipped)) {
            unset($flipped['forecolor']);
        }

        return array_flip($flipped);
    }

    public function tinymce_add_forecolor($buttons)
    {
        array_unshift($buttons, 'forecolor');

        return $buttons;
    }

    public function mce_before_init_custom_colors($init_array)
    {
        $init_array['textcolor_map'] = json_encode($this->config('tinymce_text_colors'));

        return $init_array;
    }

    public function load_chisel_libraries()
    {
        if ($this->config('enable_acf_banner_manager')) {
            ForgeBanner::instance()
                ->setAutoGenerate($this->config('acf_banner_manager_setting')['auto_import_default_banner_field_group'])
                ->setOptionPageName($this->config('acf_banner_manager_setting')['acf_option_page_name']);
        }

        if ($this->config('enable_menu_active_state_control')) {
            new CptMenuActiveControl\CptMenuActiveControl;
        }

        if ($this->config('enable_responsive_background_control')) {
            require_once get_stylesheet_directory() . '/anvil/core/libs/wp-background-helper/vendor/autoload.php';
            $wpBgHelper = wp_bg_helper_class();

            $wpBgHelper::setScreenMaxWidth($this->config('responsive_background_setting')['max_screen_size']);
            $wpBgHelper::setThumbnailMaxSize($this->config('responsive_background_setting')['max_thumbnail_size']);
            $wpBgHelper::setBreakpointShorthands($this->config('responsive_background_setting')['breakpoints']);
            $wpBgHelper::setBreakpointPresets($this->config('responsive_background_setting')['preset']);
        }
    }
}
