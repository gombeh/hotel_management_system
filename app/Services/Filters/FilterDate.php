<?php

namespace App\Services\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterDate implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if(is_string($value)) {
            $query->whereDate($property, Carbon::createOrNow($value, 'Y-m-d\TH:i:s.v\Z'));
        }else if(is_array($value) && count($value) > 0) {
            if(!isset($value[1]) || $value[1] == null) {
                $query->whereDate($property, '>=', Carbon::createOrNow($value[0], 'Y-m-d\TH:i:s.v\Z'));
            }else {
                $query->whereDate($property, '>=', Carbon::createOrNow($value[0], 'Y-m-d\TH:i:s.v\Z'))
                    ->whereDate($property, '<=', Carbon::createOrNow($value[1], 'Y-m-d\TH:i:s.v\Z'));
            }
        }

    }
}
