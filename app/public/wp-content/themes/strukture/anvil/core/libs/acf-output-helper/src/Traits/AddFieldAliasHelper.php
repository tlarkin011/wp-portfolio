<?php

namespace AcfOutputHelper\Traits;

trait AddFieldAliasHelper
{
    protected $addFieldAlias = [
        // singular
        'hasField'          => ['has', 'and', 'andHas'],
        'maybeHasField'     => ['maybe', 'maybeHas', 'andMaybe', 'andMaybeHas'],
        'hasSubField'       => ['sub', 'hasSub', 'andSub'],
        'maybeSubField'     => ['maybeSub', 'maybeHasSub', 'andMaybeSub', 'andMaybeHasSub'],
        'hasOptionField'    => ['option', 'hasOption', 'andOption'],
        'maybeOptionField'  => ['maybeOption', 'maybeHasOption', 'andMaybeOption', 'andMaybeHasOption'],
        // plural
        'haveFields'        => ['have', 'andHave'],
        'maybeHaveFields'   => ['maybeHave', 'andMaybeHave'],
        'haveSubFields'     => ['subs', 'haveSubs', 'andSubs'],
        'maybeSubFields'    => ['maybeSubs', 'maybeHaveSubs', 'andMaybeSubs', 'andMaybeHaveSubs'],
        'haveOptionFields'  => ['options', 'haveOptions', 'andOptions'],
        'maybeOptionFields' => ['maybeOptions', 'maybeHaveOptions', 'andMaybeOptions', 'andMaybeHaveOptions']
    ];

    public function bootAddFieldAliasHelper()
    {
        $this->aliasMapping = array_merge($this->aliasMapping, $this->addFieldAlias);
    }

    // singular

    public function hasField($field_name, $target = null)
    {
        return $this->addField($field_name, $target);
    }

    public function maybeHasField($field_name, $target = null)
    {
        return $this->addField("?{$field_name}", $target);
    }

    public function hasSubField($field_name)
    {
        return $this->addField(">{$field_name}");
    }

    public function maybeSubField($field_name)
    {
        return $this->addField("?>{$field_name}");
    }

    public function hasOptionField($field_name)
    {
        return $this->addField("~{$field_name}");
    }

    public function maybeOptionField($field_name)
    {
        return $this->addField("?~{$field_name}");
    }

    // plural

    public function haveFields()
    {
        return $this->iterateWithMethods(func_get_args(), 'hasField');
    }

    public function maybeHaveFields()
    {
        return $this->iterateWithMethods(func_get_args(), 'maybeHasField');
    }

    public function haveSubFields()
    {
        return $this->iterateWithMethods(func_get_args(), 'hasSubField');
    }

    public function maybeSubFields()
    {
        return $this->iterateWithMethods(func_get_args(), 'maybeSubField');
    }

    public function haveOptionFields()
    {
        return $this->iterateWithMethods(func_get_args(), 'hasOptionField');
    }

    public function maybeOptionFields()
    {
        return $this->iterateWithMethods(func_get_args(), 'maybeOptionField');
    }

    protected function iterateWithMethods($arguments, $method)
    {
        foreach ($arguments as $field) {
            if (! is_array($field)) $field = [$field];
            call_user_func_array([$this, $method], $field);
        }

        return $this;
    }
}
