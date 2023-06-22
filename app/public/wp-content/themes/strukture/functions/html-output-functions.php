<?php
/*
|----------------------------------------------------------------
|  HTML Output Helpers
|----------------------------------------------------------------
*/
function stk_construct_taxonomy_select_field($taxonomy, $selected = [], $post_type = null, $placeholder = null) {

    $categories = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false, 'post_types' => $post_type] );
    $tax_obj = get_taxonomy($taxonomy);
    $placeholder = $placeholder ?? $tax_obj->labels->singular_name;

    $select = "<select data-filter-key='$taxonomy' class='taxonomy-select' data-taxonomy=$taxonomy name='$taxonomy' id='$taxonomy'>";
    $select .= '<option value="" selected>' . $placeholder . '</option>';
    foreach($categories as $category){

        if($category->count > 0){
            $select.= "<option data-filter-key=" . $taxonomy;
            if (in_array($category->slug, $selected)) {
                $select .= " selected='selected' ";
            }
            $select.= "data-filter-value='".$category->slug."' value='".$category->slug."'>".$category->name."</option>";
        }
    }

    $select.= "</select>";

    return $select;
}


function stk_construct_button_html($button, $one = "", $two = "")
{
    $button_url = ($button["button_link_type"] === 'file') ? $button['button_file'] : $button['button_link']['url'];
    $is_button_target_blank = ($button["button_link_type"] === 'file' || $button["button_link"]["target"] === '_blank');
    $button_target = ($is_button_target_blank) ? 'target="_blank" rel="noopener noreferrer"' : '';
    $button_logo = $button['add_button_logo'] ? $button['button_logo'] : '';

    $style = $button['button_style'];

    if ($style == "one") {
        $html_output = '<a role="button" style="background-color:' . $one .      '" class="button ' . $button['button_style'] . '" ';
    } elseif ($style == "two") {
        $html_output = '<a role="button" style="background-color:' . $two .      '" class="button ' . $button['button_style'] . '" ';
    } elseif ($style == "read-more") {
        $html_output = '<a role="button" class="button ' . $button['button_style'] . '" ';
    } else {
          $html_output = '<a role="button" class="button ' . $button['button_style'] . '" ';
    }

    $html_output .= 'href="' . $button_url . '" ';
    $html_output .= $button_target . '>';
    $html_output .= $button['button_text'];
    $html_output .= $button_logo . '</a>';

    return $html_output;

}

function stk_format_string_to_html_id_or_class($string)
{
    $string = str_replace(' ', '-', $string);
    $string = strtolower($string);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function stk_format_terms($terms = [])
{
    if (!$terms) {
        return '';
    }
    $html_output = '<div class="terms-container">';
    foreach ($terms as $term) {
        $html_output .= '<h6 class="subtitle">' . $term->name . '</h6>';
    }
    $html_output .= '</div>';
    return $html_output;
}


function stk_get_hierarchical_terms_array($taxonomy)
{
    global $post;
    $output = [];
    $terms = wp_get_post_terms($post->ID, $taxonomy);
    foreach ($terms as $term) {
        if ($term->parent == 0) // this gets the parent of the current post taxonomy
        {
            $myparent = $term;
        }
    }
    array_push($output, $myparent);

    foreach ($terms as $term) {
        if ($term->parent != 0) // this ignores the parent of the current post taxonomy
        {
            $child_term = $term; // this gets the children of the current post taxonomy
            array_push($output, $child_term);
        }
    }
    return $output;
}

function stk_display_taxonomy_terms_hierarchical($taxonomy = '')
{
    $terms = stk_get_hierarchical_terms_array($taxonomy);
    $output = [];
    if ($terms[0] !== NULL) {
        foreach ($terms as $term) {
            $item = '<h5 class="location">' . $term->name . '</h5>';
            array_push($output, $item);
        }
        $output = array_reverse($output);
        array_unshift($output, '<div class="terms-container">');
        array_push($output, '</div>');
    }


    return implode('', $output);
}

/*
|----------------------------------------------------------------
|  FILTER HELPER
|----------------------------------------------------------------
*/
/**
 * Helper for stk_construct_taxonomy_select_field()
 * Constructs an array from $_get in order to maintain select fields after page reload
 * @param $key string
 * @return array
 **/

function stk_construct_array_from_get_values($key) {
    $array = [];
    if (array_key_exists($key, $_GET)) {
        $_get_values = filter_var($_GET[$key], FILTER_SANITIZE_STRING);
        if ($_get_values) {
            $array = explode("|", $_get_values);
        }
    }
    return $array;
}
