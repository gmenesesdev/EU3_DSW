<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function formularioLogin()
    {
        if (Auth::check()) {
            return redirect()->route('backoffice.dashboard');
        }
        return view('user.login');
    }

    public function formularioNuevo()
    {
        if (Auth::check()) {
            return redirect()->route('backoffice.dashboard');
        }
        return view('user.register');
    }

    public function login(Request $_request)
    {

        $mensajes = [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es valido.',
            'password.required' => 'La contraseña es obligatoria.'
        ];

        $_request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], $mensajes);

        $credenciales = $_request->only('email', 'password');

        if (Auth::attempt($credenciales)) {
            //verifica usuario activo 
            $user = Auth::user();
            if (!$user->activo) {
                Auth::logout();
                return redirect()->route('user.login')->withErrors(['email' => 'El usuario no se encuentra activo.']);
            }
            //autenticacion exitosa
            $_request->session()->regenerate();
            return redirect()->route('backoffice.dashboard');
        }
        return redirect()->back()->withErrors(['email' => 'El usuario o contraseña son incorrectos.']);
    }

    public function registrar(Request $_request)
    {
        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es valido.',
            'password.required' => 'La contraseña es obligatoria.',
            'rePassword.required' => 'La confirmacion de la contraseña es obligatoria.',
            'dayCode.required' => 'El Código del dia es obligatorio.'
        ];

        $_request->validate([
            'nombre' => 'required|string|max:50',
            'email' => 'required|email',
            'password' => 'required|string',
            'rePassword' => 'required|string',
            'dayCode' => 'required|string'
        ], $mensajes);

        $datos = $_request->only('nombre', 'email', 'password', 'rePassword', 'dayCode');

        if ($datos['password'] != $datos['rePassword']) {
            return back()->withErrors(['message' => 'Las contraseñas no coinciden.']);
        }

        if ($datos['dayCode'] != date("d")) {
            return back()->withErrors(['message' => 'El Código del dia es incorrecto.']);
        }

        try {
            User::create([
                'nombre' => $datos['nombre'],
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']),
            ]);
            return redirect()->route('user.login')->with('success', 'Usuario registrado exitosamente.');
        } catch (QueryException $e) {
            // echo 'No registra usuario ' . $e->getMessage() . ' - Code: ' . $e->getCode();
            if ($e->getCode() == 23000) {
                return back()->withErrors(['message' => 'El email ya se encuentra registrado.']);
            }
            return back()->withErrors(['message' => 'Error al registrar el usuario.' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
