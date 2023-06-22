<?php

namespace Gummiforweb\WpBackgroundHelper;

class WpBackgroundUnit
{
    protected $imageId;
    protected $maxWidth;
    protected $breakpoints = [0 => 1];
    protected $imageSources = [];
    protected $results = [];

    public function setImage($image)
    {
        $this->imageId = $this->standarlizedImage($image);

        return $this;
    }

    public function getImage()
    {
        return $this->imageId;
    }

    public function maxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    public function addBreakpoint($screenWidth, $ratio = 1)
    {
        $screenWidth = $this->standardlizeScreenWidth($screenWidth);
        $ratio = $this->standardlizeImagePercentage($ratio);

        if ($this->isBreakpointValid($screenWidth, $ratio)) {
            $this->breakpoints[$screenWidth] = $ratio;
        }

        return $this;
    }

    public function removeBreakpoint($screenWidth)
    {
        $screenWidth = $this->standardlizeScreenWidth($screenWidth);

        if (isset($this->breakpoints[$screenWidth])) {
            unset($this->breakpoints[$screenWidth]);
        }

        return $this;
    }

    public function getBreakpoints()
    {
        return $this->breakpoints;
    }

    public function getBreakpoint($screenWidth)
    {
        return isset($this->breakpoints[$screenWidth])? $this->breakpoints[$screenWidth] : null;
    }

    public function addImageSource($screenWidth, $source)
    {
        if ($this->isImageSourceValid($source)) {
            $this->imageSources[$screenWidth] = $source;
        }

        return $this;
    }

    public function getImageSources()
    {
        return $this->imageSources;
    }

    public function getImageSource($screenWidth)
    {
        return isset($this->imageSources[$screenWidth])? $this->imageSources[$screenWidth] : null;
    }

    public function getResults($force = false)
    {
        if ($force || ! $this->results) {
            $this->prepareResults();
        }

        return $this->results;
    }

    public function prepareResults()
    {
        $this->maybeAddMaxWidth();

        ksort($this->breakpoints);
        krsort($this->imageSources);

        foreach ($this->breakpoints as $screen => $ratio) {
            $this->results[$screen] = $this->prepareImageSrc($screen, $ratio);
        }

        // filter "continuous" same results
        $check = '';
        foreach ($this->results as $screen => $source) {
            if ($check == $source) unset($this->results[$screen]);
            $check = $source;
        }

        $this->maybeRemoveMaxWidth();

        return $this;
    }

    protected function standarlizedImage($image)
    {
        if (is_numeric($image)) return $image;
        if (is_object($image) && isset($image->ID)) return $image->ID;
        if (is_array($image) && isset($image['ID'])) return $image['ID'];

        return null;
    }

    protected function standardlizeScreenWidth($screenWidth)
    {
        return preg_replace('/[^0-9]/', '', $screenWidth);
    }

    protected function standardlizeImagePercentage($ratio)
    {
        if (strpos($ratio, '%') !== false) {
            $ratio = 100 / str_replace('%', '', $ratio); // 50% => 2
        }

        if (! is_numeric($ratio)) {
            $ratio = 1;
        }

        if ($ratio > 0 && $ratio < 1) {
            $ratio = 1 / $ratio; // .5 => 2
        }

        return intval($ratio);
    }

    protected function isBreakpointValid($screenWidth, $ratio)
    {
        return $screenWidth && $ratio && is_int($ratio);
    }

    protected function isImageSourceValid($source)
    {
        return filter_var($source, FILTER_VALIDATE_URL);
    }

    protected function maybeAddMaxWidth()
    {
        if (! $this->maxWidth) return;
        if (! $this->isTrueMaxWidth()) return;

        $this->addBreakpoint($this->maxWidth);
    }

    protected function maybeRemoveMaxWidth()
    {
        if (! $this->maxWidth) return;
        if (! $this->isTrueMaxWidth()) return;

        unset($this->results[$this->maxWidth]);
    }

    protected function isTrueMaxWidth()
    {
        return ! array_filter(array_keys($this->breakpoints), function($breakpoint) {
            return $breakpoint > $this->maxWidth;
        });
    }

    protected function prepareImageSrc($breakpoint, $ratio)
    {
        $nextBreakpoint = $this->getNextBreakpoint($breakpoint);
        $requiredWidth = intval($nextBreakpoint / $ratio);
        $chosen = reset($this->imageSources);

        foreach ($this->imageSources as $size => $source) {
            if ($requiredWidth && $size < $requiredWidth) break;
            $chosen = $source;
            if (! $requiredWidth) break;
        }

        return $chosen;
    }

    protected function getNextBreakpoint($breakpoint)
    {
        $breakpoints = array_keys($this->breakpoints);
        $next = array_search($breakpoint, $breakpoints) + 1;

        return count($breakpoints) > $next? $breakpoints[$next] : 0;
    }
}
