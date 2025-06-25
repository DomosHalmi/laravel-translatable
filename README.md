# Labrodev Laravel Translatable

A Laravel package that adds JSON-based multilingual support to your Eloquent models. It provides:

- **QueryFieldLocalizer**: Utility to localize JSON fields to the current locale.
- **SearchQueryBuilder**: Trait for case-insensitive, multi-locale JSON field searching.
- **LocaleResolver**: Default resolver that returns `app.locale` and `app.fallback_locale`.

---

## Installation

Require the package via Composer:

```bash
composer require labrodev/laravel-translatable
```

Optionally, publish the configuration (if you add a config file later):

```bash
php artisan vendor:publish --provider="Labrodev\Translatable\TranslatableServiceProvider"
```

> **Note:** No configuration file is required out of the box—this is here for future customization.

---

## Usage

### 1. Localizing JSON Fields

`QueryFieldLocalizer` helps you build locale-specific JSON paths for query fields:

```php
use Labrodev\Translatable\Utilities\QueryFieldLocalizer;

// Assume the `title` column contains JSON:
// { "en": "Hello", "es": "Hola" }
$localized = QueryFieldLocalizer::translatableField('title');
// On locale `es`, returns: "title->es"

// Use in query:
$posts = Post::whereRaw("{$localized} = ?", ['Hola'])->get();
```

### 2. Multilingual Search on JSON Columns

Add the `SearchQueryBuilder` trait to your Eloquent model:

```php
use Illuminate\Database\Eloquent\Model;
use Labrodev\Translatable\Base\Traits\SearchQueryBuilder;

class Article extends Model
{
    use SearchQueryBuilder;

    protected $casts = [
        'titles' => 'array',
    ];
}
```

Perform a case-insensitive search across all configured locales:

```php
// Searches "manzana" in `titles` JSON for locales [en, es]
$results = Article::query()
    ->where(function ($q) {
        $this->searchField($q, 'manzana', 'titles');
    })
    ->get();
```

Or chain with existing conditions:

```php
$posts = Article::query()
    ->where('published', true)
    ->orWhere(function ($q) {
        $this->searchFieldOr($q, 'orange', 'titles');
    })
    ->get();
```

### 3. Customizing Locales

By default, locales come from `app.locale` and `app.fallback_locale`. To customize, bind your own `LocaleResolver` implementation:

```php
use Labrodev\Translatable\Contracts\LocaleResolver;

$this->app->singleton(LocaleResolver::class, function ($app) {
    return new class implements LocaleResolver {
        public function all(): array
        {
            return ['en', 'fr', 'es'];
        }
    };
});
```

---

## Testing

This package uses Pest with Orchestra Testbench for testing and PHPStan for static analysis.
This package uses [Pest](https://pestphp.com/) with [Orchestra Testbench](https://github.com/orchestral/testbench) for testing and [PHPStan](https://https://phpstan.org/) for static analysis

1. Install dependencies:
   ```bash
   composer install
   ```
2. Run static analysis:
   ```bash
   composer analyse
   ```
   
3. Run tests:
   ```bash
   composer test
   ```

Tests cover:
- `QueryFieldLocalizer::translatableField()` outputs correct JSON path.
- `SearchQueryBuilder` builds proper SQL & bindings for multilingual JSON searches.
- `DefaultLocaleResolverTest` resolve locales array.

---

## Security

If you discover any security-related issues, please email admin@labrodev.com instead of using the issue tracker.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Labro Dev](https://github.com/labrodev)

## Contributing

Feel free to open issues or submit pull requests. Check Coding Standards:

- PSR-12
- Strict types enabled

---

## License

MIT © Labro Dev
