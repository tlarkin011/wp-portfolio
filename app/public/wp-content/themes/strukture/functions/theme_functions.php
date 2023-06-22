<?php
/*
 |----------------------------------------------------------------
 |  Site Logo
 |----------------------------------------------------------------
 */

 function stk_format_html_id($string) {
    $string = str_replace(' ', '-', $string);
    $string = strtolower($string);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}   


function anvil_site_logo($class = 'site-logo')
{
    printf(
        '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s" class="%4$s" /></a>',
        home_url(),
        esc_attr(get_bloginfo('name')),
        trailingslashit(get_stylesheet_directory_uri()) . Anvil::instance()->config('site_logo'),
        $class
    );
}

function anvil_footer_logo($class = 'site-logo')
{
    printf(
        '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s" class="%4$s" /></a>',
        home_url(),
        esc_attr(get_bloginfo('name')),
        trailingslashit(get_stylesheet_directory_uri()) . Anvil::instance()->config('footer_logo'),
        $class
    );
}


/*
 |----------------------------------------------------------------
 |  Button Base HTML Structure
 |----------------------------------------------------------------
 */
function anvil_button($button_text, $button_link, $additional_class = 'default', $additional_attrs = '')
{
    if (is_array($additional_class)) {
        $additional_class = implode(' ', array_map('trim', $additional_class));
    }

    $attrs = '';

    foreach (wp_parse_args($additional_attrs) as $attr => $value) {
        $attrs .= sprintf('%s="%s" ', $attr, esc_attr($value));
    }

    return sprintf(
        '<a href="%s" class="button %s" %s>%s</a>',
        esc_url($button_link),
        $additional_class,
        $attrs,
        $button_text
    );
}

/*
 |----------------------------------------------------------------
 |  Button Base HTML Structure
 |----------------------------------------------------------------
 */
// add_filter('gform_submit_button', 'form_submit_button', 10, 2 );
function form_submit_button($button, $form)
{
    return "<button class='button gf_submit default' id='gform_submit_button_{$form['id']}'>{$form['button']['text']}</button>";
}

/*
 |----------------------------------------------------------------
 |  Background Helpers
 |----------------------------------------------------------------
 */
function forge_bg($attachmentId = null, $preset = null, $pseudo = '')
{
    if (is_null($attachmentId)) {
        $attachmentId = get_post_thumbnail_id(get_the_ID());
    }

    wp_bg_helper($attachmentId, $preset, $pseudo);
}

add_action('wp_footer', 'forge_bg_styles', 50);
function forge_bg_styles()
{
    wp_bg_helper_print_styles(true);
}

/*
 |--------------------------------------------------------------------------
 | Post Helper
 |--------------------------------------------------------------------------
*/
function forge_title_link($post = null)
{
    echo forge_get_title_link($post);
}

function forge_get_title_link($post = null)
{
    return sprintf(
        '<a href="%s" title="%s">%s</a>',
        get_permalink($post),
        the_title_attribute(['post' => $post, 'echo' => false]),
        get_the_title($post)
    );
}

function forge_thumbnail_link($size = 'medium_large', $post = null)
{
    echo forge_get_thumbnail_link($size, $post);
}

function forge_get_thumbnail_link($size = 'medium_large', $post = null)
{
    if (!has_post_thumbnail($post)) return '';

    return sprintf(
        '<a href="%s" title="%s">%s</a>',
        get_permalink($post),
        the_title_attribute(['post' => $post, 'echo' => false]),
        get_the_post_thumbnail($post, $size)
    );
}

/*
 |--------------------------------------------------------------------------
 | Terms Helper
 |--------------------------------------------------------------------------
*/
function forge_get_terms($taxonomy, $args = [])
{
    $taxonomy = get_taxonomy($taxonomy);

    $args = wp_parse_args($args, [
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => [
            'relation' => 'OR',
            [
                'key' => $taxonomy->object_type[0] . '_order',
                'compare' => 'NOT EXISTS'
            ],
            [
                'key' => $taxonomy->object_type[0] . '_order',
                'value' => 0,
                'compare' => '>='
            ]
        ]
    ]);

    return get_terms($taxonomy->name, $args) ?: [];
}

function forge_get_the_terms($taxonomy, $args = [])
{
    return forge_get_terms($taxonomy, wp_parse_args($args, [
        'object_ids' => get_the_ID()
    ]));
}

function forge_the_primary_term($taxonomy, $post_id = null, $args = [])
{
    if (!$post_id) $post_id = get_the_ID();

    if (class_exists('WPSEO_Primary_Term')) {
        $wpseo_primary_term = new WPSEO_Primary_Term($taxonomy, $post_id);
        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();

        if ($wpseo_primary_term && $term = get_term($wpseo_primary_term)) {
            return $term;
        }
    }

    $terms = forge_get_the_terms($taxonomy, $post_id) ?: [];

    return $terms ? array_shift($terms) : false;
}

function forge_term_link($term)
{
    echo forge_get_term_link($term);
}

