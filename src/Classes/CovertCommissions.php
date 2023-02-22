<?php

namespace Corals\Modules\FormBuilder\Classes;

use GuzzleHttp\TransferStats;

class CovertCommissions
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
            list($meta_web_form_id, $listname) = explode('|', $list_id);
            $client = new \GuzzleHttp\Client();
            $fields = [
                'meta_web_form_id' => $meta_web_form_id,
                'meta_split_id' => '',
                'listname' => $listname,
                'meta_adtracking' => 'Custom Form',
                'redirect' => url('/'),
                'meta_forward_vars' => '1',
                'meta_message' => '1',
                'meta_tooltip' => '',
                'meta_required' => 'email,name',
                'email' => $email,
                'name' => $name,
                'submit' => 'Subscribe',

            ];
            $res = $client->request('POST', 'http://www.aweber.com/scripts/addlead.pl', [
                'form_params' => $fields,
                'on_stats' => function (TransferStats $stats) use (&$url) {
                    $url = $stats->getEffectiveUri();
                },
            ]);
            if ($res->getStatusCode() != 200) {
                throw new \Exception(trans('FormBuilder::exception.convert.error_occurred'));
            }
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
            $api_key = \Settings::get('form_builder_covert_commissions_api_key');

            $response = file_get_contents('https://covertcommissions.com/api/ar/' . $api_key);

            $lists = json_decode($response, true);
            $list_array = [];
            if (is_array($lists)) {
                foreach ($lists as $list_item) {
                    $list_array[$list_item['meta_web_form_id'] . "|" . $list_item['listname']] = $list_item['name'];
                }
            }

            return $list_array;
        } catch (\Exception $exception) {
            echo '<label  class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">' . $exception->getMessage() . '</label> ';
            log_exception($exception, 'MailChimpGetLists', 'subscribe');
        }
    }
}
