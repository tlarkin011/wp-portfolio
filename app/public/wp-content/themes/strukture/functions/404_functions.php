<?php

if (function_exists('acf_add_options_page')) {
    acf_add_options_sub_page([
        'title'  => '404 Page',
        'parent' => 'edit.php?post_type=page',
    ]);
}

add_action('acf/init', 'maybe_create_forge_404_options');
function maybe_create_forge_404_options() {
    if (acf_get_field_group('group_forge404', true)) {
        return;
    }

    $imported = acf_import_field_group([
        'key' => 'group_forge404',
        'title' => '*Options: 404 Page',
        'fields' => [
            [
                'key' => 'field_404_page_content',
                'label' => '404 Page Content',
                'name' => '404_page_content',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ],
            [
                'key' => 'field_404_display_button',
                'label' => 'Display Back to Home Button',
                'name' => '404_display_back_to_home_button',
                'type' => 'true_false',
            ],
            [
                'key' => 'field_404_button_text',
                'label' => 'Back to Home Button Text',
                'name' => '404_back_to_home_button_text',
                'type' => 'text',
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-404-page',
                ]
            ]
        ]
    ]);

    update_field('field_404_page_content', 'It seems the page you are looking for has been lost!', 'options');
    update_field('field_404_display_button', true, 'options');
    update_field('field_404_button_text', 'Return Home', 'options');
}
