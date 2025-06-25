<?php

use Labrodev\Translatable\Utilities\QueryFieldLocalizer;

it('appends the current locale to the JSON field', function () {
    // Force the app locale in Testbench
    app()->setLocale('es');
    expect(QueryFieldLocalizer::translatableField('title'))
        ->toBe("title->es");

    app()->setLocale('en_US');
    expect(QueryFieldLocalizer::translatableField('description'))
        ->toBe("description->en_US");
});