function forge_get_term_link($term)
{
    return sprintf('<a href="%s">%s</a>', get_term_link($term), $term->name);
}

/*
 |----------------------------------------------------------------
 |  ACF Components styles / Will help with usability - STK
 |----------------------------------------------------------------
 */

add_action('admin_head', 'acf_component_header_styles');

function acf_component_header_styles()
{
    echo '<style>
        #normal-sortables > .acf-postbox > .acf-fields > .acf-field.acf-field-component-field {border-top: #ccc solid 3px; !important}
        #normal-sortables > .acf-postbox > .acf-fields > .acf-field.acf-field-component-field > .acf-label > label { font-size: 20px; }
    </style>';
}


/*
 |----------------------------------------------------------------
 |  Update ACF-Json Folder Location - STK
 |----------------------------------------------------------------
 */

//add_filter('acf/settings/save_json', 'stk_update_acf_json_save_point');
//add_filter('acf/settings/load_json', 'stk_set_acf_json_load_point');

function stk_set_acf_json_load_point($paths)
{

    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/stk/lib/acf';
    // return
    return $paths;

}

function stk_update_acf_json_save_point($path)
{

    // update path
    $path = get_stylesheet_directory() . '/stk/lib/acf';
    // return
    return $path;

}


/*
|----------------------------------------------------------------
|  Auto Sync ACF Fields - STK
|----------------------------------------------------------------
*/

//add_action( 'admin_init', 'stk_sync_acf_fields' );
function stk_sync_acf_fields()
{
    if (class_exists('acf')) {
        if (class_exists('acf_field_component_field')) {
            // vars
            $groups = acf_get_field_groups();
            $sync = array();
            // bail early if no field groups
            if (empty($groups))
                return;
            // find JSON field groups which have not yet been imported
            foreach ($groups as $group) {

                // vars
                $local = acf_maybe_get($group, 'local', false);
                $modified = acf_maybe_get($group, 'modified', 0);
                $private = acf_maybe_get($group, 'private', false);
                // ignore DB / PHP / private field groups
                if ($local !== 'json' || $private) {

                    // do nothing

                } elseif (!$group['ID']) {

                    $sync[$group['key']] = $group;

                } elseif ($modified && $modified > get_post_modified_time('U', true, $group['ID'], true)) {

                    $sync[$group['key']] = $group;
                }
            }
            // bail if no sync needed
            if (empty($sync))
                return;
            if (!empty($sync)) { //if( ! empty( $keys ) ) {

                // vars
                $new_ids = array();

                foreach ($sync as $key => $v) { //foreach( $keys as $key ) {

                    // append fields
                    if (acf_have_local_fields($key)) {

                        $sync[$key]['fields'] = acf_get_local_fields($key);

                    }
                    // import
                    $field_group = acf_import_field_group($sync[$key]);
                }
            }
        }
    }
}

/*
|----------------------------------------------------------------
|  Get field group / Check if options field - STK
|----------------------------------------------------------------
*/

function stk_get_field($field_name, $option = false, $acf_id = null)
{
    if ($option == true) {
        $contents = get_field($field_name, 'options');
    } elseif ($acf_id) {
        $contents = get_field($field_name, $acf_id);
    } else {
        $contents = get_field($field_name);
    }
    return $contents;
}

function stk_get_sub_field($field_name, $option = false, $acf_id = null)
{
    if ($option == true) {
        $contents = get_sub_field($field_name, 'options');
    } elseif ($acf_id) {
        $contents = get_sub_field($field_name, $acf_id);
    } else {
        $contents = get_sub_field($field_name);
    }
    return $contents;
}

/*
|----------------------------------------------------------------
|  ADD POST-TYPE TO GET_TERMS()
|----------------------------------------------------------------
*/


/**
 * my_terms_clauses
 *
 * filter the terms clauses
 *
 * @param $clauses array
 * @param $taxonomy string
 * @param $args array
 * @return array
 * @link http://wordpress.stackexchange.com/a/183200/45728
 **/
function stk_add_post_type_to_get_terms($clauses, $taxonomy, $args)
{
    global $wpdb;
    if (isset($args['post_types'])) {
        $post_types = $args['post_types'];
        // allow for arrays
        if (is_array($args['post_types'])) {
            $post_types = implode("','", $args['post_types']);
        }
        $clauses['join'] .= " INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id";
        $clauses['where'] .= " AND p.post_type IN ('" . esc_sql($post_types) . "') GROUP BY t.term_id";
    }
    return $clauses;
}

add_filter('terms_clauses', 'stk_add_post_type_to_get_terms', 99999, 3);


function my_acf_init()
{

    acf_update_setting('google_api_key', get_field('google_maps_key', 'option'));
}


add_action('acf/init', 'my_acf_init');


/**
 * stk_construct_table_rows_array
 *
 * construct an array of table rows to display comparison table
 *
 * @param $acf_field string
 * @param $posts array of WP_Posts
 *
 * @return array
 **/
