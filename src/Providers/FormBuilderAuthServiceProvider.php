<?php

namespace Corals\Modules\FormBuilder\Providers;

use Corals\Modules\FormBuilder\Models\Form;
use Corals\Modules\FormBuilder\Models\FormSubmission;
use Corals\Modules\FormBuilder\Policies\FormPolicy;
use Corals\Modules\FormBuilder\Policies\FormSubmissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class FormBuilderAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Form::class => FormPolicy::class,
        FormSubmission::class => FormSubmissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
