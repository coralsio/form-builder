<?php

namespace Corals\Modules\FormBuilder\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\FormBuilder\DataTables\FormsDataTable;
use Corals\Modules\FormBuilder\Http\Requests\FormRequest;
use Corals\Modules\FormBuilder\Models\Form;
use Illuminate\Http\Request;

class FormsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('form_builder.models.form.resource_url');

        $this->resource_model = new Form();

        $this->title = 'FormBuilder::module.form.title';
        $this->title_singular = 'FormBuilder::module.form.title_singular';

        $this->corals_middleware_except = ['publicSubmit', 'embed'];

        parent::__construct();
    }

    /**
     * @param Request $request
     * @param $key
     * @return array|string
     * @throws \Throwable
     */
    public function getActionTemplate(Request $request, $key)
    {
        $action = \Arr::get(config('form_builder.models.form.form_actions'), $key, null);

        if (! $action) {
            abort(404);
        }

        try {
            $view = view('FormBuilder::forms.action_template')->with(compact('action', 'key'))->render();

            return $view;
        } catch (\Exception $exception) {
            log_exception($exception, Form::class, 'ActionTemplate');
        }
    }

    /**
     * @param FormRequest $request
     * @param FormsDataTable $dataTable
     * @return mixed
     */
    public function index(FormRequest $request, FormsDataTable $dataTable)
    {
        return $dataTable->render('FormBuilder::forms.index');
    }

    /**
     * @param FormRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormRequest $request)
    {
        $form = new Form();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('FormBuilder::forms.create_edit')->with(compact('form'));
    }

    /**
     * @param FormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FormRequest $request)
    {
        try {
            $data = $request->except('form_actions');

            $data['actions'] = $this->getActionData($request);

            $content = json_decode($data['content']);

            $data['content'] = json_encode(array_filter($content));

            $form = Form::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Form::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    protected function getActionData(Request $request)
    {
        $actions = [];

        foreach ($request->get('form_actions', []) as $request_action_key => $form_action) {
            foreach ($form_action as $key => $fields) {
                $action = [];
                foreach ($fields as $field_key => $value) {
                    $action[$field_key] = $value;
                }
                $actions[$request_action_key][] = $action;
            }
        }

        return $actions;
    }

    /**
     * @param FormRequest $request
     * @param Form $form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(FormRequest $request, Form $form)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $form->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $form->hashed_id . '/edit']);

        return view('FormBuilder::forms.show')->with(compact('form'));
    }

    /**
     * @param FormRequest $request
     * @param Form $form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(FormRequest $request, Form $form)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $form->name])]);

        return view('FormBuilder::forms.create_edit')->with(compact('form'));
    }

    /**
     * @param FormRequest $request
     * @param Form $form
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FormRequest $request, Form $form)
    {
        try {
            $data = $request->except('form_actions');

            $data['actions'] = $this->getActionData($request);

            $content = json_decode($data['content']);

            $data['content'] = json_encode(array_filter($content));

            $form->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Form::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param FormRequest $request
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FormRequest $request, Form $form)
    {
        try {
            $form->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Form::class, 'destroy');
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @param Form $form
     * @return mixed
     */
    public function submit(Request $request, Form $form)
    {
        return \FormBuilder::submit($request, $form);
    }

    /**
     * @param Request $request
     * @param Form $form
     * @return mixed
     */
    public function publicSubmit(Request $request, Form $form)
    {
        return \FormBuilder::submit($request, $form);
    }

    /**
     * @param Request $request
     * @param Form $form
     * @return string
     * @throws \Throwable
     */
    public function embed(Request $request, Form $form)
    {
        \Theme::set(\Settings::get('active_admin_theme', config('themes.corals_admin')));


        \Assets::add(asset('assets/corals/plugins/formbuilder/css/jquery.rateyo.min.css'));

        \Assets::add(asset('assets/corals/plugins/formbuilder/js/sizzle.min.js'));
        \Assets::add(asset('assets/corals/plugins/formbuilder/js/jquery-ui.min.js'));
        \Assets::add(asset('assets/corals/plugins/formbuilder/js/form-builder.min.js'));
        \Assets::add(asset('assets/corals/plugins/formbuilder/js/form-render.min.js'));
        \Assets::add(asset('assets/corals/plugins/formbuilder/js/embed.js'));
        \Assets::add(asset('assets/corals/plugins/formbuilder/js/jquery.rateyo.min.js'));
        \Assets::add(asset('assets/corals/plugins/smartwizard/css/smart_wizard.min.css'));
        \Assets::add(asset('assets/corals/plugins/smartwizard/css/smart_wizard_theme_arrows.css'));
        \Assets::add(asset('assets/corals/plugins/smartwizard/js/jquery.smartWizard.min.js'));
        \Assets::add(asset('assets/corals/plugins/smartwizard/js/validator.min.js'));


        $short_code = $form->short_code;

        $extend = 'true';

        $view = 'FormBuilder::forms.formBuilder';

        $view_variables = compact('short_code', 'extend', 'form');

        return view('layouts.embed')->with(compact('view', 'view_variables'))->render();
    }

    public function settings(Request $request)
    {
        $this->setViewSharedData(['title_singular' => trans('FormBuilder::module.form.setting')]);

        $settings = [];
        $actions = config('form_builder.models.form.form_actions');

        foreach ($actions as $key => $action) {
            if (isset($action['settings'])) {
                if (user()->hasPermissionTo('FormBuilder::form.action_' . $key)) {
                    $settings['form_builder_' . $key] = ['name' => $action['name'], 'settings' => $action['settings']];
                }
            }
        }

        return view('FormBuilder::forms.settings')->with(compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        try {
            $settings = $request->except('_token');

            foreach ($settings as $key => $value) {
                \Settings::set($key, $value, 'FormBuilder');
            }

            flash(trans('Corals::messages.success.saved', ['item' => trans('FormBuilder::module.form.setting')]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, 'FormsSettings', 'savedSettings');
        }

        return redirectTo($this->resource_url);
    }
}
