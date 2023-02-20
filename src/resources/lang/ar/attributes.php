<?php

return [
    'send_email' => [
        'email_to' => 'رسالة إلى',
        'subject' => 'موضوع',
        'body' => 'محتوى',
        'email_help' => 'رسائل مفصولة بفواصل',
        'body_help' => 'لتضمين قيم النموذج
                       في النص ، استخدم النمط التالي [field_name *]. <br/> * field_name: سمة اسم المجال في أداة إنشاء النموذج                     ',
    ],
    'call_api' => [
        'end_point' => 'نقطة النهاية',
        'method' => 'طريقة',
        'body' => 'محتوى',
        'body_help' => 'لتضمين قيم النماذج في النص ، استخدم النمط التالي [field_name *]
                        . <br/> * field_name: سمة اسم الحقل في مُنشئ النموذج',

    ],
    'store_in_database' => [
        'unique_field' => 'حقل معرف فريد',
        'database_help' => 'سيتم استخدام هذا الحقل لتجنب التكرار ، إذا لم يتم تعبئته ، فلن يتم الكشف عن الازدواجية.',
    ],
    'general_fields' => [
        'list' => 'قائمة',
        'email_field' => 'اسم حقل البريد الإلكتروني',
        'name_field' => 'اسم حقل الاسم',
    ],
    'settings' => [
        'aweber' => [
            'consumer_key' => 'مفتاح المستهلك',
            'consumer_secret' => 'سر المستهلك',
            'access_key' => 'مفتاح الوصول',
            'access_secret' => 'سر الوصول',
        ],
        'mailchimp' => [
            'api_key' => 'مفتاح API',
        ],
        'constant_contact' => [
            'api_key' => 'مفتاح API',
            'api_secret' => 'سر API',
        ],
        'get_response' => [
            'api_key' => 'مفتاح API',
            'api_url' => 'عنوان URL الخاص بـ API',
        ],
        'covert_commission' => [
            'api_key' => 'مفتاح API',
        ],

    ],
    'form' => [
        'name' => 'الاسم',
        'short_code' => 'رمز قصير',
        'is_public' => 'العام',
        'is_public_form' => 'هو النموذج العام',
        'embed_form' => 'تضمين نموذج',
    ],
    'form_submission' => [
        'action' => 'اجراء',
        'action_type' => [
            'show_message' => 'اظهر الرسالة',
            'redirect_to' => 'إعادة التوجيه إلى',
        ],
        'content' => 'يحتوى',
    ],
];
