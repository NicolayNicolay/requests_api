<?php

declare(strict_types=1);

namespace Modules\Applications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\Applications\Forms\ApplicationUserForm;
use Modules\Applications\Models\Applications;
use Modules\Projects\Forms\ProjectForm;
use Modules\Projects\Models\Projects;
use Modules\Projects\Resources\ProjectResource;
use Modules\Tasks\Forms\TasksForm;

class ApplicationsController extends Controller
{
    private Applications $applications;

    private int $application_id = 0;

    /** @var ApplicationUserForm */
    public ApplicationUserForm $user_form;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Applications $applications)
    {
        $route = Route::current();
        $request_id = $request->input('id');
        if ($route !== null && ! empty($route->parameters['id'])) {
            $this->application_id = (int) $route->parameters['id'];
        } elseif (! empty($request_id)) {
            $this->application_id = (int) $request_id;
        }
        // Создаем объект формы
        $this->middleware(
            function ($request, $next) {
                $this->user_form = (new ApplicationUserForm());
                return $next($request);
            }
        );
        $this->applications = $applications;
    }

    public function index(Request $request)
    {
        $per_page = config('app.per_page');
        return $this->applications->paginate($per_page);
    }

    /**
     * Валидация полей и сохранение объекта
     *
     * @return bool
     */
    public function storeUser(): bool
    {
        // Получаем правила валидации из формы
        $this->user_form->form();
        $validation_rules = $this->user_form->getValidationRules();
        $this->user_form->validate($validation_rules);
        // Получаем заполненные поля из запроса
        $fields = $this->user_form->getFieldsFromRequest();
        // Создаем новый объект
        $this->applications->create($fields);
        return true;
    }

    /**
     * Удаление проекта.
     *
     */
    public function destroy(): void
    {
        $unit = $this->applications->find($this->application_id);
        $unit?->delete();
    }

    /**
     * Получение параметров формы
     *
     * @return array
     */
    public function getUserForm(): array
    {
        return $this->user_form->form()->getArray();
    }
}
