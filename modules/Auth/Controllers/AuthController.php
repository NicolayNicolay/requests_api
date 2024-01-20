<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\Response | array
    {
        $credentials = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if (Auth::attempt($credentials, (bool) $request->input('remember'))) {
            $request->session()->regenerate();
            return ['id' => Auth::user()->id];
        } else {
            return Response::make(['message' => 'Пользователь не найден!'], 401);
        }
    }

    /**
     * Show the application logout.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function logout(): Redirector | RedirectResponse | Application
    {
        auth()->logout();
        return redirect('/');
    }

    public function getCurrentAuth(): ?array
    {
        $user = Auth::user();
        if ($user) {
            return [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'admin' => $user->hasRole('admin'),
            ];
        }
        return null;
    }
}
