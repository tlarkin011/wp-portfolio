<?php

class ChiselAutoloader
{
    protected static $psr4 = [];

    protected static $prefixes = [];

    public static function addPrefixLoader($prefix, $dirPath, $fileFormat = 'class-%s.php')
    {
        static::$prefixes[$prefix] = [
            'dirPath' => trailingslashit($dirPath),
            'format' => $fileFormat
        ];
    }

    public static function addPsr4($psr4, $dirPath)
    {
        foreach ($psr4 as $namespace => $basePath) {
            static::$psr4[$namespace] = trailingslashit($dirPath) . trailingslashit($basePath);
        }
    }

    public static function autoload($className)
    {
        $filePath = '';

        if ($prefix = static::matchPrefix($className)) {
            $filePath = static::loadPrefixClass($className, $prefix);
        }

        if ($namespace = static::matchPsr4($className)) {
            $filePath = static::loadPsr4Class($className, $namespace);
        }

        if ($filePath && file_exists($filePath)) {
            require_once $filePath;
        }
    }

    protected static function matchPrefix($className)
    {
        foreach (static::$prefixes as $prefix => $directory) {
            if (strpos($className, $prefix) === 0) {
                return $prefix;
            }
        }

        return false;
    }

    protected static function matchPsr4($className)
    {
        foreach (static::$psr4 as $namespace => $location) {
            if (strpos($className, $namespace) === 0) {
                return $namespace;
            }
        }

        return false;
    }

    protected static function loadPrefixClass($className, $prefix)
    {
        $settings = static::$prefixes[$prefix];

        return $settings['dirPath'] . sprintf($settings['format'], $className);
    }

    protected static function loadPsr4Class($className, $namespace)
    {
        $filename = str_replace($namespace, '', $className);

        return sprintf('%s%s.php',
            static::$psr4[$namespace],
            str_replace('\\', DIRECTORY_SEPARATOR, $filename)
        );
    }
}
