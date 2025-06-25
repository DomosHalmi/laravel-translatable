<?php

declare(strict_types=1);

namespace Labrodev\Translatable\Utilities;

class QueryFieldLocalizer
{
    /**
     * @param string $field
     * @return string
     */
    public static function translatableField(string $field): string
    {
        $locale = app()->getLocale();

        return sprintf('%s->%s', $field, $locale);
    }
}
