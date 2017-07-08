<?php namespace Bugotech\I18n;

use Illuminate\Support\ServiceProvider;

class I18nServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Translate
        //$this->app->instance('path.lang', realpath(__DIR__ . '/../../../netforcews/i18n/langs'));
        $this->app->instance('path.lang', $this->app->path('langs'));
        $this->app->register('Illuminate\Translation\TranslationServiceProvider');
        //$this->loadTranslationsFrom(__DIR__ . '/../../netforcews/i18n/langs', '*');

        // Jargões
        $this->app->instance('path.jargon', $this->app->path('jargon'));
        $this->app->register('Bugotech\Jargon\JargonServiceProvider');

        // i18n
        $this->app->singleton('i18n', function ($app) {
            return new Translate($app['translator']);
        });
    }
}
