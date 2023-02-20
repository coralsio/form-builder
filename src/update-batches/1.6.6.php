<?php

\DB::table('permissions')->insert([
    'name' => 'FormBuilder::form.access_all_forms',
    'guard_name' => config('auth.defaults.guard'),
    'created_at' => \Carbon\Carbon::now(),
    'updated_at' => \Carbon\Carbon::now(),
]);
