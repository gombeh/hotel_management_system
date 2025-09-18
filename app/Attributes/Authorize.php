<?php

namespace App\Attributes;

use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Authorize
{
    public function __construct(string $ability, null|string|array $models = null)
    {
        Gate::authorize($ability, $this->getGateArguments(request(), $models));
    }

    /**
     * Get the arguments parameter for the gate.
     *
     * @param Request $request
     * @param string|array|null $models
     * @return array
     */
    protected function getGateArguments(Request $request, null|string|array $models): array
    {
        if (is_null($models)) {
            return [];
        }

        return collect($models)->map(function ($model) use ($request) {
            if ($this->isClassName($model)) {
                return trim($model);
            }

            return $request->route($model, null);
        })->all();
    }

    /**
     * Checks if the given string looks like a fully qualified class name.
     *
     * @param string $value
     * @return bool
     */
    protected function isClassName(string $value): bool
    {
        return str_contains($value, '\\');
    }
}
