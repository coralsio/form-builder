<?php

namespace Corals\Modules\FormBuilder\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\FormBuilder\Models\FormSubmission;

class FormSubmissionRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(FormSubmission::class, 'formSubmission');

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(FormSubmission::class, 'formSubmission');
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $form = $this->route('formSubmission');
            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
