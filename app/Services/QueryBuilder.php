<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class QueryBuilder
{
    private Builder $builder;
    private int $limit;

    public static function from(string $model): self
    {
        $queryBuilder = new self();
        $model = new $model;
        $queryBuilder->builder = $model->query();
        return $queryBuilder;
    }

    public function mixedFilter(string $key, array $fields): self
    {
        $this->builder->when(request()->input($key), function ($query, $data) use ($fields) {
            $query->where(function (Builder $query) use ($fields, $data) {
                collect($fields)->each(function ($field, $i) use (&$query, $data) {
                    $clause = $i == 0 ? "where" : "orWhere";
                    $query->{$clause}($field, 'like', "%{$data}%");
                });
            });
        });

        return $this;
    }

    public function sortFields(array $fields): self
    {
        $sorts = request()->input('sorts', []);
        collect($sorts)->each(function ($sort, $field) use ($fields) {
            if (!in_array($field, array_keys($fields))) return;

            $sort = $sort == 'asc' ? "asc" : "desc";

            $columns = $fields[$field] ?? null;
            if (is_array($columns)) {
                $fieldsString = implode(", ", $columns);
                $this->builder->orderByRaw("CONCAT({$fieldsString}) $sort");
            } else {
                $this->builder->orderBy($field, $sort);
            }

        });
        return $this;
    }

    public function hasLimitRecord(): self
    {
        $limit = (int)request()->get('limit', config('app.per_page'));

        $this->limit = max(min($limit, 100), 1);

        $this->builder->limit($this->limit);

        return $this;
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    public function latest(): self
    {
        $this->builder->latest();

        return $this;
    }

    public function with($relations, $callback = null): self
    {
        $callback
            ? $this->builder->with($relations, $callback)
            : $this->builder->with($relations);
        return $this;
    }

    public function get(array $columns = ['*']): Collection
    {
        return $this->builder->get($columns);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? $this->limit ?? config('app.per_page');
        return $this->builder->paginate($perPage, $columns, $pageName, $page, $total);
    }
}
