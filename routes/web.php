<?php

use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\UserController;
use App\Models\Privilegio;
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

Route::post('/logout', [UserController::class, 'logout'])->name('usuario.logout');

Route::get('/backoffice', function () {
    $user = Auth::user();
    if ($user == NULL) {
        return redirect()->route('user.login')->withErrors(['message' => 'No existe una sesion activa.']);
    }
    $proyectos = Proyecto::all();
    return view('backoffice.dashboard', ['proyectos' => $proyectos]);
})->name('backoffice.dashboard');

Route::get('/backoffice/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
Route::get('/backoffice/proyectos/get/{_id}', [ProyectoController::class, 'getById']);
Route::post('/backoffice/proyectos/new', [ProyectoController::class, 'create'])->name('proyectos.create');
Route::post('/backoffice/proyectos/down/{_id}', [ProyectoController::class, 'disable'])->name('proyectos.disable');
Route::post('/backoffice/proyectos/up/{_id}', [ProyectoController::class, 'enable'])->name('proyectos.enable');
Route::post('/backoffice/proyectos/update/{_id}', [ProyectoController::class, 'update'])->name('proyectos.update');
Route::post('/backoffice/proyectos/delete/{_id}', [ProyectoController::class, 'delete'])->name('proyectos.delete');
