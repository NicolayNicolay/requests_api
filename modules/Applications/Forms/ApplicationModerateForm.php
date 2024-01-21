<?php

declare(strict_types=1);

namespace Modules\Applications\Forms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Modules\Applications\Models\Applications;
use Modules\Applications\Services\ApplicationService;
use Modules\Enums\StatusEnum;
use Modules\System\Forms\AbstractForm;
use Modules\System\Forms\Inputs\InputCheckbox;
use Modules\System\Forms\Inputs\InputText;
use Modules\System\Forms\Inputs\InputTextarea;
use Modules\System\Rules\RequiredIfChecked;
use Modules\Users\Models\User;

class ApplicationModerateForm extends AbstractForm
{
    /**
     * @var ?User Текущий авторизованный пользователь
     */
    public ?User $user = null;

    public Applications $applications;

    public function __construct(int $entity_id = 0)
    {
        $this->entity_id = $entity_id;
        $user = \Auth::user();
        if ($user) {
            $this->user = $user;
        }
        $this->applications = (new Applications());
        $this->getEntity();
    }

    protected function getEntity(): void
    {
        $this->entity_data = $this->applications->find($this->entity_id);
    }

    /**
     * @inheritDoc
     */
    public function form(): AbstractForm
    {
        $this->form = [
            'id'       => $this->entity_id,
            /**
             * Основные поля
             */
            'name'     => (new InputText())
                ->setLabel('ФИО')
                ->setValidationRule('required')
                ->setNameAndId('name')
                ->setDisabled(true)
                ->setValue($this->getFieldValue('name'))
                ->get(),
            'email'    => (new InputText())
                ->setLabel('Email')
                ->setValidationRule('required|email')
                ->setNameAndId('email')
                ->setDisabled(true)
                ->setValue($this->getFieldValue('email'))
                ->get(),
            'message'  => (new InputTextarea())
                ->setLabel('Сообщение')
                ->setValidationRule('required|max:1200')
                ->setNameAndId('message')
                ->setDisabled(true)
                ->setValue($this->getFieldValue('message'))
                ->get(),
            'comment'  => (new InputTextarea())
                ->setLabel('Ответ ответственного лица')
                ->setValidationRule([new RequiredIfChecked('moderate.value')])
                ->setNameAndId('comment')
                ->setValue($this->getFieldValue('comment'))
                ->get(),
            'moderate' => (new InputCheckbox())
                ->setLabel('Модерация')
                ->setNameAndId('moderate')
                ->setValue(ApplicationService::getStatusValue($this->getFieldValue('status')))
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
                    $this->validation_rules[$key] = $item['validation_rule'];
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
        if (array_key_exists('moderate', $fields_completed)) {
            $fields_completed['status'] = ApplicationService::getDbStatusValue($fields_completed['moderate']);
        }
        $fields_completed['user_id'] = $fields_completed['status'] === StatusEnum::Resolved ? $this->user ? $this->user->id : 1 : null;
        $fields_completed['updated_at'] = $fields_completed['status'] === StatusEnum::Resolved ? Carbon::now()->timezone('Europe/Moscow')->format('Y-m-d H:i:s') : null;
        return $fields_completed;
    }

    public function getFieldsDefinition()
    {
        return config('applications.fields_moderate');
    }

    public function validationAttributes()
    {
        return config('applications.attr_moderate');
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
