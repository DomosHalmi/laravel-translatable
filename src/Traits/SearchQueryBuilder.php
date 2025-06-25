<?php

declare(strict_types=1);

namespace Labrodev\Translatable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Labrodev\Translatable\Contracts\LocaleResolver;

/**
 * Enhances Eloquent query builders with the ability to perform multilingual searches.
 *
 * This trait allows for searching within JSON columns that store values in multiple locales,
 * using a case-insensitive search pattern. It is designed to work with databases that
 * support JSON column operations and is particularly useful for applications requiring
 * internationalization support.
 */
trait SearchQueryBuilder
{
    /**
     * Applies a case-insensitive search condition for multilingual fields using a "where" clause.
     *
     * This method constructs a query that searches across all specified locales for a given value
     * within a JSON column.
     *
     * @param Builder $query The query builder instance.
     * @param string $value The search value.
     * @param string $property The JSON column name containing translatable fields.
     * @return Builder The modified query builder instance with applied search conditions.
     */
    protected function searchField(
        Builder $query,
        string $value,
        string $property
    ): Builder {

        $locales = $this->fetchLocales();

        $value = mb_strtolower($value);

        return $query->where(function ($query) use ($locales, $value, $property) {
            foreach ($locales as $locale) {
                $query->orWhereRaw("LOWER($property->>'$locale') LIKE ?", ["%$value%"]);
            }
        });
    }

    /**
     * Applies a case-insensitive search condition for multilingual fields using a "orWhere" clause.
     *
     * This method constructs a query that searches across all specified locales for a given value
     * within a JSON column.
     *
     * @param Builder $query The query builder instance.
     * @param string $value The search value.
     * @param string $property The JSON column name containing translatable fields.
     * @return Builder The modified query builder instance with applied search conditions.
     */
    protected function searchFieldOr(
        Builder $query,
        string $value,
        string $property
    ): Builder {

        $locales = $this->fetchLocales();

        $value = mb_strtolower($value);

        return $query->orWhere(function ($query) use ($locales, $value, $property) {
            foreach ($locales as $locale) {
                $query->orWhereRaw("LOWER($property->>'$locale') LIKE ?", ["%$value%"]);
            }
        });
    }

    /**
     * @return array
     */
    private function fetchLocales(): array
    {
        return app(LocaleResolver::class)
            ->all();
    }
}
