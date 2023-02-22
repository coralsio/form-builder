<?php

namespace Corals\Modules\FormBuilder\Classes;

use AWeberAPI;

class Aweber
{
    /**
     * Get authorize by token and verifier
     *
     * @param $oauth_token
     * @param $oauth_verifier
     * @return \stdClass
     */
    public static function getAuthorize($oauth_token, $oauth_verifier)
    {
        $customer_key = \Settings::get('form_builder_aweber_consumer_key');
        $customer_secret = \Settings::get('form_builder_aweber_consumer_secret');

        $aweber = Aweber::make($customer_key, $customer_secret);

        $aweber->user->requestToken = $oauth_token;
        $aweber->user->verifier = $oauth_verifier;

        $aweber->user->tokenSecret = \Cookie::get('aweber_request_secret');

        list($accessToken, $accessTokenSecret) = $aweber->getAccessToken();

        $access = new \stdClass();
        $access->token = $accessToken;
        $access->secret = $accessTokenSecret;

        return $access;
    }

    /**
     * Subscribe user
     *
     * @param $email
     * @param $name
     * @return bool
     */
    public static function subscribe($email, $name, $list_name)
    {
        try {
            $aweber = self::make();
            $access_key = \Settings::get('form_builder_aweber_access_key');
            $access_secret = \Settings::get('form_builder_aweber_access_secret');
            \Logger($access_key);
            \Logger($access_secret);
            $account = $aweber->getAccount($access_key, $access_secret);


            $lists = $account->lists->find(['name' => $list_name]);
            $list = $lists[0];

            $new_subscriber = $list->subscribers->create([
                'name' => $name,
                'email' => $email,
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    //make instance of AWeber

    /**
     * Make instance of AWeberAPI
     *
     * @param $customer_key
     * @param $customer_secret
     * @return AWeberAPI
     */
    public static function make()
    {
        $customer_key = \Settings::get('form_builder_aweber_consumer_key');
        $customer_secret = \Settings::get('form_builder_aweber_consumer_secret');

        return $aweber = new AWeberAPI($customer_key, $customer_secret);
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
            $access_key = \Settings::get('form_builder_aweber_access_key');
            $access_secret = \Settings::get('form_builder_aweber_access_secret');

            $aweber = self::make();

            if (! $access_key || ! $access_secret) {
                $callbackUrl = route('aweber.authorize');

                //save request token on cookies
                list($requestKey, $requesSecret) = $aweber->getRequestToken($callbackUrl);
                \Cookie::queue('aweber_request_secret', $requesSecret);

                $authorizeUrl = $aweber->getAuthorizeUrl();
                echo \CoralsForm::link($authorizeUrl, '<b>'.trans('FormBuilder::labels.aweber').'</b>', [
                    'class' => 'btn btn-danger m-b-10', 'target' => '_blank', 'style' => 'width:100%']);
                echo "<br>";
            } else {
                $account = $aweber->getAccount($access_key, $access_secret);

                $lists = $account->lists->data['entries'];

                $lists_names = [];

                foreach ($lists as $list) {
                    $lists_names[$list['name']] = $list['name'];
                }

                return $lists_names;
            }
        } catch (\Exception $e) {
            echo '<label class="label label-danger text-center pull-left p-t-5 p-b-5" style="width: 100%">'.$e->getMessage().'</label> ';
        }
    }
}
