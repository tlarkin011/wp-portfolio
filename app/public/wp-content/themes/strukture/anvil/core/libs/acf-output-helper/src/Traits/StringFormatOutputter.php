<?php

namespace AcfOutputHelper\Traits;

trait StringFormatOutputter
{
    protected $stringOutputAlias = [
        'returnFormat' => ['thenReturn'],
        'printFormat'  => ['then', 'format', 'echo'],
    ];

    public function bootStringFormatOutputter()
    {
        $this->aliasMapping = array_merge($this->aliasMapping, $this->stringOutputAlias);
    }

    public function returnFormat($format = '%s', $additionals = [])
    {
        $this->setOutputFunction('sprintf');
        $this->setFunctionParams(array_merge([$format], $this->getFieldsValue(), $additionals));

        return $this->execute();
    }

    public function printFormat($format = '%s', $additionals = [])
    {
        echo $this->returnFormat($format, $additionals);
    }
}
