<?php

namespace Corals\Modules\FormBuilder\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\FormBuilder\Models\Form;

class FormTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('form_builder.models.form.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Form $form
     * @return array
     * @throws \Throwable
     */
    public function transform(Form $form)
    {
        $show_url = $form->getShowURL();

        $transformedArray = [
            'id' => $form->id,
            'name' => '<a href="' . url($show_url) . '">' . $form->name . '</a>',
            'status' => formatStatusAsLabels($form->status),
            'is_public' => $form->is_public ? '<i class="fa fa-check text-success"></i>' : '-',
            'blade_short_code' => $this->getShortcode($form),
            'content_short_code' => $this->getShortcode($form, true),
            'created_at' => format_date($form->created_at),
            'updated_at' => format_date($form->updated_at),
            'action' => $this->actions($form)
        ];

        return parent::transformResponse($transformedArray);
    }

    protected function getShortcode($form, $forContent = false)
    {
        if ($forContent) {
            return '<b id="shortcode_content_' . $form->id . '">@form(' . $form->short_code . ')</b> 
                <a href="#" onclick="event.preventDefault();" class="copy-button"
                data-clipboard-target="#shortcode_content_' . $form->id . '"><i class="fa fa-clipboard"></i></a>';
        } else {
            return '<b id="shortcode_blade_' . $form->id . '">{!!\Shortcode::compile(\'form\',\'' . $form->short_code . '\')!!}</b> 
                <a href="#" onclick="event.preventDefault();" class="copy-button"
                data-clipboard-target="#shortcode_blade_' . $form->id . '"><i class="fa fa-clipboard"></i></a>';
        }
    }
}
