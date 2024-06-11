<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KnfEmailRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validate that the value is a @knf.stud.vu.lt email address
        if (!str_contains($value, '@knf.stud.vu.lt')) {
            $fail('The ' . $attribute . ' must be a @knf.stud.vu.lt email address.');
        }
    }
}
