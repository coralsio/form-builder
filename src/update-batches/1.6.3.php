<?php

use \Carbon\Carbon;
use \Spatie\Permission\PermissionRegistrar;
try {

    \DB::table('permissions')->insert([
        [
            'name' => 'FormBuilder::form.action_email',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_api',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_database',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_aweber',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_mailchimp',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_constant_contact',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_get_response',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form.action_covert_commissions',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
    ]);
    app(PermissionRegistrar::class)->forgetCachedPermissions();


} catch (\Exception $exception) {
    log_exception($exception);
}


?>