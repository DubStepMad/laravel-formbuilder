<?php

namespace dubstepmad\FormBuilder;

use dubstepmad\FormBuilder\Middlewares\FormAllowSubmissionEdit;
use dubstepmad\FormBuilder\Middlewares\PublicFormAccess;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'formbuilder');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        // register the middleware
        Route::aliasMiddleware('public-form-access', PublicFormAccess::class);
        Route::aliasMiddleware('submisson-editable', FormAllowSubmissionEdit::class);

        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/formbuilder.php' => config_path('formbuilder.php', 'formbuilder'),
        ], 'formbuilder.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/formbuilder'),
        ], 'formbuilder.views');

        // publish public assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/formbuilder'),
        ], 'formbuilder-public');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/formbuilder.php', 'formbuilder');

        // Register the service the package provides.
        $this->app->singleton('formbuilder', function ($app) {
            return new FormBuilder;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['formbuilder'];
    }
}
