<?php

use AcfOutputHelper\ChiselAcf;

class ForgeAcf extends ChiselAcf
{
    public static function button($field_name) {
        $buttons = get_field($field_name);
        if ($buttons) {
            foreach ($buttons as $button) {
                echo stk_construct_button_html($button);
            }
        }
    }

    public static function content_block($field_name, $class = '', $heading = 'h3', $acf_id = null)
    {
        if (is_string($field_name)) $field_name = array($field_name);

        if ($acf_id) array_push($field_name, $acf_id);

        echo sprintf('<article class="%s">', $class);
        while (call_user_func_array('have_rows', $field_name)): the_row();
            echo "<div class='text-container'>";
            if (get_sub_field('subtitle')) {
                echo sprintf('<h6 class="subtitle">%s</h6>', get_sub_field('subtitle'));
            }
            if (get_sub_field('heading')) {
                echo sprintf('<%s class="heading">%s</%s>', $heading, get_sub_field('heading'), $heading);
            }
            if (get_sub_field('text')) {
                echo sprintf('<p class="content">%s</p>', get_sub_field('text'));
            }
            echo "</div>";
            echo "<div class='cta-container'>";
            ForgeAcf::button('cta');
            echo "</div>";

        endwhile;
        echo '</article>';

    }

    public static function nested_content_block($content, $class="", $heading="h3")
    {
        echo sprintf('<article class="%s">', $class);
        echo "<div class='text-container'>";
        if ($content["subtitle"]) {
            echo sprintf('<h6 class="subtitle">%s</h6>', $content["subtitle"]);
        }
        if ($content["heading"]) {
            echo sprintf('<%s class="heading">%s</%s>', $heading, $content["heading"], $heading);
        }
        if ($content["text"]) {
            echo sprintf('<p class="content">%s</p>', $content["text"]);
        }
        echo "</div>";
        echo "<div class='cta-container'>";
        echo stk_construct_button_html($content["cta"][0]);
        echo "</div>";
        echo '</article>';

    }
}
