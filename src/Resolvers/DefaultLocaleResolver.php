<?php

declare(strict_types=1);

namespace Labrodev\Translatable\Resolvers;

use Labrodev\Translatable\Contracts\LocaleResolver;

/**
 * Provides a basic implementation of the LocaleResolver interface
 * that retrieves the current and fallback locales defined in the Laravel configuration.
 *
 * This resolver is intended as a default fallback for applications that do not implement
 * a custom locale source (e.g. database, config array, or lang folders).
 * It returns a unique array containing:
 * - The default application locale (config('app.locale'))
 * - The fallback locale (config('app.fallback_locale')), if different
 */
class DefaultLocaleResolver implements LocaleResolver
{
    /**
     * Returns a list of available locales.
     *
     * @return array<int,mixed> An array containing at least the default locale,
     * and the fallback locale if it's different.
     */
    public function all(): array
    {
        return array_unique([
            config('app.locale'),
            config('app.fallback_locale'),
        ]);
    }
}
