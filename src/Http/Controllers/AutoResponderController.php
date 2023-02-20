<?php

namespace Corals\Modules\FormBuilder\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\FormBuilder\Classes\Aweber;
use Illuminate\Http\Request;

class AutoResponderController extends BaseController
{

    public function __construct()
    {
        $this->resource_url = config('form_builder.models.form.resource_url');
        $this->title = 'FormBuilder::module.auto_responder.title';
        $this->title_singular = 'FormBuilder::module.auto_responder.title_singular';


        parent::__construct();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function authorizeAweberApp(Request $request)
    {
        //oaut_token and oauth_verifier from AWeber authorization page
        if (\Request::has('oauth_token', 'oauth_verifier')) {
            try {
                //get access token/secret
                $access = Aweber::getAuthorize($request->input('oauth_token'), $request->input('oauth_verifier'));

                //save access token/secret
                \Settings::set('form_builder_aweber_access_key', $access->token, 'FormBuilder');
                \Settings::set('form_builder_aweber_access_secret', $access->secret, 'FormBuilder');

                flash(trans('FormBuilder::exception.auto_responder.aweber_authorized_success'))->success();
                return redirect($this->resource_url);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());

                flash(trans('FormBuilder::exception.auto_responder.error_occurred_aweber',['message' => $e->getMessage() ]))->error();
                return redirect($this->resource_url);
            }
        }
    }

}
