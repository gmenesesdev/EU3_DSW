<?php

use App\Http\Controllers\UserController;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('backoffice.dashboard');
});

Route::get('/login', [UserController::class, 'formularioLogin'])->name('user.login');
Route::post('/login', [UserController::class, 'login'])->name('user.validar');

Route::get('/users/register', [UserController::class, 'formularioNuevo'])->name('user.registrar');
Route::post('/users/register', [UserController::class, 'registrar'])->name('user.registrar');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/backoffice', function () {
    $user = Auth::user();
    if ($user == NULL) {
        return redirect()->route('user.login')->withErrors(['message' => 'No existe una sesion activa.']);
    }
    $proyectos = Proyecto::all();
    return view('backoffice.dashboard', ['proyectos' => $proyectos]);
})->name('backoffice.dashboard');

// Route::get('/backoffice/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
// Route::post('/backoffice/proyectos/new', [ProyectoController::class, 'create'])->name('proyectos.create');