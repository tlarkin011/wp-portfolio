<?php

namespace AcfBannerControl\Traits;

trait OutputFallback
{
    protected function bootOutputFallback()
    {
        add_filter("AcfBannerControl::getFieldValue({$this->bannerTitleField})", array($this, 'banner_title_fallback'), 10, 3);
        add_filter("AcfBannerControl::getFieldValue({$this->bannerBackgroundField})", array($this, 'banner_background_fallback'), 10, 3);

        add_filter("AcfBannerControl::getFieldValue({$this->bannerTitleField})", array($this, 'convert_banner_title_shorthand'), 10, 3);
    }

    public function banner_title_fallback($value, $target, $control)
    {
        if ($value) {
            return $value;
        }

        if ($control->isTaxonomyArchive()) {
            return get_queried_object()->name;
        }

        if (is_singular()) {
            return get_the_title(get_queried_object_id());
        }

        if (is_home()) {
            return get_the_title(get_option('page_for_posts'));
        }
    }

    public function banner_background_fallback($value, $target, $control)
    {
        return $value? : get_field("default_{$control->bannerBackgroundField}", 'options');
    }

    public function convert_banner_title_shorthand($value, $target, $control)
    {
        if ($control->isTaxonomyArchive()) {
            return str_replace('{term_name}', get_queried_object()->name, $value);
        }

        if (is_singular()) {
            return str_replace('{post_title}', get_queried_object()->post_title, $value);
        }

        return $value;
    }
}
