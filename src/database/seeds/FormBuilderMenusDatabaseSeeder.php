<?php

namespace Corals\Modules\FormBuilder\database\seeds;

use Illuminate\Database\Seeder;

class FormBuilderMenusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $builder_menu_id = \DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'form_builder',
            'url' => null,
            'active_menu_url' => 'form-builder*',
            'name' => 'Form Builder',
            'description' => 'Form Builder Item',
            'icon' => 'fa fa-pencil-square-o',
            'target' => null,
            'roles' => '["1"]',
            'order' => 0,
        ]);

        // seed users children menu
        \DB::table('menus')->insert(
            [
                [
                    'parent_id' => $builder_menu_id,
                    'key' => null,
                    'url' => config('form_builder.models.form.resource_url'),
                    'active_menu_url' => config('form_builder.models.form.resource_url') . '*',
                    'name' => 'Forms',
                    'description' => 'Forms List Menu Item',
                    'icon' => 'fa fa-list-alt',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );

        // seed users children menu
        \DB::table('menus')->insert(
            [
                [
                    'parent_id' => $builder_menu_id,
                    'key' => null,
                    'url' => 'form-builder/settings',
                    'active_menu_url' => 'form-builder/settings*',
                    'name' => 'Forms Settings',
                    'description' => 'Forms Settings Menu Item',
                    'icon' => 'fa fa-cog fa-fw',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );
    }
}
