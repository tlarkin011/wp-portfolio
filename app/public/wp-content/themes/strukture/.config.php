<?php

return [
    /*
     |----------------------------------------------------------------
     |  Theme Related
     |----------------------------------------------------------------
     */
    'theme_slug' => 'anvil',

    /*
     |----------------------------------------------------------------
     |  Theme Assets
     |----------------------------------------------------------------
     */
    'site_logo' => 'images/hrs-color.png',
    'footer_logo' => 'images/hrs-reverse.png',
    'admin_logo' => 'images/logo.png',
    'favicon' => null, // 'images/favicon.png',
    'phone_icon' => null, //'images/phone-icon.png',
    'typekit_id' => null,

    /*
     |----------------------------------------------------------------
     |  Theme Menus
     |----------------------------------------------------------------
     */
    'menus' => [
        'utility' => 'Utility Menu',
        'primary' => 'Primary Menu',
        'footer' => 'Footer Menu',
        'services' => 'Services Menu',
        'learn' => 'Learn More Menu',
        'discover' => 'Discover Menu',
        'privacy' => 'Privacy Menu',
        'mobile-phone' => 'Mobile Phone Menu',
    ],

    /*
     |----------------------------------------------------------------
     |  Thumbnail Sizes
     |----------------------------------------------------------------
     | 'size-name' => ['width', 'height', 'crop']
     */
    'thumbnail_sizes' => [
        'fs-max' => [1800, null],
        'fs-full' => [1200, null],
        'fs-desktop' => [980, null],
        'team-member' => [300, 300, true],
        '4x-grid' => [250, 370, true],
        'mobile-team' => [610, 370, true]
        // 'hp-service' => [480, 320, true],
    ],

    /*
     |----------------------------------------------------------------
     |  Custom Post Types
     |----------------------------------------------------------------
     */

    'custom_post_types' => [
        'service' => [
            'singular' => 'Service',
            'plural' => 'Services',
            'url_slug' => 'our-services',
            'menu_icon' => 'dashicons-nametag',
        ],
        'team_member' => [
            'singular' => 'Team Member',
            'plural' => 'Team Members',
            'url_slug' => 'team-member',
            'menu_icon' => 'dashicons-groups',
            'exclude_from_search' => true,
        ],
        'case_study' => [
            'singular' => 'Case Study',
            'plural' => 'Case Studys',
            'url_slug' => 'case-study',
            'menu_icon' => 'dashicons-groups',
            'exclude_from_search' => true,
        ],

        'faq' => [
            'singular' => 'FAQ',
            'plural' => 'FAQs',
            'url_slug' => 'faq',
            'menu_icon' => 'dashicons-groups',
        ],
        'persona' => [
            'singular' => 'Persona',
            'plural' => 'Personas',
            'url_slug' => 'persona',
            'menu_icon' => 'dashicons-groups',
        ],
        'job' => [
	        'singular' => 'Job',
	        'plural' => 'Jobs',
	        'url_slug' => 'openings',
	        'menu_icon' => 'dashicons-id',
        ],

    ],

    /*
     |----------------------------------------------------------------
     |  Taxonomies
     |----------------------------------------------------------------
     */
    'custom_taxonomies' => [
        'service_type' => [
            'singular' => 'Service Type',
            'plural' => 'Service Types',
            'url_slug' => 'service-types',
            'post_types' => 'service',
        ],
        'faq_type' => [
            'singular' => 'FAQ Type',
            'plural' => 'FAQ Types',
            'url_slug' => 'faq-types',
            'post_types' => 'faq',
        ],
        'case_type' => [
            'singular' => 'Case Type',
            'plural' => 'Case Types',
            'url_slug' => 'case-types',
            'post_types' => 'case_study',
        ],
        'position_type' => [
	        'singular' => 'Position Type',
	        'plural' => 'Position Types',
	        'url_slug' => 'position-types',
	        'post_types' => 'job',
        ],
        'job_type' => [
	        'singular' => 'Job Type',
	        'plural' => 'Job Types',
	        'url_slug' => 'job-types',
	        'post_types' => 'job',
        ],
    ],

    /*
     |----------------------------------------------------------------
     |  Google Fonts
     |----------------------------------------------------------------
     */
    'google_fonts' => 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i',

    /*
 |----------------------------------------------------------------
 |  Frontend Scripts
 |----------------------------------------------------------------
 */

    'frontend_scripts' => [
        //'modernizr' => 'https://unpkg.com/modernizr@3.6.0/lib/cli.js',
        'fancybox' => 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.js',
        'slick' => 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
        'font-awesome-kit' => 'https://kit.fontawesome.com/50817bbbeb.js',
        // 'wow'          => 'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js',
        'theme-script' => 'scripts/site-js.js',
        'map-script' => 'scripts/maps.js',
    ],

    /*
     |----------------------------------------------------------------
     |  Frontend Styles
     |----------------------------------------------------------------
     */
    'frontend_styles' => [
        'fontawesome' => 'https://use.fontawesome.com/releases/v5.8.1/css/all.css',
        'fancybox' => 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.css',
        'slick' => 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
        'fonts' => 'https://use.typekit.net/lab4njx.css',
        // 'animate'     => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
        'theme-style' => 'styles/css/main-style.css',
    ],

    /*
     |----------------------------------------------------------------
     |  Admin Scripts
     |----------------------------------------------------------------
     */
    'admin_scripts' => [
        'theme-admin' => 'scripts/admin-js.js',
    ],

    /*
     |----------------------------------------------------------------
     |  Admin Styles
     |----------------------------------------------------------------
     */
    'admin_styles' => [
        'fontawesome' => 'https://use.fontawesome.com/releases/v5.7.1/css/all.css',
        'theme-admin' => 'styles/css/admin-style.css',
    ],

    /*
     |----------------------------------------------------------------
     |  Editor Styles
     |----------------------------------------------------------------
     */
    'editor_styles' => [
        'https://use.fontawesome.com/releases/v5.7.1/css/all.css',
        'styles/css/wysiwyg.css',
    ],

    /*
     |----------------------------------------------------------------
     |  ACF Option Pages
     |----------------------------------------------------------------
     */
    'acf_option_pages' => [
        'General',
        'Banner',
        'Header',
        'Footer',
    ],

    /*
     |----------------------------------------------------------------
     |  TinyMCE Additional Styles
     |----------------------------------------------------------------
     */
    'enable_tinymce_additional_styles' => true,
    'tinymce_additional_styles' => [
        [
            'title' => 'Intro Paragraph',
            'block' => 'p',
            'classes' => 'intro',
            'wrapper' => false,
        ],
    ],

    /*
     |----------------------------------------------------------------
     |  TinyMCE Text Color
     |----------------------------------------------------------------
     */
    'enable_tinymce_text_colors' => false,
    'tinymce_text_colors' => [
        '262626', 'Black',
        '2f9ba8', 'Blue',
    ],

    /*
     |----------------------------------------------------------------
     |  ACF Banner Manager
     |----------------------------------------------------------------
     */
    'enable_acf_banner_manager' => true,
    'acf_banner_manager_setting' => [
        'auto_import_default_banner_field_group' => true,
        'acf_option_page_name' => 'Banner'
    ],

    /*
     |----------------------------------------------------------------
     |  Menu Active State Helper
     |----------------------------------------------------------------
     */
    'enable_menu_active_state_control' => true,

    /*
     |--------------------------------------------------------------------------
     | Background Helper
     |--------------------------------------------------------------------------
    */
    'enable_responsive_background_control' => true,
    'responsive_background_setting' => [
        'max_screen_size' => 1800,
        'max_thumbnail_size' => 'fs-full',
        'breakpoints' => [
            'xs' => 480,
            'sm' => 640,
            'md' => 768,
            'lg' => 980,
            'xl' => 1200,
            'xxl' => 1400
        ],
        'preset' => [
            'db-full-width' => 'md:2+'
        ],
    ],

];
