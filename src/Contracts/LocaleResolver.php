<?php

declare(strict_types=1);

namespace Labrodev\Translatable\Contracts;

interface LocaleResolver
{
    /**
     * @return string[] List of supported locale codes like ['en', 'ua', 'uk']
     */
    public function all(): array;
}