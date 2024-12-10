<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password as RulesPassword;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password, 'confirmed', RulesPassword::min(8)->letters()->numbers()];
    }
}
