<?php

namespace AcfOutputHelper;

use AcfOutputHelper\Traits\AddFieldAliasHelper;
use AcfOutputHelper\Traits\CallbackOutputter;
use AcfOutputHelper\Traits\FlexContentOutputter;
use AcfOutputHelper\Traits\ImageOutputter;
use AcfOutputHelper\Traits\RelationshipOutputter;
use AcfOutputHelper\Traits\StringFormatOutputter;

/**
* Acf Output Helper Class
*
* The main helper class that all mothods should be called on
*
* @since       1.0.0
* @version     1.0.0
* @package     AcfOutputHelper
*/
class AcfOutputHelper
{
    use AddFieldAliasHelper,
        CallbackOutputter,
        FlexContentOutputter,
        ImageOutputter,
        RelationshipOutputter,
        StringFormatOutputter;

    /**
     * Input parser class
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string
     */
    protected static $InputParser = '\AcfOutputHelper\Parsers\InputParser';

    /**
     * Method alias array
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         array
     */
    protected $aliasMapping = [];

    /**
     * Fields that need to be operated
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         array
     */
    protected $fields = [];

    /**
     * Weither if this operation has been validated
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         null|boolean
     */
    protected $isValid = null;

    /**
     * Function to call if this operation is valid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string|closure|array
     */
    protected $outputFunction;

    /**
     * Function to call if this operation is invalid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         string|closure|array
     */
    protected $fallbackFunction;

    /**
     * Arguments to pass into both outputFunction and fallbackFunction
     *
     * @since       1.0.0
     * @version     1.0.0
     * @var         array
     */
    protected $functionParams = [];

    /**
     * Constructore
     *
     * Bootup all the traits for method alias mapping
     *
     * @since       1.0.0
     * @version     1.0.0
     */
    public function __construct()
    {
        $this->bootTraits();
    }

    /**
     * Set a custom input parser
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       $parser Custom input parser class name
     */
    public static function SetInputParser($parser)
    {
        if (class_exists($parser)) {
            static::$InputParser = $parser;
        }
    }

    /**
     * Add an acf field for operation
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $field_name Name of the field
     * @param       mix $target acf's target object
     */
    public function addField($field_name, $target = null)
    {
        $this->fields[] = new static::$InputParser($field_name, $target);

        return $this;
    }

    /**
     * Validate each fields and determine if current operation is valid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      boolean
     */
    protected function isValid()
    {
        if (! is_null($this->isValid)) return $this->isValid;

        $validationResults = array_map(function($field) {
            return $field->validate();
        }, $this->getFields());

        return $this->isValid = ! in_array(false, $validationResults);
    }

    /**
     * Get the current operation's fields
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string $field_name Name of the field
     * @param       mix $target acf's target object
     * @return      array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the current operation's fields value
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      array
     */
    protected function getFieldsValue()
    {
        $values = [];

        foreach ($this->getFields() as $field) {
            $values[$field->getName()] = $field->getValue();
        }

        return $values;
    }

    /**
     * Set the success output function
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string|closure|array $callable a callable reference
     */
    protected function setOutputFunction($callable)
    {
        $this->outputFunction = $callable;

        return $this;
    }

    /**
     * Set the failure output function
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string|closure|array $callable a callable reference
     */
    protected function setFallbackFunction($callable)
    {
        $this->fallbackFunction = $callable;

        return $this;
    }

    /**
     * Set the paremters for both success and failure output functions
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       array $params array of arguments
     */
    protected function setFunctionParams($params = [])
    {
        $this->functionParams = $params;

        return $this;
    }

    /**
     * Execute the operation and determain success or fail
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       closure $callback overwrite the valid logic
     * @return      mix
     */
    protected function execute($callback = null)
    {
        $result = $callback? $callback() : $this->isValid();

        return $result? $this->success() : $this->failed();
    }

    /**
     * Execute when operation is valid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      mix
     */
    protected function success()
    {
        if (! $this->outputFunction) {
            return true;
        }

        return call_user_func_array(
            $this->getCallableFunction($this->outputFunction),
            $this->functionParams? : $this->getFieldsValue()
        );
    }

    /**
     * Execute when operation is invalid
     *
     * @since       1.0.0
     * @version     1.0.0
     * @return      mix
     */
    protected function failed()
    {
        if (! $this->fallbackFunction) {
            return false;
        }

        return call_user_func_array(
            $this->getCallableFunction($this->fallbackFunction),
            $this->functionParams? : $this->getFieldsValue()
        );
    }

    /**
     * Verify the passed output function is callable
     *
     * @since       1.0.0
     * @version     1.0.0
     * @param       string|array $function a callable reference
     * @return      string|array
     */
    protected function getCallableFunction($function)
    {
        if (is_callable($function)) {
            return $function;
        }

        trigger_error(
            sprintf('Undefined function "%s" when outputing from AcfOutputHelper.', $function),
            E_USER_ERROR
        );
    }

    /**
     * Boot the trait's bootable method
     *
     * @since       1.0.0
     * @version     1.0.0
     */
    protected function bootTraits()
    {
        foreach (get_declared_traits() as $trait) {
            $shortName = (new \ReflectionClass($trait))->getShortName();

            if (method_exists($this, "boot{$shortName}")) {
                $this->{"boot{$shortName}"}();
            }
        }
    }

    /**
     * Allow method to call statically
     *
     * @param       string $calledMethod
     * @param       array $calledArgs
     */
    public static function __callStatic($calledMethod, $calledArgs)
    {
        $self = new static;

        if (is_callable([$self, $calledMethod])) {
            return call_user_func_array([$self, $calledMethod], $calledArgs);
        }
    }

    /**
     * Checking for alias
     *
     * @param       string $calledMethod
     * @param       array $calledArgs
     */
    public function __call($calledMethod, $calledArgs)
    {
        foreach ($this->aliasMapping as $method => $alias) {
            if (in_array($calledMethod, $alias)) {
                return call_user_func_array([$this, $method], $calledArgs);
            }
        }

        trigger_error(
            sprintf('Error: Call to undefined method %s()', str_replace('__call', $calledMethod, __METHOD__)),
            E_USER_ERROR
        );
    }
}
