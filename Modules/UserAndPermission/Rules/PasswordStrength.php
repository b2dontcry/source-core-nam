<?php

namespace Modules\UserAndPermission\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordStrength implements Rule
{
    protected $minLength = 8;
    protected $maxLength = 32;
    protected $requireUppercase = true;
    protected $requireNumeric = true;
    protected $requireSpecialCharacter = true;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $config = [])
    {
        if (! empty($config)) {
            foreach ($config as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
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
        $pattern = "(?=.*[a-z])";

        if ($this->requireUppercase) {
            $pattern .= "(?=.*[A-Z])";
        }

        if ($this->requireSpecialCharacter) {
            $pattern .= '(?=.*[!@#\$%\^&\*])';
        }

        if ($this->requireNumeric) {
            $pattern .= "(?=.*[0-9])";
        }

        $pattern .= '.{'.$this->minLength.','.$this->maxLength.'}';
        $pattern_regex = "/^{$pattern}$/";

        // /^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?=.*[0-9]).{8,32}$/
        if (preg_match($pattern_regex, $value)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The password must include letters, capital letters, numbers, special characters and a minimum of 8 characters.');
    }
}
