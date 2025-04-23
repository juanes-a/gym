<?php

use App\Http\Controllers\ClaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas generales
Route::group(['namespace' => 'App\Http\Controllers'], function() {
    /**
     * Home Routes
     */
    Route::get('/', 'WelcomeController@show')->name('welcome.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Login Routes
         */
        Route::get('/login', function() {
            // Si el usuario ya está autenticado, redirige a su página correspondiente
            if (Auth::check()) {
                if (Auth::guard('trainer')->check()) {
                    return redirect()->route('trainer.index');
                } elseif (Auth::guard('user')->check()) {
                    return redirect()->route('user.index');
                }
            }

            return view('auth.login');
        })->name('login.show');

        Route::post('/login', 'LoginController@login')->name('login.perform');

        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');
    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});

// Rutas para el rol de "trainer" (entrenador)
Route::middleware(['auth:trainer'])->group(function () {
    Route::get('/trainer', [TrainerController::class, 'index'])->name('trainer.index');

    Route::get('/class', [ClaseController::class, 'index']);
    Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');

    Route::get('clase/{id}/edit/{trainer_id}', [ClaseController::class, 'edit'])->name('clase.edit');
    Route::put('/clase/{id}', [ClaseController::class, 'update'])->name('clase.update');

    Route::delete('/clase/{clase}', [ClaseController::class, 'destroy'])->name('clase.destroy');
});

// Rutas para el rol de "user" (usuario)
Route::middleware('auth:web')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');

    Route::get('/classes', [UserController::class, 'index'])->name('user.classes');
    Route::get('/classes/{class}', [UserController::class, 'show'])->name('user.classes.show');
    Route::post('/bookings/handle', [UserController::class, 'handleBooking'])->name('user.bookings.handle');
});
