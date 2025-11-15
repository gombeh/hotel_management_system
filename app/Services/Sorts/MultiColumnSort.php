<?php

namespace App\Services\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class MultiColumnSort implements Sort
{
    public function __construct(private array $columns, private ?string $relationName = null){}

    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $fieldsString = implode(", ", $this->columns);
        $direction = $descending ? 'DESC' : 'ASC';


        if($this->relationName){
            $relation = $query->getRelation($this->relationName);
            $subquery = $relation
                ->getQuery()
                ->selectRaw("CONCAT({$fieldsString})")
                ->whereColumn($relation->getQualifiedForeignKeyName(), $relation->getQualifiedOwnerKeyName());

            $query->orderBy($subquery, $direction);
        } else {
            $query->orderByRaw("CONCAT({$fieldsString}) $direction");
        }}
}
