<?php

use AcfBannerControl\AcfBannerControl;

class ForgeBanner extends AcfBannerControl
{
    //
}

/*
 |----------------------------------------------------------------
 |  Helper functions
 |----------------------------------------------------------------
 */
function forge_banner($field, $target = null) {
    return ForgeBanner::instance()->getFieldValue($field, $target);
}

function forge_banner_target($field, $target = null) {
    return ForgeBanner::instance()->getFieldCallable($field, $target);
}
