<?php

declare(strict_types=1);

namespace Modules\Applications\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Modules\Applications\Models\Applications;
use Modules\System\Forms\AbstractForm;
use Modules\System\Forms\Inputs\InputText;
use Modules\System\Forms\Inputs\InputTextarea;
use Modules\Users\Models\User;

class ApplicationUserForm extends AbstractForm
{
    /**
     * @var User Текущий авторизованный пользователь
     */
    public User $user;

    public Applications $applications;

    public function __construct()
    {
        $user = \Auth::user();
        if ($user) {
            $this->user = $user;
        }
        $this->applications = (new Applications());
    }

    /**
     * @inheritDoc
     */
    public function form(): AbstractForm
    {
        $this->form = [
            /**
             * Основные поля
             */
            'name'    => (new InputText())
                ->setLabel('Название')
                ->setValidationRule('required')
                ->setNameAndId('name')
                ->get(),
            'email'   => (new InputText())
                ->setLabel('Email')
                ->setValidationRule('required')
                ->setNameAndId('email')
                ->get(),
            'message' => (new InputTextarea())
                ->setLabel('Сообщение')
                ->setValidationRule('required')
                ->setNameAndId('message')
                ->get(),
        ];
        return $this;
    }

    public function collectValidationRules(mixed $form): void
    {
        foreach ($form as $key => $item) {
            if (! is_array($item)) {
                continue;
            }
            if (Arr::has($item, ['validation_rule', 'id', 'name'])) {
                if (! empty($item['validation_rule'])) {
                    $this->validation_rules[$key] = explode("|", $item['validation_rule']);
                }
            } else {
                $this->collectValidationRules($item);
            }
        }
    }

    /**
     * Метод собирает значения полей из запроса
     *
     * @return array
     */
    public function getFieldsFromRequest(): array
    {
        $this->getFieldsNames($this->form);

        /** @var Request $request */
        $request = app(Request::class);

        $fields_completed = [];

        $fields = $this->getFieldsDefinition();
        // Собираем поля из запроса
        foreach ($fields as $field => $path) {
            if (array_key_exists($path, $this->completed_fields)) {
                $fields_completed[$field] = $request->input($path)['value'];
            }
        }

        return $fields_completed;
    }

    public function getFieldsDefinition()
    {
        return config('applications.fields');
    }

    public function validationAttributes()
    {
        return config('applications.attr');
    }

    /**
     * Выполняем валидацию данных формы
     */
    public function validate($rules)
    {
        $validator = Validator::make(
            data:       $this->getFieldsFromRequest(),
            rules:      $rules,
            attributes: $this->validationAttributes()
        );
        $validator->validated();
    }
}
