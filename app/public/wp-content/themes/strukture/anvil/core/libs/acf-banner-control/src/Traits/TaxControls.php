<?php

namespace AcfBannerControl\Traits;

trait TaxControls
{
    protected $globalControlledTaxs = [];
    protected $singleControlledTaxs = [];

    public function enableGlobalForTax($cpts, $append = true)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->globalControlledTaxs = $append?
            array_merge($this->globalControlledTaxs, $cpts) : $cpts;

        return $this;
    }

    public function disableGlobalForTax($cpts)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->globalControlledTaxs = array_diff($this->globalControlledTaxs, $cpts);

        return $this;
    }

    public function enableSingleForTax($cpts, $append = true)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->singleControlledTaxs = $append?
            array_merge($this->singleControlledTaxs, $cpts) : $cpts;

        return $this;
    }

    public function disableSingleForTax($cpts)
    {
        if (is_string($cpts)) {
            $cpts = [$cpts];
        }

        $this->singleControlledTaxs = array_diff($this->singleControlledTaxs, $cpts);

        return $this;
    }
}
