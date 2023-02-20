<?php

namespace Corals\Modules\FormBuilder\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\FormBuilder\database\migrations\CreateFormsTable;
use Corals\Modules\FormBuilder\database\seeds\FormBuilderDatabaseSeeder;
use Corals\Settings\Models\Setting;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateFormsTable::class
    ];

    protected function providerBooted()
    {
        $this->dropSchema();
        $formBuilderSeeder = new FormBuilderDatabaseSeeder();
        $formBuilderSeeder->rollback();
        Setting::where('code', 'like', 'form_builder_%')->delete();
    }
}
