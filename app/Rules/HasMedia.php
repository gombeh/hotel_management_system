<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class HasMedia implements ValidationRule
{
    public function __construct(private Model $model, private String $collection = 'default'){}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!empty($value)) return;

        $hasMedia = $this->model->hasMedia($this->collection);

        if(!$hasMedia){
            $fail("The {$attribute} must have at least one Media");
        }
    }
}