function stk_construct_table_rows_array($acf_field, $posts)
{
    $flex_layout = get_field($acf_field);
    $layout_name = $flex_layout[0]['acf_fc_layout'];
    $table_rows = [];
    // Set up our return array with the keys in the layout, skipping the layout name
    // this is first so there is an array of keys to loop over to get the labels
    // set up a data array that we will push the post data to
    foreach ($flex_layout[0] as $key => $value) {
        if ($value === $layout_name) {
            continue;
        }
        $table_rows[$key]['data'] = [];
    }
    // A bit of a convoluted loop to get the label for each row
    // this uses the acf subfield label and to get the labels we need the subfield object which we only have access to in a while(have_rows) loop
    if (have_rows($acf_field)) {
        while (have_rows($acf_field)) {
            the_row();

            foreach ($table_rows as $key => $value) {
                $sub_obj = get_sub_field_object($key);
                $table_rows[$key]['label'] = $sub_obj['label'];
            }
        }
    }
    foreach ($posts as $p) {
        $comparison_table = get_field('comparison_table', $p->ID);

        foreach ($comparison_table[0] as $key => $value) {
            if ($value === $layout_name) {
                continue;
            }
            array_push($table_rows[$key]['data'], $value);
        }

    }

    return $table_rows;
}

/**
 * stk_acf_array_has_fields
 *
 * Checks whether an acf content component
 * contains any values other than default ones
 *
 * @param array
 *
 * @return boolean
 **/

function stk_acf_array_has_fields($acf_array = []) {
    foreach ($acf_array as $key => $value) {
        if ($value != ''
            && $value != false
            && $key !== 'callout_component_content_columns'
            && $key !== 'callout_component_align_column') {
            return true;
        }
    }
    return false;
}

/*
|----------------------------------------------------------------
|  BREADCRUMBS
|----------------------------------------------------------------
*/

// Breadcrumbs
function custom_breadcrumbs()
{

    // Settings
    $separator = '&gt;';
    $breadcrums_id = 'breadcrumbs';
    $breadcrums_class = 'breadcrumbs';
    $home_title = 'Homepage';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy = 'product_cat';

    // Get the query & post information
    global $post, $wp_query;

    // Do not display on the homepage
    if (!is_front_page()) {

        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if (is_single()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if (!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">' . $parents . '</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                $cat_id = $taxonomy_terms[0]->term_id;
                $cat_nicename = $taxonomy_terms[0]->slug;
                $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if (!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

                // Else if post is in a custom taxonomy
            } else if (!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if (is_category()) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if (is_page()) {

            // Standard page
            if ($post->post_parent) {

                // If child page, get parents
                $anc = get_post_ancestors($post->ID);

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if (!isset($parents)) $parents = null;
                foreach ($anc as $ancestor) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if (is_tag()) {

            // Tag page

            // Get tag information
            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms($taxonomy, $args);
            $get_term_id = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif (is_day()) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if (is_month()) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if (is_year()) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if (is_author()) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata($author);

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if (get_query_var('paged')) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">' . __('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if (is_search()) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif (is_404()) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }

}


/*
|----------------------------------------------------------------
| Taxononomy Relationship
|----------------------------------------------------------------
*/

// this function work to create a taxonomy dynamically in a context where a certain post type needs to relate to another post type as taxonomy terms
//Example:  A site has the post types Services and Case studies. The Case studies need to tagged and then filtered with certain services. To make this dynamic, we want
// to create a service taxonomy that applies to the case studies, and have a term dynamically created for each of the services, every time a service is made

//suggested use: create a theme specific function to call this, and then use in the "admin menu" hook, so this will fire on every backend action

//Example:


// add_action('admin_menu', 'theme_name_create_services_for_case_studies');

// function theme_name_create_services_for_case_studies() {
//     stk_taxonomy_relationship('service', 'case-study-service');
// }

//in this case, the taxonomy name for case studies that we will use to filter is called "case-study-service"
//every time a Service post type is created, the same term would be generated to the case-study-service taxonomy, which the user could then tag any case studies with that term without having to go through the tedium of recreating

//note: the taxonomy itself has to be created, this only generates terms

function stk_taxonomy_relationship($post_type, $post_term)
{

    $post_types = get_posts(array(
            'numberposts' => -1,
            'post_type' => $post_type
        )
    );

    $post_terms = array(
        'taxonomy' => $post_term,
        'hide_empty' => false
    );

    $terms = get_terms($post_terms);
    $term_slugs = [];
    $post_type_slugs = [];

    foreach ($terms as $term) {
        $term_slugs[] = $term->slug;
    }


    foreach ($post_types as $type) {

        $post_type_slugs[] = $type->post_name;

        if (!in_array($type->post_name, $term_slugs)) {
            wp_insert_term($type->post_title, $post_term, $args);
        }
    }


    foreach ($term_slugs as $slug) {


        if (!in_array($slug, $post_type_slugs)) {

            $term = get_term_by('slug', $slug, $post_term);

            if ($term) {
                wp_delete_term($term->term_id, $post_term);
            }

        }
    }

}
