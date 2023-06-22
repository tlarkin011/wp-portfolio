<?php

namespace AcfBannerControl\Traits;

trait AdminControls
{
    protected $acfOptionPageName = 'Banner';
    protected $acfBannerFieldGroup = 'group_acf_banner_contorl';

    protected $autoGenerateBannerFieldGroup = true;
    protected $controlUI = true;
    protected $bannerFields = [];

    protected function bootAdminControls()
    {
        add_action('acf/init', [$this, 'loadBannerSettings'], 1);
        add_action('admin_head', [$this, 'admin_enqueue_scripts']);

        if (is_admin()) {
            add_filter('acf/get_field_group', [$this, 'setSingleControleLocation']);
            add_action('acf/init', [$this, 'add_admin_init'], 20);
        }
    }

    public function setOptionPageName($name)
    {
        $this->acfOptionPageName = $name;

        return $this;
    }

    public function setFieldGroup($key)
    {
        $this->acfBannerFieldGroup = $key;

        return $this;
    }

    public function setAutoGenerate($auto)
    {
        $this->autoGenerateBannerFieldGroup = !! $auto;

        return $this;
    }

    public function enableUI($enable)
    {
        $this->controlUI = !! $enable;

        return $this;
    }

    public function loadBannerSettings()
    {
        if (! $this->controlUI) {
            return;
        }

        $globalControlledCpts = get_field('acf_banner_globally_controlled_cpts', 'options')? : [];
        $singleControlledCpts = get_field('acf_banner_single_controlled_cpts', 'options')? : [];
        $globalControlledTaxs = get_field('acf_banner_globally_controlled_taxs', 'options')? : [];
        $singleControlledTaxs = get_field('acf_banner_single_controlled_taxs', 'options')? : [];

        $this->enableGlobalForCpt($globalControlledCpts, true);
        $this->enableSingleForCpt($singleControlledCpts, true);
        $this->enableGlobalForTax($globalControlledTaxs, true);
        $this->enableSingleForTax($singleControlledTaxs, true);
    }

