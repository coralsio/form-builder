<?php

return [
    'mimes' => 'jpg,jpeg,png,txt,csv,pdf',
    'models' => [
        'form_submission' => [
            'presenter' => \Corals\Modules\FormBuilder\Transformers\FormSubmissionPresenter::class,
            'resource_route' => 'forms.submissions.index',
            'resource_relation' => 'form',
            'relation' => 'formSubmission',
            'actions' => [
                'edit' => [],
                'view' => [
                    'icon' => 'fa fa-eye',
                    'href_pattern' => ['pattern' => '[arg]', 'replace' => ['return $object->getShowUrl();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('FormBuilder::labels.form.submission.show');"]],
                    'data' => [],
                ],
            ],

        ],
        'form' => [
            'presenter' => \Corals\Modules\FormBuilder\Transformers\FormPresenter::class,
            'resource_url' => 'form-builder/forms',
            'actions' => [
                'submissions' => [
                    'icon' => 'fa fa-fw fa-send',
                    'href_pattern' => ['pattern' => '[arg]/submissions', 'replace' => ['return $object->getShowUrl();']],
                    'label_pattern' => ['pattern' => '[arg]', 'replace' => ["return trans('FormBuilder::labels.form.submission.title');"]],
                    'policies' => ['submissions'],
                    'data' => [],
                ],
            ],
            'form_actions' => [
                'email' => [
                    'name' => 'FormBuilder::labels.form.action.send_email',
                    'icon' => 'fa fa-envelope',
                    'multiple' => true,
                    'fields' => [
                        'to' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.send_email.email_to',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [
                                'help_text' => 'FormBuilder::attributes.send_email.email_help',
                            ],
                        ],
                        'subject' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.send_email.subject',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                        'body' => [
                            'type' => 'textarea',
                            'label' => 'FormBuilder::attributes.send_email.body',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [
                                'help_text' => 'FormBuilder::attributes.send_email.body_help',
                            ],
                        ],
                    ],
                ],
                'api' => [
                    'name' => 'FormBuilder::labels.form.action.call_api',
                    'icon' => 'fa fa-external-link',
                    'multiple' => true,
                    'fields' => [
                        'end_point' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.call_api.end_point',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                        'method' => [
                            'type' => 'select',
                            'label' => 'FormBuilder::attributes.call_api.method',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'options' => [
                                'POST' => 'POST',
                                'GET' => 'GET',
                            ],
                            'attributes' => [],
                        ],
                        'body' => [
                            'type' => 'textarea',
                            'label' => 'FormBuilder::attributes.call_api.body',
                            'required' => true,
                            'validation' => 'required|json',
                            'value' => null,
                            'attributes' => [
                                'help_text' => 'FormBuilder::attributes.call_api.body_help',
                            ],
                        ],
                    ],
                ],
                'database' => [
                    'name' => 'FormBuilder::labels.form.action.store_database',
                    'icon' => 'fa fa-database',
                    'multiple' => false,
                    'fields' => [
                        'unique_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.store_in_database.unique_field',
                            'required' => false,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => 'FormBuilder::attributes.store_in_database.database_help',
                            ],
                        ],
                    ],
                ],
                'aweber' => [
                    'name' => 'FormBuilder::labels.form.action.aweber',
                    'icon' => 'fa fa-reply',
                    'multiple' => true,
                    'fields' => [
                        'list' => [
                            'type' => 'select',
                            'label' => 'FormBuilder::attributes.general_fields.list',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'options' => 'return \Corals\Modules\FormBuilder\Classes\Aweber::lists();',
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'email_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.email_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                        'name_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.name_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                    ],
                    'settings' => [
                        'consumer_key' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.aweber.consumer_key',
                            'required' => true,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'consumer_secret' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.aweber.consumer_secret',
                            'required' => true,
                            'validation' => '',
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'access_key' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.aweber.access_key',
                            'required' => true,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'access_secret' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.aweber.access_secret',
                            'required' => true,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                    ],
                ],
                'mailchimp' => [
                    'name' => 'FormBuilder::labels.form.action.mailchimp',
                    'icon' => 'fa fa-reply',
                    'multiple' => true,
                    'fields' => [
                        'list' => [
                            'type' => 'select',
                            'label' => 'FormBuilder::attributes.general_fields.list',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'options' => 'return \Corals\Modules\FormBuilder\Classes\Mailchimp::lists();',
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'email_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.email_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                        'name_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.name_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                    ],
                    'settings' => [
                        'api_key' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.mailchimp.api_key',
                            'required' => true,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                    ],
                ],
                'get_response' => [
                    'name' => 'FormBuilder::labels.form.action.get_response',
                    'icon' => 'fa fa-reply',
                    'multiple' => true,
                    'fields' => [
                        'list' => [
                            'type' => 'select',
                            'label' => 'FormBuilder::attributes.general_fields.list',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'options' => 'return \Corals\Modules\FormBuilder\Classes\GetResponse::lists();',
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'email_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.email_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                        'name_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.name_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                    ],
                    'settings' => [
                        'api_key' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.get_response.api_key',
                            'required' => true,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'api_url' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.get_response.api_url',
                            'required' => false,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                    ],
                ],
                'covert_commissions' => [
                    'name' => 'FormBuilder::labels.form.action.convert_commission',
                    'icon' => 'fa fa-reply',
                    'multiple' => true,
                    'fields' => [
                        'list' => [
                            'type' => 'select',
                            'label' => 'FormBuilder::attributes.general_fields.list',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'options' => 'return \Corals\Modules\FormBuilder\Classes\CovertCommissions::lists();',
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                        'email_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.email_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                        'name_field' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.general_fields.name_field',
                            'required' => true,
                            'validation' => 'required',
                            'value' => null,
                            'attributes' => [],
                        ],
                    ],
                    'settings' => [
                        'api_key' => [
                            'type' => 'text',
                            'label' => 'FormBuilder::attributes.settings.covert_commission.api_key',
                            'required' => true,
                            'validation' => null,
                            'value' => null,
                            'attributes' => [
                                'help_text' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'locale_mapping' => [
        "ar" => "ar-TN",
        "de" => "de-DE",
        "en" => "en-US",
        "es" => "es-ES",
        "fa" => "fa-IR",
        "fr" => "fr-FR",
        "nl" => "nl-NL",
        "nb" => "nb-NO",
        "pl" => "pl-PL",
        "pt" => "pt-BR",
        "ro" => "ro-RO",
        "ru" => "ru-RU",
        "tr" => "tr-TR",
        "vi" => "vi-VN",
        "zh" => "zh-CN",
    ],
];
