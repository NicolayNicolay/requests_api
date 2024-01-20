<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Applications\Controllers\ApplicationsController;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\RegisterController;

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');
    // Административная часть сайта
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/register', [RegisterController::class, 'store'])->name('admin.register.submit');
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');
        Route::group(['prefix' => 'requests'], function () {
            Route::get('/', [ApplicationsController::class, 'index'])->name('requests.index');
            Route::post('/', [ApplicationsController::class, 'storeUser'])->name('requests.storeUser');
            Route::put('/{id?}', [ApplicationsController::class, 'store'])->name('requests.store');
            Route::get('/remove/{id?}', [ApplicationsController::class, 'destroy'])->name('requests.remove');
            Route::get('/getUserForm', [ApplicationsController::class, 'getUserForm'])->name('requests.getUserForm');
            Route::get('/getModerateForm/{id?}', [ApplicationsController::class, 'getModerateForm'])->name('requests.getModerateForm');
        });
    });
});

Route::get('/{any}', fn() => view('spa'))
    ->where('any', '.*')
    ->name('spa');
