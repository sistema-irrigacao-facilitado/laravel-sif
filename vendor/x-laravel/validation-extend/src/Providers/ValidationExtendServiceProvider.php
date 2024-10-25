<?php

namespace XLaravel\ValidationExtend\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationExtendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'X-Laravel');

        Validator::extend('human_name', 'XLaravel\ValidationExtend\Rules\HumanNameRule@passes');
    }
}
