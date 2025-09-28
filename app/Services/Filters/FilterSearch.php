<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterSearch implements Filter
{
    public function __construct(private array $columns){}

    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where(function($q) use ($value) {
            foreach ($this->columns as $column) {
                $q->orWhere($column, 'like', "%{$value}%");
            }
        });
    }
}
