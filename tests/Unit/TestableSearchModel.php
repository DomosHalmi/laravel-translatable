<?php

use Illuminate\Database\Eloquent\Builder;
use Labrodev\Translatable\Base\Traits\SearchQueryBuilder;
use Illuminate\Database\Eloquent\Model;

class TestableSearchModel extends Model
{
    use SearchQueryBuilder;

    protected $table = 'dummy_models';
    protected $guarded = [];
    protected $casts = [ 'names' => 'array' ];

    /** Public wrappers around the protected trait methods */
    public function publicSearchField(Builder $q, string $value, string $property): Builder
    {
        return $this->searchField($q, $value, $property);
    }

    public function publicSearchFieldOr(Builder $q, string $value, string $property): Builder
    {
        return $this->searchFieldOr($q, $value, $property);
    }
}