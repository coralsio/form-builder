<?php

return [

    'send_email' => [
        'email_to' => 'Email para',
        'subject' => 'Sujeito',
        'body' => 'Corpo',
        'email_help' => 'Emails separados por vírgulas.',
        'body_help' => 'para incorporar valores de formulário
                      no texto use o seguinte padrão [field_name *]. <br/> * field_name: atributo de nome de campo no construtor de formulários',
    ],
    'call_api' => [
        'end_point' => 'Ponto final',
        'method' => 'Método',
        'body' => 'corpo',
        'body_help' => 'para incorporar valores de formulário no texto, use o seguinte padrão [field_name *]
                       . <br/> * field_name: atributo de nome de campo no construtor de formulários',
    ],
    'store_in_database' => [
        'unique_field' => 'Campo identificador exclusivo',
        'database_help' => 'Este campo será usado para evitar duplicatas, se não for preenchido, não haverá detecção de duplicação.',
    ],
    'general_fields' => [
        'list' => 'Lista',
        'email_field' => 'Nome do campo de email',
        'name_field' => 'Nome Nome do Campo',
    ],
    'settings' => [
        'aweber' => [
            'consumer_key' => 'Chave do consumidor',
            'consumer_secret' => 'consumidor secreto',
            'access_key' => 'Chave de acesso',
            'access_secret' => 'Segredo de acesso',
        ],
        'mailchimp' => [
            'api_key' => 'Chave API',
        ],
        'constant_contact' => [
            'api_key' => 'Chave API',
            'api_secret' => 'Segredo da API',
        ],
        'get_response' => [
            'api_key' => 'Chave API',
            'api_url' => 'URL da API',
        ],
        'covert_commission' => [
            'api_key' => 'Chave API',
        ],
    ],
    'form' => [
        'name' => 'Nome',
        'short_code' => 'Código curto',
        'is_public' => 'É público',
        'is_public_form' => 'É forma pública',
        'embed_form' => 'Formulário Incorporado',
    ],
    'form_submission' => [
        'action' => 'Açao',
        'action_type' => [
            'show_message' => 'Mostrar mensagem',
            'redirect_to' => 'Redirecionar para',
        ],
        'content' => 'Conteúdo',
    ],


];