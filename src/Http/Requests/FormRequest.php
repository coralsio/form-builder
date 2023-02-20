<?php

namespace Corals\Modules\FormBuilder\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\FormBuilder\Models\Form;
use Illuminate\Support\Arr;

class FormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Form::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Form::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191',
                'status' => 'required|max:191',
                'form_actions' => 'required',
                'submission.on_success.action' => 'required',
                'submission.on_success.content' => 'required',
                'submission.on_failure.action' => 'required',
                'submission.on_failure.content' => 'required',
            ]);

            $request_actions = $this->get('form_actions', []);

            $actions_definition = config('form_builder.models.form.form_actions');

            foreach ($request_actions as $request_action_key => $actions) {
                //$request_action_key: email, api, database...
                $action_definition = \Arr::get($actions_definition, $request_action_key, null);

                if (!$action_definition) {
                    continue;
                }

                foreach ($actions as $key => $fields) {
                    foreach ($fields as $field_key => $field) {
                        if (!empty($action_definition['fields'][$field_key]['validation'])) {
                            $rules = array_merge($rules, [
                                "form_actions.$request_action_key.$key.$field_key" => $action_definition['fields'][$field_key]['validation']
                            ]);
                        }
                    }
                }
            }
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'short_code' => 'required|max:191|unique:forms,short_code'
            ]);
        }

        if ($this->isUpdate()) {
            $form = $this->route('form');
            $rules = array_merge($rules, [
                'short_code' => 'required|max:191|unique:forms,short_code,' . $form->id
            ]);
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [];

        $request_actions = $this->get('form_actions', []);

        $actions_definition = config('form_builder.models.form.form_actions');

        foreach ($request_actions as $request_action_key => $actions) {
            //$request_action_key: email, api, database...
            $action_definition = \Arr::get($actions_definition, $request_action_key, null);

            if (!$action_definition) {
                continue;
            }

            foreach ($actions as $key => $fields) {
                foreach ($fields as $field_key => $field) {
                    $attributes ["form_actions.$request_action_key.$key.$field_key"] = $field_key;
                }
            }
        }

        $attributes = array_merge($attributes, [
            'submission.on_success.action' => 'On success action',
            'submission.on_success.content' => 'On success content',
            'submission.on_failure.action' => 'On failure action',
            'submission.on_failure.content' => 'On failure content',
        ]);

        return $attributes;
    }

    public function messages()
    {
        return ['form_actions.required' => trans('FormBuilder::labels.request.you_miss_add_action')];
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        if ($this->isUpdate() || $this->isStore()) {
            $data = $this->all();

            $data['is_public'] = Arr::get($data, 'is_public', false);

            Arr::set($data, 'properties.has_captcha', Arr::get($data, 'properties.has_captcha', false) ? true : false);

            $this->getInputSource()->replace($data);
        }

        return parent::getValidatorInstance();
    }
}
