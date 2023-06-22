<?php
require_once 'ChiselAutoloader.php';

ChiselAutoloader::addPrefixLoader('Forge', get_stylesheet_directory() . '/anvil', 'class-%s.php');

ChiselAutoloader::addPsr4([
    'AcfOutputHelper\\' => 'acf-output-helper/src',
    'AcfBannerControl\\' => 'acf-banner-control/src',
    'ResponsiveBackground\\' => 'responsive-background-helper/src',
    'CptMenuActiveControl\\' => 'cpt-menu-active-control/src',
    'WpQueryHelper\\' => 'wp-query-helper/src',
], dirname(__FILE__) . '/libs/');

spl_autoload_register('ChiselAutoloader::autoload');
