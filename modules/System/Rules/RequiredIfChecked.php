<?php

declare(strict_types=1);

namespace Modules\System\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class RequiredIfNotChecked
 * Валидатор для проверки полей в зависимости от установленного чекбокса или чего-либо другого с пустым значением или строкой false
 *
 * @package App\Rules
 */
class RequiredIfChecked implements Rule
{
    protected string $field_name = '';
    protected Request $request;

    public function __construct(string $field_name)
    {
        $this->field_name = $field_name;
        $this->request = app(Request::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $check_value = $this->request->input($this->field_name);
        return (
            (empty($check_value))
            || (! empty($value))
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Поле ":attribute" обязательно для заполнения';
    }
}
