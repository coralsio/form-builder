<?php

// FormBuilder
Breadcrumbs::register('form_builder', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('FormBuilder::module.form_builder.title'));
});

Breadcrumbs::register('forms', function ($breadcrumbs) {
    $breadcrumbs->parent('form_builder');
    $breadcrumbs->push(trans('FormBuilder::module.form.title'), url(config('form_builder.models.form.resource_url')));
});

Breadcrumbs::register('form_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('forms');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('form_show', function ($breadcrumbs) {
    $breadcrumbs->parent('forms');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//Form Submissions
Breadcrumbs::register('form_submissions', function ($breadcrumbs, $form) {
    $breadcrumbs->parent('forms');
    $breadcrumbs->push(trans('FormBuilder::module.form_submission.name',['name' => $form->name]), route(config('form_builder.models.form_submission.resource_route'), ['form' => $form->hashed_id]));
});

Breadcrumbs::register('form_submission_show', function ($breadcrumbs, $form) {
    $breadcrumbs->parent('form_submissions', $form);
    $breadcrumbs->push(view()->shared('title_singular'));
});


//Settings
Breadcrumbs::register('form_settings', function ($breadcrumbs) {
    $breadcrumbs->parent('forms');
    $breadcrumbs->push(trans('FormBuilder::module.form_setting.title'), url(config('form.resource_url') . '/settings'));
});