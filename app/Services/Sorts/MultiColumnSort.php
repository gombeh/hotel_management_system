<?php

namespace App\Services\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class MultiColumnSort implements Sort
{
    public function __construct(private array $columns){}

    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $fieldsString = implode(", ", $this->columns);
        $direction = $descending ? 'DESC' : 'ASC';
        $query->orderByRaw("CONCAT({$fieldsString}) $direction");
    }
}
