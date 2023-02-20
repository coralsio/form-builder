<?php

namespace Corals\Modules\FormBuilder\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\FormBuilder\database\migrations\CreateFormsTable;
use Corals\Modules\FormBuilder\database\seeds\FormBuilderDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateFormsTable::class
    ];
    protected $module_public_path = __DIR__ . '/../public';

    protected function providerBooted()
    {
        $this->createSchema();

        $formBuilderSeeder = new FormBuilderDatabaseSeeder();
        $formBuilderSeeder->run();

        \DB::table('settings')->insert([
            [
                'code' => 'form_builder_aweber_consumer_key',
                'type' => 'TEXT',
                'category' => 'FormBuilder',
                'label' => 'form_builder_aweber_consumer_key',
                'value' => 'AkSuzXGUe2gHugnazR0qXQTS',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'form_builder_aweber_consumer_secret',
                'type' => 'TEXT',
                'category' => 'FormBuilder',
                'label' => 'form_builder_aweber_consumer_secret',
                'value' => 'xSO7CoYgYsVEAQokMAqI9cGy15gfHU5KzkUZhpmL',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'form_builder_aweber_access_key',
                'type' => 'TEXT',
                'category' => 'FormBuilder',
                'label' => 'form_builder_aweber_access_key',
                'value' => '',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'form_builder_aweber_access_secret',
                'type' => 'TEXT',
                'category' => 'FormBuilder',
                'label' => 'form_builder_aweber_access_secret',
                'value' => '',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
