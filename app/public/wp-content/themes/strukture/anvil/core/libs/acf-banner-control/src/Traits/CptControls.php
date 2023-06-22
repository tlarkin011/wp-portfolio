<?php

namespace AcfBannerControl\Traits;

trait CptControls
{
    protected $globalControlledCpts = [];
    protected $singleControlledCpts = [];

    public function enableGlobalForCpt($cpts, $append = true)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->globalControlledCpts = $append?
            array_merge($this->globalControlledCpts, $cpts) : $cpts;

        return $this;
    }

    public function disableGlobalForCpt($cpts)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->globalControlledCpts = array_diff($this->globalControlledCpts, $cpts);

        return $this;
    }

    public function enableSingleForCpt($cpts, $append = true)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->singleControlledCpts = $append?
            array_merge($this->singleControlledCpts, $cpts) : $cpts;

        return $this;
    }

    public function disableSingleForCpt($cpts)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->singleControlledCpts = array_diff($this->singleControlledCpts, $cpts);

        return $this;
    }
}
