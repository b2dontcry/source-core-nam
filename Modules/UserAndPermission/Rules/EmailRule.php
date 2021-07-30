<?php

namespace Modules\UserAndPermission\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailRule implements Rule
{
    private $max;
    private $min;
    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max = 250, $min = 8)
    {
        $this->message = 'passes';
        $this->max = $max;
        $this->min = $min;
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
        if (! preg_match('/^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i', $value)) {
            $this->message = __('userandpermission::validation.email');
        } elseif (strlen($value) > $this->max) {
            $this->message = __('userandpermission::validation.max.string', ['attribute' => $attribute, 'max' => $this->max]);
        } elseif (strlen($value) < $this->min) {
            $this->message = __('userandpermission::validation.min.string', ['attribute' => $attribute, 'min' => $this->max]);
        }

        return ($this->message == 'passes');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
