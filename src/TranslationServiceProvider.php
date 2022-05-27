<?php

namespace LumiteStudios\JSONTranslations;

use LumiteStudios\JSONTranslations\Loader;
use Illuminate\Translation\TranslationServiceProvider as ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * The direct path.
     * @var string
     */
    protected string $root = __DIR__ . '/..';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new Loader($app['files'], $app['path.lang']);
        });

        $this->loadJsonTranslationsWithPrefix("{$this->root}/lang/validation", "validation");
    }

    /**
     * Register a JSON translation file path.
     *
     * @param  string  $path
     * @return void
     */
    protected function loadJsonTranslationsWithPrefix($path, $prefix)
    {
        $this->app['translator']->addJsonPath(['prefix' => $prefix, 'path' => $path]);
    }
}
