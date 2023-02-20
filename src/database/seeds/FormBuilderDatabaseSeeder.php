<?php

namespace Corals\Modules\FormBuilder\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Modules\FormBuilder\Models\Form;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class FormBuilderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FormBuilderPermissionsDatabaseSeeder::class);
        $this->call(FormBuilderMenusDatabaseSeeder::class);

        Form::create([
            'name' => 'Contact Us',
            'short_code' => 'contact-us',
            'content' => '[[{"type":"header","subtype":"h3","label":"Send us your feedback"},{"type":"text","required":true,"label":"Name","placeholder":"Name","className":"form-control","name":"name","subtype":"text","showInListing":true},{"type":"text","label":"Company Name","placeholder":"Company Name","className":"form-control","name":"company","subtype":"text","showInListing":true},{"type":"text","subtype":"email","required":true,"label":"Email","placeholder":"Email","className":"form-control","name":"email","showInListing":true},{"type":"text","required":true,"label":"Subject","placeholder":"Subject","className":"form-control","name":"subject","subtype":"text"},{"type":"textarea","required":true,"label":"Message","placeholder":"Message","className":"form-control","name":"message","subtype":"textarea","rows":"5"},{"type":"button","subtype":"submit","label":"Send","className":"btn  btn-primary","name":"send","style":"primary"}]]',
            'actions' => [
                'email' => [[
                    'to' => 'support@example.com',
                    'subject' => 'Contact us submission',
                    'body' => 'You received a message from : [name]
<p>Name: [name]</p>
<p> Email: [email]</p>
<p>Company: [company]</p>
<p>Subject: [subject]</p>
<p>Message: [message]</p>',
                ]],
            ],
            'submission' => [
                'on_success' => [
                    'action' => 'show_message',
                    'content' => 'Your message has been sent successfully.<br/> Thank you.',
                ],
                'on_failure' => [
                    'action' => 'show_message',
                    'content' => 'Sorry something went wrong!!<br/> Thank you.',
                ],
            ],
            'status' => 'active',
        ]);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'FormBuilder%')->delete();
        Permission::where('name', 'Administrations::admin.formbuilder')->delete();

        $menus = Menu::where('key', 'form_builder')->get();

        foreach ($menus as $menu) {
            Menu::where('parent_id', $menu->id)->delete();
            $menu->delete();
        }
    }
}
