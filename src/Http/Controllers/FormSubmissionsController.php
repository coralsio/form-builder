<?php

namespace Corals\Modules\FormBuilder\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\FormBuilder\DataTables\FormSubmissionsDataTable;
use Corals\Modules\FormBuilder\Http\Requests\FormSubmissionRequest;
use Corals\Modules\FormBuilder\Models\Form;
use Corals\Modules\FormBuilder\Models\FormSubmission;

class FormSubmissionsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('form_builder.models.form_submission.resource_route'),
            ['form' => request()->route('form') ?: '_']
        );

        $this->resource_model = new FormSubmission();

        $this->title = 'FormBuilder::module.form_submission.title';
        $this->title_singular = 'FormBuilder::module.form_submission.title_singular';

        parent::__construct();
    }

    /**
     * @param FormSubmissionRequest $request
     * @param Form $form
     * @param FormSubmissionsDataTable $dataTable
     * @return mixed
     */
    public function index(FormSubmissionRequest $request, Form $form, FormSubmissionsDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('FormBuilder::labels.form.submission.index_title', ['name' => $form->name, 'title' => $this->title])]);

        return $dataTable->setResourceUrl($this->resource_url)->render('FormBuilder::submissions.index', compact('form'));
    }

    /**
     * @param FormSubmissionRequest $request
     * @param Form $form
     * @param FormSubmission $formSubmission
     * @return $this
     */
    public function show(FormSubmissionRequest $request, Form $form, FormSubmission $formSubmission)
    {
        $form_inputs = collect(\FormBuilder::getFormFieldsLabel($form));
        $formSubmission_content = $formSubmission->content;
        $form_data = $form_inputs->mapWithKeys(function ($item) use ($form_inputs, $formSubmission_content) {
            $value = \Arr::get($formSubmission_content, array_search($item, $form_inputs->toArray()), '-');

            return [array_search($item, $form_inputs->toArray()) => $value];
        });
        $form_data = $form_data->toArray();
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $form->name . " - " . $formSubmission->id])]);

        return view('FormBuilder::submissions.show')->with(compact('form_data', 'form_inputs'));
    }

    /**
     * @param FormSubmissionRequest $request
     * @param Form $form
     * @param FormSubmission $formSubmission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FormSubmissionRequest $request, Form $form, FormSubmission $formSubmission)
    {
        try {
            $formSubmission->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, FormSubmission::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
