<?php

use Labrodev\Translatable\Resolvers\DefaultLocaleResolver;

it('returns unique locales including fallback', function () {
    config()->set('app.locale', 'fr');
    config()->set('app.fallback_locale', 'de');

    $resolver = new DefaultLocaleResolver();
    expect($resolver->all())->toEqual(['fr', 'de']);
});