<?php

declare(strict_types=1);

namespace Modules\Auth\Forms;

use Illuminate\Validation\Rules\Password;
use Modules\System\Forms\AbstractForm;
use Modules\System\Forms\Inputs\InputText;

/**
 * Class GuestUserForm
 */
class GuestUserForm extends AbstractForm
{
    /**
     * Метод собирает массив формы для создания/редактирования пользователя
     * @return AbstractForm
     */
    public function form(): AbstractForm
    {
        $this->form = [
            'name'    => (new InputText())
                ->setLabel('ФИО')
                ->setValidationRule('required')
                ->setRequired(true)
                ->setNameAndId('name')
                ->get(),
            'email'    => (new InputText())
                ->setLabel('E-mail')
                ->setValidationRule('required|email|unique:users,email')
                ->setRequired(true)
                ->setNameAndId('email')
                ->get(),
            'password' => (new InputText())
                ->setLabel('Пароль')
                ->setValidationRule(['required', Password::min(6)])
                ->setRequired(true)
                ->setNameAndId('password')
                ->get(),
        ];

        return $this;
    }
}
