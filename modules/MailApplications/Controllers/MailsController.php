<?php

declare(strict_types=1);

namespace Modules\MailApplications\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Modules\MailApplications\Forms\MailForm;
use Modules\MailApplications\Models\MailApplication;

class MailsController extends Controller
{
    private MailApplication $mails;

    private int $application_id = 0;

    /** @var MailForm */
    public MailForm $form;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, MailApplication $mails)
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
                $this->form = (new MailForm($this->application_id));
                return $next($request);
            }
        );
        $this->mails = $mails;
    }

    /**
     * Валидация полей и сохранение объекта
     *
     * @return bool
     */
    public function store(): bool
    {
        // Получаем правила валидации из формы
        $this->form->form();
        $validation_rules = $this->form->getValidationRules();
        $this->form->validate($validation_rules);
        // Получаем заполненные поля из запроса
        $fields = $this->form->getFieldsFromRequest();
        // Создаем новый объект
        $mail = $this->mails->create($fields);
        Mail::to($mail->application_mail)->send(new SendMail($mail->text));
        return true;
    }
}
