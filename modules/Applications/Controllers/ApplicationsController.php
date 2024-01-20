<?php

declare(strict_types=1);

namespace Modules\Applications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\Applications\Forms\ApplicationModerateForm;
use Modules\Applications\Forms\ApplicationUserForm;
use Modules\Applications\Models\Applications;
use Modules\Applications\Services\ApplicationService;
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
    public ApplicationModerateForm $moderate_form;

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
                $this->moderate_form = (new ApplicationModerateForm($this->application_id));
                return $next($request);
            }
        );
        $this->applications = $applications;
    }

    public function index(Request $request)
    {
        $per_page = config('app.per_page');
        return $this->applications->filter($request->all())->paginate($per_page);
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

    public function store(ApplicationService $service): bool
    {
        // Получаем правила валидации из формы
        $this->moderate_form->form();
        $validation_rules = $this->moderate_form->getValidationRules();
        $this->moderate_form->validate($validation_rules);
        // Получаем заполненные поля из запроса
        $fields = $this->moderate_form->getFieldsFromRequest();
        if ($this->application_id) {
            // Обновляем объект если во входящих параметрах есть идентификатор
            $project = $this->applications->find($this->application_id);
            $project->update($fields);
        }
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

    public function getModerateForm(): array
    {
        return $this->moderate_form->form()->getArray();
    }
}
