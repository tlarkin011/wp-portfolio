<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit17780d48806b3950b86dfc72a14d801f
{
    public static $files = array (
        'fba2c24b13f84970702dfe917a6c201a' => __DIR__ . '/../..' . '/src/helpers/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Gummiforweb\\WpBackgroundHelper\\' => 31,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Gummiforweb\\WpBackgroundHelper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Gummiforweb\\WpBackgroundHelper\\WpBackgroundHelper' => __DIR__ . '/../..' . '/src/WpBackgroundHelper.php',
        'Gummiforweb\\WpBackgroundHelper\\WpBackgroundUnit' => __DIR__ . '/../..' . '/src/WpBackgroundUnit.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit17780d48806b3950b86dfc72a14d801f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit17780d48806b3950b86dfc72a14d801f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit17780d48806b3950b86dfc72a14d801f::$classMap;

        }, null, ClassLoader::class);
    }
}