    public function admin_enqueue_scripts()
    {
        if (! $this->controlUI) {
            return false;
        }

        printf(
            '<style>
                %1$s { float:right; }
                %1$s a { background: #0085ba; color: white; }
                %1$s a:hover { background: #008ec2; }
                %1$s.active a { background: white; color: #0085ba; }
                .acf-banner-location-disable .acf-fields { position: relative; }
                .acf-banner-location-disable .acf-banner-location-disable-overlay {
                    position: absolute;
                    background: rgba(255, 255, 255, .8);
                    top: 0; left: 0; right: 0; bottom: 0;
                    z-index: 999;
                }
                .acf-banner-location-disable .acf-banner-location-disable-overlay:after {
                    content: "This field group\'s location is managed by the banner manager.";
                    position: absolute;
                    top: 50%%;
                    left: 50%%;
                    transform: translate(-50%%, -50%%);
                    -webkit-transform: translate(-50%%, -50%%);
                    max-width: 60%%;
                    font-size: 22px;
                    text-align: center;
                    line-height: 32px;
                }
            </style>',
            '#acf-group_acf_banner_box_special-banners .acf-tab-group li:last-child:nth-child(2n+1)'
        );

        if (function_exists('acf_get_field_group') && get_the_ID() === acf_get_field_group($this->acfBannerFieldGroup)['ID']) {
            printf(
                '<script>
                    jQuery(function($) {
                        $("#acf-field-group-locations").addClass("acf-banner-location-disable");
                        $("#acf-field-group-locations .acf-fields").append("<div class=\'acf-banner-location-disable-overlay\'></div>");
                    });
                </script>'
            );
        }
    }

    public function add_admin_init()
    {
        add_action('admin_init', [$this, 'myabeCreateOptionPage'], 20);
        add_action('admin_init', [$this, 'myabeCreateFieldGroup'], 25);
        add_action('admin_init', [$this, 'addLocalBannerFieldGroups'], 30);
    }

    public function myabeCreateOptionPage()
    {
        if (! acf_get_options_page($this->getOptionPageSlug())) {
            acf_add_options_sub_page($this->acfOptionPageName);
        }
    }

    protected function getOptionPageSlug()
    {
        return 'acf-options-' . sanitize_title($this->acfOptionPageName);
    }

    public function myabeCreateFieldGroup()
    {
        if (! $this->autoGenerateBannerFieldGroup) return;

        if (acf_get_field_group($this->acfBannerFieldGroup)) return;

        $defaultFieldGroupJSON = file_exists(__DIR__ . '/../default-banner-field-group.json')?
            file_get_contents(__DIR__ . '/../default-banner-field-group.json') : '';

        $defaultFieldGroup = json_decode($defaultFieldGroupJSON, true);

        $defaultFieldGroup['key'] = $this->acfBannerFieldGroup;
        $defaultFieldGroup['title'] = 'Options: Page Banner';

        acf_import_field_group($defaultFieldGroup);
    }

    public function addLocalBannerFieldGroups()
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        $this->createDefaultBannerBox();
        $this->createCptBannerBox();
        $this->createTaxonomyBannerBox();
    }

    protected function createDefaultBannerBox()
    {
        $fields = array_merge(
            [$this->tabField('Default')],
            $this->prefixBannerFields('default', [$this->bannerBackgroundField], true),
            [$this->tabField('404')],
            $this->prefixBannerFields('404')
        );

        if ($this->controlUI) {
            $fields[] = $this->tabField('Settings');
            $fields = array_merge($fields, $this->settingFields());
        }

        $this->createBannerGroup('Special Banners', $fields, 5);
    }

    protected function settingFields()
    {
        return [
            [
                'key' => 'field_acf_banner_message_settings',
                'label' => '',
                'type' => 'message',
                'message' => '<span style="color: red">Setting will only take effect <b>after</b> saving.</span>'
            ],
            [
                'key' => 'field_acf_banner_globally_controled_cpts',
                'label' => 'Globally Controled Post Types',
                'name' => 'acf_banner_globally_controlled_cpts',
                'instructions' => 'Select the post types that you want to have global banner controls.',
                'type' => 'select',
                'choices' => $this->getAvailablePostTypes(),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value'
            ],
            [
                'key' => 'field_acf_banner_globally_controled_taxs',
                'label' => 'Globally Controled Taxonomies',
                'name' => 'acf_banner_globally_controlled_taxs',
                'instructions' => 'Select the taxonomies that you want to have global banner controls.',
                'type' => 'select',
                'choices' => $this->getAvailableTaxonomies(),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value'
            ],
            [
                'key' => 'field_acf_banner_single_controled_cpts',
                'label' => 'Individually Controled Post Types',
                'name' => 'acf_banner_single_controlled_cpts',
                'instructions' => 'Select the post types that you want to have individual banner controls on its single. (Page will always apply) <br/>If both global controlled and individual controled are selected, the individual\'s value will take effect',
                'type' => 'select',
                'choices' => $this->getAvailablePostTypes(),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value'
            ],
            [
                'key' => 'field_acf_banner_single_controled_taxs',
                'label' => 'Individually Controled Taxonomies',
                'name' => 'acf_banner_single_controlled_taxs',
                'instructions' => 'Select the taxonomies that you want to have individual banner controls on its single. <br/>If both global controlled and individual controled are selected, the individual\'s value will take effect',
                'type' => 'select',
                'choices' => $this->getAvailableTaxonomies(),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value'
            ]
        ];
    }

    public function setSingleControleLocation($field_group)
    {
        if ($this->controlUI && $field_group['key'] === $this->acfBannerFieldGroup) {
            $field_group['location'] = $this->populateBannerFieldGroupLocation();
        }

        return $field_group;
    }

    protected function populateBannerFieldGroupLocation()
    {
        $locations = [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ]
                
            ],
            [
                [
                    'param' => 'post_template',
                    'operator' => '==',
                    'value' => 'default',  
                ],
            ]
            
        ];

        foreach ($this->singleControlledCpts as $cpt) {
            $locations[] = [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $cpt,
                ],
            ];
        }

