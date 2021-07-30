<?php

namespace Modules\UserAndPermission\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UniqueRule implements Rule
{
    private $value;
    private $message;
    private $field;
    private $table;
    private $otherField;
    private $otherFields;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $field, $value = 0, $otherField = 'id', $otherFields = [])
    {
        $this->table = $table;
        $this->value = $value;
        $this->message = 'passes';
        $this->field = $field;
        $this->otherField = $otherField;
        $this->otherFields = $otherFields;
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
        $columnNames = Schema::getColumnListing($this->table);
        $check = DB::table($this->table)
            ->where($this->field, $value);

        if (! empty($this->orderField) && $this->value != 0) {
            $check->where($this->orderField, '<>', $this->value);
        }

        if (array_search('deleted_at', $columnNames)) {
            $check->whereNull('deleted_at');
        }

        if (! empty($this->orderFields)) {
            foreach ($this->orderFields as $condition) {
                if (in_array($condition[0], $columnNames)) {
                    if ($condition[1] == 'null') {
                        $check->whereNull($condition[0]);
                        continue;
                    } elseif ($condition[1] == 'not_null') {
                        $check->whereNotNull($condition[0]);
                        continue;
                    }

                    $check->where($condition[0], $condition[1], $condition[2]);
                }
            }
        }

        $check = $check->count();

        if ($check > 0) {
            $this->message = __('userandpermission::validation.unique', ['attribute' => $attribute]);
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
