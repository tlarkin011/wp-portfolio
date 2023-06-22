<?php

namespace AcfOutputHelper\Parsers;

/**
* Input Parser Class
*
* Class that Parse the input. Input will contain field_name
* and may contains shortkey or filters.
*
* @since       1.0.0
* @version     1.0.0
* @package     AcfOutputHelper
*/
class InputParser
{
    /**
     * Class name for parsing the filters
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string
     */
    protected static $FilterParser = '\AcfOutputHelper\Parsers\FilterParser';

    /**
     * Acf field name
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string
     */
    protected $field_name;

    /**
     * Acf field tartget reference
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         mix
     */
    protected $target;

    /**
     * If this field is sub field
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $isSub = false;

    /**
     * If this field is required
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $required = true;

    /**
     * If this field required a false-thy value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $negate = false;

    /**
     * Filters that need to be run after the value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         array
     */
    protected $filters = [];

    /**
     * Weither this field is valid or not
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         boolean
     */
    protected $valid;

    /**
     * The return value of this field
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         mix
     */
    protected $value;

    /**
     * The value after the filter
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         mix
     */
    protected $filteredValue;

    /**
     * Constructor
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $field_name Acf field name
     * @param       mix $target     Acf field target
     */
    public function __construct($field_name, $target = null)
    {
        $this->field_name = $field_name;
        $this->target = $target;

        $this->checkForShortKeys();
        $this->checkForFilters();
    }

    /**
     * Set a custom filter parser
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $parser class name
     */
    public static function SetFilterParser(string $parser)
    {
        if (class_exists($parser)) {
            static::$FilterParser = $parser;
        }
    }

    /**
     * Parse the shortkey out fomr field_name if found
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      void
     */
    protected function checkForShortKeys()
    {
        if ($this->containsShortKeys()) {
            preg_match('/^([\!\?\>\~]*)(.+)/', $this->field_name, $matches);
            $this->field_name = $matches[2];
            $this->setShortKeyFlags(str_split($matches[1]));
        }
    }

    /**
     * Check if field_name contains shortkeys
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    protected function containsShortKeys()
    {
        return $this->field_name && preg_match('/^([\!\?\>\~]*)/', $this->field_name);
    }

    /**
     * Set the flags based on the shortkey
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       array $shortKeys shortkeys array
     */
    protected function setShortKeyFlags($shortKeys)
    {
        $this->negate   = in_array('!', $shortKeys)? true : $this->negate;
        $this->required = in_array('?', $shortKeys)? false : $this->required;
        $this->isSub    = in_array('>', $shortKeys)? true : $this->isSub;

        if (in_array('~', $shortKeys)) {
            $this->target = 'options';
            $this->isSub = false;
        }
    }

    /**
     * Strips the filter out of field_name if found
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      void
     */
    protected function checkForFilters()
    {
        if ($this->inputContainsFilters()) {
            $splits = explode('|', $this->field_name);
            $this->field_name = array_shift($splits);

            $this->parseFilters($splits);
        }
    }

    /**
     * Check if the field_name contains filters
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    protected function inputContainsFilters()
    {
        return strpos($this->field_name, '|') !== false;
    }

    /**
     * Parse the filters and add to filter list if valid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       array $splits filter array
     * @return      void
     */
    protected function parseFilters($splits)
    {
        foreach ($splits as $split) {
            $filter = new static::$FilterParser($split);

            if ($filter->valid()) {
                $this->filters[] = $filter;
            }
        }
    }

    /**
     * Get the callable reference arguments (for call_user_func_array)
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      string|array
     */
    public function getCallable()
    {
        return $this->isSub? [$this->field_name] : [$this->field_name, $this->target];
    }

    /**
     * Get the field name
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      string
     */
    public function getName()
    {
        return $this->field_name;
    }

    /**
     * Get the filtered value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      mix
     */
    public function getValue()
    {
        if (is_null($this->value)) {
            $this->validate();
        }

        return $this->filteredValue;
    }

    /**
     * Get the value and validate the value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    public function validate()
    {
        $parsed = $this->parse();

        $this->value = call_user_func_array($parsed['function'], $parsed['arguments']);

        $this->runFilters();

        if ($parsed['required']) {
            return $this->valid = $parsed['negate']? ! $this->filteredValue : !! $this->filteredValue;
        }

        return $this->valid = true;
    }

    /**
     * Run the filters on the return value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      mix
     */
    protected function runFilters()
    {
        $this->filteredValue = $this->value;

        foreach ($this->filters as $filter) {
            $this->filteredValue = $filter->filter($this->filteredValue);
        }

        return $this;
    }

    /**
     * Get the parsed input object for future use
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      array
     */
    public function parse()
    {
        return [
            'function'  => $this->isSub? 'get_sub_field' : 'get_field',
            'arguments' => $this->getCallable(),
            'required'  => $this->required,
            'negate'    => $this->negate,
            'filters'   => $this->filters
        ];
    }
}