        foreach ($this->singleControlledTaxs as $tax) {
            $locations[] = [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => $tax,
                ],
            ];
        }

        return $locations;
    }

    protected function createCptBannerBox()
    {
        if (! $cpts = $this->getGlobalControlledCpt($publicCpts = get_post_types(['public' => true], 'objects'))) {
            return false;
        }

        $fields = [$this->messageField(
            'cpt',
            'Custom post types listed below are sharing the same banner setting on its singles'
        )];

        foreach ($cpts as $cptName) {
            $fields = array_merge(
                $fields,
                [$this->tabField($publicCpts[$cptName]->label)],
                $this->prefixBannerFields($cptName)
            );
        }

        $this->createBannerGroup('Post Type Singles', $fields);
    }

    protected function createTaxonomyBannerBox()
    {
        if (! $taxonomies = $this->getGlobalControlledTaxonomy($publicTaxonomies = get_taxonomies(['public' => true], 'objects'))) {
            return false;
        }

        $fields = [$this->messageField(
            'taxonomy',
            'Taxonomies listed below are sharing the same banner setting on its archive pages'
        )];

        foreach ($taxonomies as $taxonomyName) {
            $fields = array_merge(
                $fields,
                [$this->tabField($publicTaxonomies[$taxonomyName]->label)],
                $this->prefixBannerFields($taxonomyName)
            );
        }

        $this->createBannerGroup('Taxonomy Term Archives Pages', $fields);
    }

    protected function getGlobalControlledCpt($publicCpts)
    {
        return array_intersect($this->globalControlledCpts, array_keys($publicCpts));
    }

    protected function getGlobalControlledTaxonomy($publicTaxonomies)
    {
        return array_intersect($this->globalControlledTaxs, array_keys($publicTaxonomies));
    }

    protected function getAvailablePostTypes()
    {
        $post_types = get_post_types(['public' => true], 'objects');

        if (isset($post_types['page'])) unset($post_types['page']);
        if (isset($post_types['attachment'])) unset($post_types['attachment']);

        return wp_list_pluck($post_types, 'label');
    }

    protected function getAvailableTaxonomies()
    {
        $taxonomies = get_taxonomies(['public' => true], 'objects');

        if (isset($taxonomies['post_format'])) unset($taxonomies['post_format']);
        if (isset($taxonomies['post_tag'])) unset($taxonomies['post_tag']);

        return wp_list_pluck($taxonomies, 'label');
    }

    protected function createBannerGroup($title, $fields, $order = 10)
    {
        acf_add_local_field_group([
            'key' => 'group_acf_banner_box_' . sanitize_title($title),
            'title' => $title,
            'fields' => $fields,
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => $this->getOptionPageSlug(),
                    ],
                ],
            ],
            'active' => 1,
            'position' => 'normal',
            'menu_order' => $order,
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => [],
            'description' => '',
        ]);
    }

    protected function tabField($title)
    {
        return [
            'key' => 'field_acf_banner_tab_' . sanitize_title($title),
            'label' => $title,
            'type' => 'tab'
        ];
    }

    protected function messageField($title, $message = '')
    {
        return [
            'key' => 'field_acf_banner_message_' . sanitize_title($title),
            'label' => '',
            'type' => 'message',
            'message' => $message
        ];
    }

    protected function prefixBannerFields($prefix, $onlyFields = [], $removeCondition = false)
    {
        $fields = $onlyFields? $this->getSelectedBannerFields($onlyFields) : $this->bannerFields;

        return array_map(function($field) use ($prefix, $removeCondition) {
            unset($field['ID'], $field['parent']);

            $field['ID'] = 0;
            $field['key'] = "{$field['key']}_{$prefix}";
            $field['name'] = "{$prefix}_{$field['name']}";

            if ($removeCondition) {
                $field['conditional_logic'] = 0;
            } else {
                foreach ($field['conditional_logic']? : [] as $group => $set) {
                    foreach ($set as $index => $rules) {
                        $field['conditional_logic'][$group][$index]['field'] = $rules['field'] . "_{$prefix}";
                    }
                }
            }

            return $field;
        }, $fields);
    }

    protected function getSelectedBannerFields($onlyFields = [])
    {
        $fields = [];

        foreach ($onlyFields as $fieldName) {
            if ($field = $this->getBannerFieldByName($fieldName)) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    protected function getBannerFieldByName($name)
    {
        foreach ($this->loadBannerFieldGroup() as $field) {
            if ($field['name'] == $name) return $field;
        }

        return false;
    }

    public function loadBannerFieldGroup()
    {
        if (! $this->bannerFields) {
            $this->bannerFields = acf_get_fields($this->acfBannerFieldGroup)? : [];
        }

        return $this->bannerFields;
    }
}
