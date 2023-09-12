# lumite-studios/laravel-json-translation
This package adds JSON translation versions of the default Laravel translation files. It also makes it possible to add custom JSON translations with a prefix.

## Documentation
### Installation
```bash
composer require lumite-studios/laravel-json-translation
```
### Usage
```php
use LumiteStudios\JSONTranslations\TranslationServiceProvider as ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        parent::boot();

        $this->loadJsonTranslationsWithPrefix('../../lang/errors', 'errors');
        $this->loadJsonTranslationsWithPrefix('../../lang/other', 'other');
    }
}
```
