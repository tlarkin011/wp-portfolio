<?php

namespace Gummiforweb\WpBackgroundHelper;

use Gummiforweb\WpBackgroundHelper\WpBackgroundUnit;

class WpBackgroundHelper
{
    protected $attachmentId;
    protected $unit;
    protected static $screenMaxWidth;
    protected static $thumbnailMaxSize;
    protected static $breakpointPresets = [];
    protected static $breakpointShorthands = [];
    protected static $availableThumbnailSizes = [];

    public function __construct($attachmentId = null, $preset = null)
    {
        $this->unit = (new WpBackgroundUnit)
            ->setImage($attachmentId)
            ->maxWidth(static::$screenMaxWidth);

        $this->prepareAvailableThumbnailSizes();
        $this->initPreset($preset);
        $this->initImageSources();
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function initPreset($preset)
    {
        if (isset(static::$breakpointPresets[$preset])) {
            $preset = static::$breakpointPresets[$preset];
        }

        if (! $preset) {
            $firstBreakpoint = static::$breakpointShorthands? reset(static::$breakpointShorthands) : 320;
            $preset = "{$firstBreakpoint}:1+";
        }

        foreach ($this->standardlizePreset($preset) as $breakpoint => $ratio) {
            $this->unit->addBreakpoint($this->standardlizeScreenWidth($breakpoint), $ratio);
        }

        foreach (static::$breakpointShorthands as $shorthand => $width) {
            if ($width >= $this->unit->getMaxWidth()) {
                $this->unit->removeBreakpoint($this->standardlizeScreenWidth($shorthand));
                continue;
            }

            if (array_key_exists($width, $this->unit->getBreakpoints())) continue;

            $this->unit->addBreakpoint($this->standardlizeScreenWidth($shorthand), 1);
        }

        return $this;
    }

    public function initImageSources()
    {
        $this->addThumbnailSize(static::$thumbnailMaxSize? : 'full');

        foreach (static::$availableThumbnailSizes as $size) {
            $this->addThumbnailSize($size);
        }

        return $this;
    }

    public function addThumbnailSize($size)
    {
        if ($size == 'full' || in_array($size, static::$availableThumbnailSizes)) {
            if ($imageSrc = wp_get_attachment_image_src($this->unit->getImage(), $size)) {
                $this->unit->addImageSource($imageSrc[1], $imageSrc[0]);
            }
        }

        return $this;
    }

    public function getStylesArray($selector)
    {
        $styles = [];

        foreach ($this->unit->getResults() as $breakpoint => $source) {
            $style = sprintf('%s { background-image: url(\'%s\'); }', $selector, $source);

            if ($breakpoint) {
                $style = sprintf('@media screen and (min-width: %spx) { %s }', $breakpoint, $style);
            }

            $styles[] = $style;
        }

        return $styles;
    }

    public function getStyles($selector, $styleTag = false)
    {
        $styles = implode("\n", $this->getStylesArray($selector));

        if ($styleTag) {
            $styles = sprintf("<style type=\"text/css\">\n%s\n</style>", $styles);
        }

        return $styles;
    }

    public static function clearCache()
    {
        static::$screenMaxWidth = null;
        static::$thumbnailMaxSize = null;
        static::$breakpointPresets = [];
        static::$breakpointShorthands = [];
        static::$availableThumbnailSizes = [];
    }

    public static function clearAvailableThunbmailSizes()
    {
        static::$availableThumbnailSizes = [];
    }

    public static function setScreenMaxWidth($width)
    {
        static::$screenMaxWidth = $width;
    }

    public static function setThumbnailMaxSize($size)
    {
        static::$thumbnailMaxSize = $size;
    }

    public static function setBreakpointPresets($presets)
    {
        static::$breakpointPresets = $presets;
        // static::$breakpointPresets = [];

        // foreach ($presets as $name => $preset) {
        //     static::$breakpointPresets[$name] = static::standardlizePreset($preset);
        // }
    }

    public static function setBreakpointShorthands($shorthands)
    {
        static::$breakpointShorthands = $shorthands;
    }

    public static function getStatic($name)
    {
        return isset(static::$$name)? static::$$name : null;
    }

    protected static function aggressivePreset($breakpoint, $ratio, $formated)
    {
        $ratio = str_replace('+', '', $ratio);

        $started = false;
        foreach (array_keys(static::$breakpointShorthands) as $shorthand) {
            if ($shorthand == $breakpoint) $started = true;
            if ($started) $formated[$shorthand] = $ratio;
        }

        $started = false;
        foreach (array_values(static::$breakpointShorthands) as $width) {
            if ($width == $breakpoint) $started = true;
            if ($started) $formated[$width] = $ratio;
        }

        return $formated;
    }

    protected function prepareAvailableThumbnailSizes()
    {
        if (static::$availableThumbnailSizes) return;

        foreach ($this->getAllThumbnailSizes() as $name => $setting) {
            if ($setting['crop'] || $setting['height']) continue;
            static::$availableThumbnailSizes[] = $name;
        }
    }

    protected function getAllThumbnailSizes()
    {
        global $_wp_additional_image_sizes;

        $imageSizes = [];

        foreach (get_intermediate_image_sizes() as $size) {
            $imageSizes[$size] = [
                'width' => intval(get_option("{$size}_size_w")),
                'height' => intval(get_option("{$size}_size_h")),
                'crop' => get_option("{$size}_crop")
            ];
        }

        return array_merge($imageSizes, $_wp_additional_image_sizes? : []);
    }

    protected function standardlizePreset($preset)
    {
        if (is_array($preset)) return $preset;

        $formated = [];
        $segments = array_map('trim', explode(',', $preset));
        $segments = array_filter(explode(' ', implode(' ', $segments)));

        foreach ($segments as $segment) {
            $parts = array_map('trim', explode(':', $segment));

            if (count($parts) == 1) {
                $this->unit->maxWidth(str_replace('!', '', $parts[0]));
                continue;
            }

            list($breakpoint, $ratio) = $parts;

            if (preg_match('/\d+\+$/', $ratio)) {
                $formated = static::aggressivePreset($breakpoint, $ratio, $formated);
            } else {
                $formated[$breakpoint] = $ratio;
            }
        }

        return $formated;
    }

    protected function standardlizeScreenWidth($screenWidth)
    {
        if (array_key_exists($screenWidth, static::$breakpointShorthands)) {
            $screenWidth = static::$breakpointShorthands[$screenWidth];
        }

        return preg_replace('/[^0-9]/', '', $screenWidth);
    }
}
