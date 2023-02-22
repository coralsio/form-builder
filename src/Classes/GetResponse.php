<?php

namespace Corals\Modules\FormBuilder\Classes;

class GetResponse
{
    /**
     * Subscribe user
     *
     * @param $email
     * @param $name
     * @return bool
     */
    public static function subscribe($email, $name, $campaign_id)
    {
        try {
            $api_key = \Settings::get('form_builder_get_response_api_key');
            $get_response = new GetResponseApi($api_key);

            $params = ['name' => $name,
                'email' => $email,
                'campaign' => ['campaignId' => $campaign_id]];


            $get_response->addContact($params);
        } catch (\Exception $e) {
            echo '<label class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">' . $e->getMessage() . '</label> ';
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
            $api_key = \Settings::get('form_builder_get_response_api_key');
            $api_url = \Settings::get('form_builder_get_response_api_url');
            $get_response = new GetResponseApi($api_key, $api_url);


            $lists = $get_response->getCampaigns();
            if ($lists->message) {
                echo '<label class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">' . $lists->message . '</label> ';

                return;
            }
            $lists_names = [];

            foreach ($lists as $list) {
                $lists_names[$list->campaignId] = $list->name;
            }

            return $lists_names;
        } catch (\Exception $e) {
            echo '<label class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">' . $e->getMessage() . '</label> ';
        }
    }
}
