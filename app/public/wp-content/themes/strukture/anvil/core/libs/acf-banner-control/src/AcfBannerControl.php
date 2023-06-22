<?php

namespace AcfBannerControl;

use AcfBannerControl\Traits\AdminControls;
use AcfBannerControl\Traits\CptControls;
use AcfBannerControl\Traits\OutputControls;
use AcfBannerControl\Traits\OutputFallback;
use AcfBannerControl\Traits\TaxControls;

class AcfBannerControl
{
    use CptControls, TaxControls, AdminControls, OutputControls, OutputFallback;

    protected static $instance;

    public static function instance()
    {
        if (! static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->bootTraits();
    }

    protected function bootTraits()
    {
        foreach (get_declared_traits() as $trait) {
            $shortName = (new \ReflectionClass($trait))->getShortName();

            if (method_exists($this, "boot{$shortName}")) {
                $this->{"boot{$shortName}"}();
            }
        }
    }
}
