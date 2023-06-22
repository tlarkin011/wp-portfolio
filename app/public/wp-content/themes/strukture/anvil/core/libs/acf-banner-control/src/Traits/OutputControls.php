<?php

namespace AcfBannerControl\Traits;

trait OutputControls
{
    protected $bannerTitleField = 'banner_title';
    protected $bannerBackgroundField = 'banner_background';

    public static function get($field_name, $target = null)
    {
        return static::instance()->getFieldValue($field_name, $target);
    }

    public function getFieldValue($field_name, $target = null)
    {
        $value = '';
        $currentObject = get_queried_object();

        if ($target) {
            $value = get_field($field_name, $target);
        } else
        if (is_home()) {
            $value = get_field($field_name, get_option('page_for_posts'));
        } else
        if ($this->isTaxonomyArchive()) {
            if ($this->isTaxonomySingleControlled()) {
                $value = get_field($field_name, get_queried_object());
            }

            if (!$value && $this->isTaxonomyGlobalControlled()) {
                $value = get_field("{$currentObject->taxonomy}_{$field_name}", 'options');
            }
        } else
        if (is_page()) {
            $value = get_field($field_name);
        }
        if (is_singular()) {
            if ($this->isCptSingleControlled()) {
                $value = get_field($field_name, get_queried_object());
            }

            if (!$value && $this->isCptGlobalControlled()) {
                $value = get_field("{$currentObject->post_type}_{$field_name}", 'options');
            }
        } else
        if (is_404()) {
            $value = get_field("404_{$field_name}", 'options');
        }

        $value = apply_filters('AcfBannerControl::getFieldValue', $value, $field_name, $target, $this);
        $value = apply_filters("AcfBannerControl::getFieldValue({$field_name})", $value, $target, $this);

        // if $value returns array instead of id, find id within array and assign id to $value
        $can_foreach = is_array($value) || is_object($value);
        if ($can_foreach) {
            $value = $value['id'];
        }

        return $value;
    }

    public function getFieldCallable($field_name, $target = null)
    {
        if ($target && get_field($field_name, $target)) {
            return [$field_name, $target];
        }

        if (is_home() && get_field($field_name, get_option('page_for_posts'))) {
            return [$field_name, get_option('page_for_posts')];
        }

        if ($this->isTaxonomyArchive()) {
            if ($this->isTaxonomySingleControlled() && ($value = get_field($field_name, $currentObject))) {
                return [$field_name, $currentObject];
            }

            if ($this->isTaxonomyGlobalControlled() && get_field("{$currentObject->taxonomy}_{$field_name}", 'options')) {
                return ["{$currentObject->taxonomy}_{$field_name}", 'options'];
            }
        }

        if (is_page() && get_field($field_name)) {
            return [$field_name];
        }

        if (is_singular()) {
            if ($this->isCptSingleControlled() && get_field($field_name, get_queried_object())) {
                return [$field_name, get_queried_object()];
            }

            if ($this->isCptGlobalControlled() && get_field("{$currentObject->post_type}_{$field_name}", 'options')) {
                return ["{$currentObject->post_type}_{$field_name}", 'options'];
            }
        }

        if (is_404() && get_field("404_{$field_name}", 'options')) {
            return ["404_{$field_name}", 'options'];
        }

        return [];
    }

    protected function isTaxonomyArchive()
    {
        return is_category() || is_tag() || is_tax();
    }

    protected function isTaxonomyGlobalControlled()
    {
        return in_array(get_queried_object()->taxonomy, $this->globalControlledTaxs);
    }

    protected function isTaxonomySingleControlled()
    {
        return in_array(get_queried_object()->taxonomy, $this->singleControlledTaxs);
    }

    protected function isCptGlobalControlled()
    {
        return in_array(get_queried_object()->post_type, $this->globalControlledCpts);
    }

    protected function isCptSingleControlled()
    {
        return in_array(get_queried_object()->post_type, $this->singleControlledCpts);
    }
}
