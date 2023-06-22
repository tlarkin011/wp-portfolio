<?php

function wp_bg_helper_class() {
    return 'Gummiforweb\WpBackgroundHelper\WpBackgroundHelper';
}

function wp_bg_helper($attachmentId, $preset = null, $selector = null) {
    global $wp_bg_helper_cache;

    $backgroundInfo = wp_bg_helper_styles($attachmentId, $preset, $selector, false);
    $wp_bg_helper_cache[$backgroundInfo['uniqid']] = $backgroundInfo['styles'];

    if (preg_match('/^bg-.+/', $backgroundInfo['uniqid'])) {
        echo "data-bg=\"{$backgroundInfo['uniqid']}\"";
    }
}

function wp_bg_helper_print_styles($styleTag = true) {
    global $wp_bg_helper_cache;

    $styles = implode("\n", $wp_bg_helper_cache? : []);

    if ($styleTag) {
        $styles = sprintf("<style type=\"text/css\">\n%s\n</style>", $styles);
    }

    echo $styles;
}

function wp_bg_helper_styles($attachmentId, $preset = null, $selector = null, $styleTag = false) {
    $pseudoPattern = '/:{1,2}(before|after)$/';
    $uniqid = uniqid();
    $pseudo = preg_match($pseudoPattern, $selector, $matches)? $matches[1] : '';

    if (! $selector = preg_replace($pseudoPattern, '', $selector)) {
        $selector = sprintf('[data-bg="%s"]', $uniqid = uniqid('bg-'));
    }

    $class = wp_bg_helper_class();
    $helper = new $class($attachmentId, $preset);

    return [
        'uniqid' => $uniqid,
        'styles' => $helper->getStyles($pseudo? "{$selector}:{$pseudo}" : $selector, $styleTag)
    ];
}
