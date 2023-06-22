<?php

namespace AcfOutputHelper\Traits;

trait ImageOutputter
{
    protected $ImageOutputAlias = [
        'returnImage'           => ['thenReturnImage'],
        'printImage'            => ['thenImage', 'image'],
    ];

    public function bootImageOutputter()
    {
        $this->aliasMapping = array_merge($this->aliasMapping, $this->ImageOutputAlias);
    }

    public function returnImage($imageSize = 'thumbnail', $params = [], $imageAttrs = '')
    {
        $values = $this->getFieldsValue();

        $imageHtml = $this->getImageHtmlFromAcf(array_shift($values), $imageSize, $imageAttrs);

        $this->setOutputFunction('sprintf');
        $this->setFunctionParams([
            sprintf(
                '%s%%s%s',
                isset($params['before'])? $params['before'] : '',
                isset($params['after'])? $params['after'] : ''
            ),
            $imageHtml
        ]);

        return $this->execute(function() use ($imageHtml) {
            return !! $imageHtml;
        });
    }

    public function printImage($imageSize = 'thumbnail', $params = [], $imageAttrs = '')
    {
        echo $this->returnImage($imageSize, $params, $imageAttrs);
    }

    protected function getImageHtmlFromAcf($value = null, $imageSize = 'thumbnail', $imageAttrs = '')
    {
        if (is_int($value) && $value > 0) {
            return wp_get_attachment_image($value, $imageSize, false, $imageAttrs);
        }

        if (is_string($value)) {
            return sprintf(
                '<img src="%s" alt="%s" %s />',
                $value,
                isset($imageAttrs['alt'])? $imageAttrs['alt'] : '',
                isset($imageAttrs['class'])? "class=\"{$imageAttrs['class']}\"" : ''
            );
        }

        if (is_array($value) && isset($value['id'])) {
            return wp_get_attachment_image($value['id'], $imageSize, false, $imageAttrs);
        }

        return false;
    }
}
