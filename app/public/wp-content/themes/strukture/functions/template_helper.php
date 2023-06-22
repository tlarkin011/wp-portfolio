<?php

class TemplateHelper
{
    public static $currentScope;
    protected static $rootPath = 'templates/';

    protected $filePath = '';
    protected $data = [];
    protected $echo = true;

    public function __construct($file, $data = [], $echo = true)
    {
        $this->filePath = $this->parseFilePath($file);
        $this->data = $this->parseData($data);
        $this->echo = !! $echo;
    }

    public function __destruct()
    {
        if (! $this->echo) return;

        echo $this->output();
    }

    public static function setRootPath($path)
    {
        static::$rootPath = $path;
    }

    public function output()
    {
        if (! is_file($this->filePath)) return '';

        $oldScope = static::$currentScope;
        static::$currentScope = $this;

        ob_start();
        extract($this->data);

        include $this->filePath;

        static::$currentScope = $oldScope;
        return ob_get_clean();
    }

    public function getData($key, $default = null)
    {
        return isset($this->data[$key])? $this->data[$key] : $default;
    }

    public function toString()
    {

        return $this->output();

    }

    protected function parseFilePath($path)
    {
        $path = str_replace(['.php', '.'], ['', '/'], $path);

        if (strpos('/', $path) !== 0) {
            $path = static::$rootPath . "/{$path}.php";
        }

        return get_stylesheet_directory() . '/' . trim($path, '\\/');
    }

    protected function parseData($data)
    {
        return wp_parse_args($data, []);
    }
}

function forge_template($path, $data = [], $echo = true) {
    return new TemplateHelper($path, $data, $echo);
}

function forge_var($key, $default = null) {
    return TemplateHelper::$currentScope? TemplateHelper::$currentScope->getData($key, $default) : $default;
}
