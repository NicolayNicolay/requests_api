<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Forms\GuestUserForm;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;

class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = '/admin';
    private Request $request;

    private User $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return Validator
     */
    protected function validator(array $data): Validator
    {
        return Validator::make(
            $data,
            [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]
        );
    }

    /**
     * Создаем пользователя
     *
     * @param Request $request
     * @return true
     * @throws ValidationException
     */
    public function store(Request $request): bool
    {
        $form = (new GuestUserForm())->form();
        // Выполняем валидацию полей
        $validation_rules = $form->getValidationRules();
        $this->validate($request, $validation_rules, config('registration.messages'));

        // Получаем данные формы
        $fields = $form->getFieldsFromRequest();
        // Создаем нового пользователя
        $fields['password'] = Hash::make($fields['password']);
        $user = $this->user->create($fields);
        if ($user) {
            $role = Role::where('name', 'user')->first();
            $user->addRole($role);
            auth()->login($user, $request->get('remember'));
        }
        return true;
    }
}
