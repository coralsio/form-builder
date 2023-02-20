<?php

return [
    'send_email' => [
        'email_to' => 'Email To',
        'subject' => 'Subject',
        'body' => 'Body',
        'email_help' => 'Comma separated emails.',
        'body_help' => 'to embed form values 
                      in text use the following pattern [field_name*]. <br/>* field_name: field name attribute in form builder',
    ],
    'call_api' => [
        'end_point' => 'End Point',
        'method' => 'Method',
        'body' => 'body',
        'body_help' => 'to embed form values in text use the following pattern [field_name*]
                       . <br/>* field_name: field name attribute in form builder',

    ],
    'store_in_database' => [
        'unique_field' => 'Unique identifier field',
        'database_help' => 'This field will be used to avoid duplicates, if not filled there will be no duplication detection.',
    ],
    'general_fields' => [
        'list' => 'List',
        'email_field' => 'Email Field name',
        'name_field' => 'Name Field name',
    ],
    'settings' => [
        'aweber' => [
            'consumer_key' => 'Consumer Key',
            'consumer_secret' => 'Consumer Secret',
            'access_key' => 'Access Key',
            'access_secret' => 'Access Secret',
        ],
        'mailchimp' => [
            'api_key' => 'API Key',
        ],
        'constant_contact' => [
            'api_key' => 'API Key',
            'api_secret' => 'API Secret',
        ],
        'get_response' => [
            'api_key' => 'API Key',
            'api_url' => 'API URL',
        ],
        'covert_commission' => [
            'api_key' => 'API Key',
        ],

    ],
    'form' => [
        'name' => 'Name',
        'blade_short_code' => 'Blade Shortcode',
        'content_short_code' => 'Content Shortcode',
        'has_captcha' => 'Add Google reCaptcha',
        'is_public' => 'Is Public',
        'is_public_form' => 'Is Public Form',
        'embed_form' => 'Embed Form',
        'short_code' => 'Shortcode',
    ],
    'form_submission' => [
        'action' => 'Action',
        'action_type' => [
            'show_message' => 'Show Message',
            'redirect_to' => 'Redirect to',
        ],
        'content' => 'Content',
    ],
];
