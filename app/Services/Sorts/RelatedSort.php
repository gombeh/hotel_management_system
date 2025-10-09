<?php

namespace App\Services\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class RelatedSort implements Sort
{
    public function __construct(){}

    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        [$relationName, $columnName] = explode(".", $property);

        $relation = $query->getRelation($relationName);

        $subquery = $relation
            ->getQuery()
            ->select($columnName)
            ->whereColumn($relation->getQualifiedForeignKeyName(), $relation->getQualifiedOwnerKeyName());

        $query->orderBy($subquery, $descending ? "desc" : "asc");
    }
}
