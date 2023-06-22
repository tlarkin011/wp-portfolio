<?php

namespace AcfOutputHelper\Traits;

trait RelationshipOutputter
{
    protected $RelationshipOutputAlias = [
        'loopRelationship' => ['relationship']
    ];

    public function bootRelationshipOutputter()
    {
        $this->aliasMapping = array_merge($this->aliasMapping, $this->RelationshipOutputAlias);
    }

    public function loopRelationship($template, $params = [])
    {
        $this->setOutputFunction(function($relations) use ($template, $params) {
            if (! $relations) return;

            global $post;

            if (isset($params['before'])) echo $params['before'];

            foreach ($relations as $relation) {
                $post = is_int($relation)? get_post($relation) : $relation;
                setup_postdata($post);
                get_template_part($template);
            }

            wp_reset_postdata();

            if (isset($params['after'])) echo $params['after'];
        });

        $values = $this->getFieldsValue();

        $this->setFunctionParams([array_shift($values)]);

        $this->execute();
    }
}
