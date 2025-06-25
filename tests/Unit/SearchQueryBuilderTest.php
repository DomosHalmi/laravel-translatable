<?php

namespace Tests\Unit;

use Mockery;
use Illuminate\Database\Eloquent\Builder;
use Labrodev\Translatable\Traits\SearchQueryBuilder;
use Labrodev\Translatable\Contracts\LocaleResolver;

class TestableSearchModel
{
    use SearchQueryBuilder;

    public function callSearchField(Builder $query, string $value, string $property): Builder
    {
        return $this->searchField($query, $value, $property);
    }

    public function callSearchFieldOr(Builder $query, string $value, string $property): Builder
    {
        return $this->searchFieldOr($query, $value, $property);
    }
}

beforeEach(function () {
    // Bind a fake resolver so fetchLocales() returns ['en','es']
    $this->app->instance(LocaleResolver::class, new class implements LocaleResolver {
        public function all(): array
        {
            return ['en', 'es'];
        }
    });
});

afterEach(function () {
    Mockery::close();
});

it('wraps all locales in a single WHERE(...) with LOWER(...)->LIKE placeholders', function () {
    $builder = Mockery::mock(Builder::class);
    $inner   = Mockery::mock(Builder::class);

    // Expect ->where(Closure) once
    $builder
        ->shouldReceive('where')
        ->once()
        ->with(Mockery::on(function ($closure) use (&$captured) {
            $captured = $closure;
            return is_callable($closure);
        }))
        ->andReturn($builder);

    // Inside closure: two orWhereRaw calls, one per locale
    $inner
        ->shouldReceive('orWhereRaw')
        ->once()
        ->with("LOWER(names->>'en') LIKE ?", ['%foo%'])
        ->andReturnSelf();
    $inner
        ->shouldReceive('orWhereRaw')
        ->once()
        ->with("LOWER(names->>'es') LIKE ?", ['%foo%'])
        ->andReturnSelf();

    $model    = new TestableSearchModel;
    $returned = $model->callSearchField($builder, 'Foo', 'names');

    // Invoke the captured closure against our “inner” mock
    $captured($inner);

    expect($returned)->toBe($builder);
});

it('wraps all locales in an OR WHERE(...) when using the orWhere variant', function () {
    $builder = Mockery::mock(Builder::class);
    $inner   = Mockery::mock(Builder::class);

    // Expect ->orWhere(Closure) once
    $builder
        ->shouldReceive('orWhere')
        ->once()
        ->with(Mockery::on(function ($closure) use (&$captured) {
            $captured = $closure;
            return is_callable($closure);
        }))
        ->andReturn($builder);

    // Inside closure: two orWhereRaw calls again
    $inner
        ->shouldReceive('orWhereRaw')
        ->once()
        ->with("LOWER(names->>'en') LIKE ?", ['%bar%'])
        ->andReturnSelf();
    $inner
        ->shouldReceive('orWhereRaw')
        ->once()
        ->with("LOWER(names->>'es') LIKE ?", ['%bar%'])
        ->andReturnSelf();

    $model    = new TestableSearchModel;
    $returned = $model->callSearchFieldOr($builder, 'Bar', 'names');

    $captured($inner);

    expect($returned)->toBe($builder);
});