<?php

\Corals\Settings\Models\Setting::whereIn('code', [
    'form_builder_aweber_consumer_key',
    'form_builder_aweber_consumer_secret',
    'form_builder_aweber_access_key',
    'form_builder_aweber_access_secret',
])->update(['category' => 'FormBuilder']);
