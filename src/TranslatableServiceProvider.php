<?php

declare(strict_types=1);

namespace Labrodev\Translatable;

use Labrodev\Translatable\Contracts\LocaleResolver;
use Labrodev\Translatable\Resolvers\DefaultLocaleResolver;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * The service provider for the Labrodev Translatable package.
 *
 * Registers package configuration and binds the default implementation of the LocaleResolver contract.
 * This provider uses Spatie's LaravelPackageTools to streamline setup and allow easy extensibility.
 *
 * The default LocaleResolver returns the current app locale and fallback locale from configuration.
 * Consumers of the package may override this binding with their own resolver implementation.
 */
class TranslatableServiceProvider extends PackageServiceProvider
{
    private const string PACKAGE_NAME = 'laravel-translatable';

    /**
     * Configures the package metadata.
     *
     * This method is called by LaravelPackageTools and sets the name of the package.
     * It can be extended to include configuration files, views, migrations, etc.
     *
     * @param Package $package The package definition object.
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package->name(self::PACKAGE_NAME);
    }

    /**
     * Registers bindings in the container before the package is fully booted.
     *
     * Specifically, this binds the LocaleResolver contract to the default implementation.
     * Applications using the package can override this binding as needed.
     *
     * @return void
     */
    public function registeringPackage(): void
    {
        $this->app->bind(LocaleResolver::class, DefaultLocaleResolver::class);
    }
}
