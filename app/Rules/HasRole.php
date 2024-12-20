<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class HasRole implements Rule
{
    private $role;

    /**
     * Create a new rule instance.
     *
     * @param  string  $role
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::find($value);

        return $user && $user->hasRole($this->role);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The selected user does not have the '{$this->role}' role.";
    }
}
