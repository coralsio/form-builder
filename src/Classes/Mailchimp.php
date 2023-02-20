<?php

namespace Corals\Modules\FormBuilder\Classes;

class Mailchimp
{
    /**
     * Subscribe user
     *
     * @param $email
     * @param $name
     * @return bool
     */
    public static function subscribe($email, $name, $list_id)
    {
        try {
            $api_key = \Settings::get('form_builder_mailchimp_api_key');

            $mc = new \NZTim\Mailchimp\Mailchimp($api_key);

            // Adds/updates an existing subscriber:
            $mc->subscribe($list_id, $email, $merge = ['FNAME' => $name], $confirm = false);
            // Use $confirm = false to skip double-opt-in if you already have permission.
            // This method will update an existing subscriber and will not ask an existing subscriber to re-confirm.
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Returns list of subscribers lists of account
     *
     * @return array
     * @throws \Exception
     */
    public static function lists()
    {
        try {
            $api_key = \Settings::get('form_builder_mailchimp_api_key');

            $mc = new \NZTim\Mailchimp\Mailchimp($api_key);

            $lists = $mc->getLists();
            $list_array = [];
            foreach ($lists as $list_item) {
                $list_array[$list_item['id']] = $list_item['name'];
            }

            return $list_array;
        } catch (\Exception $exception) {
            echo '<label  class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">'.$exception->getMessage().'</label> ';
            log_exception($exception, 'MailChimpGetLists', 'subscribe');
        }
    }
}
