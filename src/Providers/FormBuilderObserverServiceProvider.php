<?php

namespace Corals\Modules\FormBuilder\Providers;

use Corals\Modules\FormBuilder\Models\Form;
use Corals\Modules\FormBuilder\Observers\FormObserver;
use Illuminate\Support\ServiceProvider;

class FormBuilderObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {
        Form::observe(FormObserver::class);
    }
}
