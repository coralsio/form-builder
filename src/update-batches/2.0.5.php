<?php

use Corals\User\Models\Permission;

if (!Permission::where('name', 'FormBuilder::form_submission.view')->first()) {
    \DB::table('permissions')->insert([
        [
            'name' => 'FormBuilder::form_submission.view',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form_submission.delete',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form_submission.update',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'FormBuilder::form_submission.create',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]
    ]);
}
