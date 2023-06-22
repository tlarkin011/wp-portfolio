<?php

namespace AcfOutputHelper\Traits;

trait CallbackOutputter
{
    protected $callbackOutputAlias = [
        'exceCallback'  => ['thenCall', 'call'],
    ];

    public function bootCallbackOutputter()
    {
        $this->aliasMapping = array_merge($this->aliasMapping, $this->callbackOutputAlias);
    }

    public function exceCallback($callback, $params = [], $fallback = null)
    {
        $this->setOutputFunction($callback);
        $this->setFallbackFunction($fallback);
        $this->setFunctionParams(array_merge($this->getFieldsValue(), $params));

        return $this->execute();
    }
}
