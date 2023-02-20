<?php

namespace Corals\Modules\FormBuilder;

use Corals\Modules\FormBuilder\Facades\FormBuilder;
use Corals\Modules\FormBuilder\Models\Form;
use Corals\Modules\FormBuilder\Providers\FormBuilderAuthServiceProvider;
use Corals\Modules\FormBuilder\Providers\FormBuilderObserverServiceProvider;
use Corals\Modules\FormBuilder\Providers\FormBuilderRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'FormBuilder');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'FormBuilder');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->registerShortcode();

        $this->registerCustomFieldsModels();
        $this->registerModulesPackages();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/form_builder.php', 'form_builder');

        $this->app->register(FormBuilderRouteServiceProvider::class);
        $this->app->register(FormBuilderAuthServiceProvider::class);
        $this->app->register(FormBuilderObserverServiceProvider::class);


        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('FormBuilder', FormBuilder::class);
        });
    }

    public function registerShortcode()
    {
        \Shortcode::add('form', function ($key) {
            $view = 'FormBuilder::forms.formBuilder';

            \Assets::add(asset('assets/corals/plugins/formbuilder/css/jquery.rateyo.min.css'));
            \Assets::add(asset('assets/corals/plugins/formbuilder/js/sizzle.min.js'));
            \Assets::add(asset('assets/corals/plugins/formbuilder/js/jquery-ui.min.js'));
            \Assets::add(asset('assets/corals/plugins/formbuilder/js/form-builder.min.js'));
            \Assets::add(asset('assets/corals/plugins/formbuilder/js/form-render.min.js'));
            \Assets::add(asset('assets/corals/plugins/formbuilder/js/jquery.rateyo.min.js'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/css/smart_wizard.min.css'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/css/smart_wizard_theme_arrows.css'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/js/jquery.smartWizard.min.js'));
            \Assets::add(asset('assets/corals/plugins/smartwizard/js/validator.min.js'));

            if ($key == '$form') {
                //Assume Object passed
                return "<?php  echo \$__env->make('$view',['form'=>{$key}])->render(); ?>";
            } else {
                $form = Form::where('short_code', $key)->active()->first();

                view()->share(['form' => $form, 'short_code' => $key]);
            }
            if (view()->exists($view)) {
                return "<?php  echo \$__env->make('$view')->render(); ?>";
            }
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Form::class);
    }

    protected function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/form-builder');
    }
}
