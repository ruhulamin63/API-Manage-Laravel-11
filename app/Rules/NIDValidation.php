<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NIDValidation implements ValidationRule
{
    protected $length;

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        // Define validation for nid
        $this->length = strlen($value);

        if (!$this->length === 10 || !$this->length === 13 || !$this->length === 17) {
            $fail("The $attribute must be 10, 13, or 17 characters.");
        }
    }
}
