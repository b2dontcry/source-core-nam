<?php

namespace Modules\UserAndPermission\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    private $max;
    private $mix;
    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max = 10, $min = 8)
    {
        $this->max = $max;
        $this->min = $min;
        $this->message = 'passes';
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
        if (! preg_match('/^[0-9]{8,20}$/', $value)) {
            $this->message = __('userandpermission::validation.digits', ['attribute' => $attribute]);
        } elseif (strlen($value) > $this->max) {
            $this->message = __('userandpermission::validation.phone_max', ['attribute' => $attribute, 'max' => $this->max]);
        } elseif (strlen($value) < $this->min) {
            $this->message = __('userandpermission::validation.phone_min', ['attribute' => $attribute, 'min' => $this->min]);
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
