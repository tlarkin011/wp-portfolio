<?php

namespace AcfOutputHelper\Parsers;

/**
* Filter Parser Class
*
* The main helper class that all mothods should be called on
*
* @since       1.0.0
* @version     1.0.0
* @package     AcfOutputHelper
*/
class FilterParser
{
    /**
     * Static Class filter methods should be search from
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string
     */
    protected static $StaticFilterClass;

    /**
     * If this filter is valid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $valid = false;

    /**
     * name of this filter
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string
     */
    protected $filter_name;

    /**
     * if this is a wp's filter
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $isWpFilter = false;

    /**
     * if this is a method on the filter class
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $isClassFilter = false;

    /**
     * additional arguments that get passed down to the filter
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         array
     */
    protected $arguments = [];

    /**
     * Constructor
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $filter filter string
     */
    public function __construct($filter)
    {
        $this->filter_name = $filter;

        $this->checkForShortKeys();
        $this->checkForArguments();
        $this->validateFilter();
    }

    /**
     * Set a statuc class which filter method may live in
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $className class name
     */
    public static function SetStaticFilterClass($className)
    {
        if (is_object($className) || class_exists((string) $className)) {
            static::$StaticFilterClass = $className;
        }
    }

    /**
     * Parse out the short keys if found
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      void
     */
    protected function checkForShortKeys()
    {
        if ($this->containsShortKeys()) {
            preg_match('/^([\^]*)(.+)/', $this->filter_name, $matches);
            $this->filter_name = $matches[2];
            $this->setShortKeyFlags(str_split($matches[1]));
        }
    }

    /**
     * Check if the filter string contians shortkey
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    protected function containsShortKeys()
    {
        return $this->filter_name && preg_match('/^([\^]*)/', $this->filter_name);
    }

    /**
     * Setup flags for short key
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       array $shortKeys found short key array
     */
    protected function setShortKeyFlags($shortKeys)
    {
        $this->isWpFilter = in_array('^', $shortKeys)? true : $this->isWpFilter;
    }

    /**
     * Parse the additional arguments if found
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      void
     */
    protected function checkForArguments()
    {
        if ($this->filterHasArguments()) {
            $splits = explode(':', $this->filter_name);
            $this->filter_name = array_shift($splits);

            $this->arguments = $this->parseArguments(array_shift($splits));
        }
    }

    /**
     * Check if filter name contains arguments
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    protected function filterHasArguments()
    {
        return strpos($this->filter_name, ':') !== false;
    }

    /**
     * Parse the arguments
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $argumentString argument string
     * @return      array
     */
    protected function parseArguments($argumentString)
    {
        return array_map(function($value) {
            return str_replace('\,', ',', $value);
        }, preg_split('/(?<!\\\\),/i', $argumentString));
    }

    /**
     * Checking if the filter is callable
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    protected function validateFilter()
    {
        if ($this->isWpFilter) {
            return $this->valid = has_filter($this->filter_name);
        }

        if (is_callable($this->filter_name)) {
            return $this->valid = true;
        }

        if (static::$StaticFilterClass && method_exists(static::$StaticFilterClass, $this->filter_name)) {
            $this->isClassFilter = true;
            return $this->valid = true;
        }
    }

    /**
     * Check if current filter is valid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * Run the filter with the given value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       mix $inputValue the valu to filter
     * @return      mix
     */
    public function filter($inputValue)
    {
        $parsed = $this->parse();

        $arguments = $parsed['arguments'];
        array_unshift($arguments, $inputValue);

        if ($parsed['wpfilter']) {
            array_unshift($arguments, $parsed['filter_name']);
            return call_user_func_array('apply_filters', $arguments);
        }

        return call_user_func_array(
            $parsed['classFilter']? [static::$StaticFilterClass, $parsed['filter_name']] : $parsed['filter_name'],
            $arguments
        );
    }

    /**
     * Get the parsed filter object for future use
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      array
     */
    public function parse()
    {
        return [
            'wpfilter'    => $this->isWpFilter,
            'classFilter' => $this->isClassFilter,
            'filter_name' => $this->filter_name,
            'arguments'   => $this->arguments
        ];
    }
}
