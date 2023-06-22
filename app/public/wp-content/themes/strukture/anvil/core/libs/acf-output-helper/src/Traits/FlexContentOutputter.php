<?php

namespace AcfOutputHelper\Traits;

trait FlexContentOutputter
{
    protected $FlexContentOutputAlias = [
        'loopFlexContent' => ['flexContent']
    ];

    public function bootFlexContentOutputter()
    {
        $this->aliasMapping = array_merge($this->aliasMapping, $this->FlexContentOutputAlias);
    }

    public function loopFlexContent($templateDir)
    {
        $this->setOutputFunction(function($field) use ($templateDir) {
            while (call_user_func_array('have_rows', $field->getCallable())): the_row();
                get_template_part(trailingslashit($templateDir) . get_row_layout());
            endwhile;
        });

        $fields = $this->getFields();

        $this->setFunctionParams([array_shift($fields)]);

        $this->execute();
    }
}
