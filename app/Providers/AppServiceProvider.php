<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Custom validation rule for priority
        Validator::extend('priority', function ($attribute, $value, $parameters, $validator) {
            // Add your validation logic here, for example:
            return in_array($value, ['high', 'medium', 'low']);
        });
    }
}
