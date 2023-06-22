<?php

namespace AcfOutputHelper;

use AcfOutputHelper\AcfOutputHelper;
use AcfOutputHelper\Parsers\FilterParser;

class ChiselAcf extends AcfOutputHelper
{
    public function __construct()
    {
        parent::__construct();

        FilterParser::SetStaticFilterClass(get_called_class());
    }

    public function heading($heading, $class = '', $echo = true)
    {
        $field = $this->getFields()[0];

        $format = sprintf('<%1$s class="%2$s">%%s</%1$s>',
            $heading,
            $class === false? '' : str_replace('_', '-', sanitize_title($field->getName())) . " $class"
        );

        $heading = $this->returnFormat($format);

        if ($echo) echo $heading;

        return $heading;
    }

    public static function splitSegments($value, $delimiter = '|', $trim = true)
    {
        $chunks = explode($delimiter, $value);

        if ($trim) {
            $chunks = array_map('trim', $chunks);
        }

        $chunks = array_map(function($seg, $i) {
            return sprintf('<span class="seg-%s">%s</span>', $i + 1, $seg);
        }, $chunks, array_keys($chunks));

        return implode(' ', $chunks);
    }

    public static function emphasize($value)
    {
        return preg_replace('/\[([^\]]+)\]/i', '<i>$1</i>', $value);
    }
}
