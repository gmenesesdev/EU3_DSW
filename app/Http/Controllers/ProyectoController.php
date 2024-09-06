<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    //
    public function index()
    {
        $datos = Proyecto::select('id', 'nombre', 'monto')->get();

        if ($datos->isEmpty()) {
            return redirect()->route('backoffice.dashboard')->withErrors(['message' => 'No hay proyectos disponibles.']);
        }

        return view('backoffice.dashboard', [
            'datos' => $datos,
        ]);
    }

    public function getById($id) {}

    public function create(Request $_request)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors('messsage', 'No existe una sesión activa.');
        }
        // Validar la solicitud
        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'El nombre del proyecto ya existe.',
        ];
        $_request->validate([
            'nombre' => 'required|string|max:255',
        ], $mensajes);

        try {
            //Insertar el registro en la BDD
            Proyecto::create([
                'nombre' => $_request->nombre,
                'fecha_inicio' => $_request->fecha_inicio,
                'responsable' => $_request->responsable,
                'monto' => $_request->monto,
                'user_id' => $user->id,
                'activo' => true,
            ]);
            return redirect()->back()->with('success', 'Proyecto creado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el proyecto: ' . $e->getMessage());
        }
    }

    public function enable($id) {}

    public function disable($id) {}

    public function delete() {}

    public function update() {}
}
