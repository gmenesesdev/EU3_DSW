<?php

namespace App\Http\Controllers;

use App\Models\Privilegio;
use App\Models\Proyecto;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    private const SINGULAR_MIN = 'proyecto';
    private const SINGULAR_MAY = 'Proyecto';
    private const PLURAL_MIN = 'proyectos';
    private const PLURAL_MAY = 'Proyectos';

    private $properties = [
        'title' => [
            'genero' => 'm',
            'name' =>  self::SINGULAR_MAY,
            'singular' => self::SINGULAR_MAY,
            'plural' => self::PLURAL_MAY,
        ],
        'view' => [
            'index' => 'backoffice.mantenedor.' . self::SINGULAR_MIN
        ],
        'actions' => [
            'new' => '/backoffice/' . self::PLURAL_MIN . '/new',
        ],
        'routes' => [
            'index' => self::PLURAL_MIN . '.index'
        ],
        'fields' => [
            [
                'id' => 1,
                'name' => 'nombre',
                'label' => 'Nombre',
                'control' => 'input',
                'type' => 'text',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true
            ],
            [
                'id' => 2,
                'name' => 'descripcion',
                'label' => 'Descripción',
                'control' => 'textarea',
                'type' => 'textarea',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true
            ],
            [
                'id' => 3,
                'name' => 'responsable',
                'label' => 'Responsable',
                'control' => 'input',
                'type' => 'text',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true
            ]
        ]
    ];

    public function index()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        $datos = Proyecto::all();
        $privilegios = Privilegio::all();

        //recupera datos del usuario
        foreach ($datos as $registro) {
            $registro->user_id_create_nombre = User::findOrFail($registro->user_id_create)->nombre;
            $registro->user_id_last_update_nombre = User::findOrFail($registro->user_id_last_update)->nombre;
        }

        return view($this->properties['view']['index'], [
            'user' => $user,
            'registros' => $datos,
            'privilegios' => $privilegios,
            'action' => $this->properties['actions'],
            'titulo' => $this->properties['title'],
            'campos' => $this->properties['fields'],
        ]);
    }

    public function getById($_id)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        $data = Proyecto::findOrFail($_id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function create(Request $_request)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        // Validar la solicitud. USO DE UNIQUE: unique:tabla,campo
        $_request->validate([
            'proyecto_nombre' => 'required|string|max:255',
            'proyecto_descripcion' => 'required|string|max:1000',
            'proyecto_responsable' => 'required|string|max:255',
        ], $this->mensajes);

        // Manejar la carga de la imagen
        try {
            // Insertar el registro en la base de datos
            Proyecto::create([
                'nombre' => $_request->proyecto_nombre,
                'descripcion' => $_request->proyecto_descripcion,
                'responsable' => $_request->proyecto_responsable,
                'user_id_create' => $user->id,
                'user_id_last_update' => $user->id,
            ]);
            return redirect()->back()->with('success', 'Proyecto creado con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el proyecto: ' . $e->getMessage());
        }
    }

    public function enable($_id)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        $registro = Proyecto::findOrFail($_id);
        $registro->user_id_last_update = $user->id;
        $registro->activo = true;
        try {
            $registro->save();
            return redirect()->route($this->properties['routes']['index'])->with('success', $this->getTextToast($this->properties['title']['singular'], 'enable', 'success', $registro->nombre, null));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'enable', 'error', $registro->nombre, null) . $e->getMessage());
        }
    }

    public function disable($_id)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        $registro = Proyecto::findOrFail($_id);
        $registro->user_id_last_update = $user->id;
        $registro->activo = false;
        try {
            $registro->save();
            return redirect()->route($this->properties['routes']['index'])->with('success', $this->getTextToast($this->properties['title']['singular'], 'disable', 'success', $registro->nombre, null));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'disable', 'error', $registro->nombre, null) . $e->getMessage());
        }
    }

    public function delete($_id)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }
        $proyecto = Proyecto::findOrFail($_id);
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('success', "[id: $proyecto->id] [Registro: $proyecto->nombre] eliminado con éxito.");
    }

    public function update(Request $_request, $_id)
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        $_request->validate([
            'proyecto_nombre' => 'required|string|max:255',
            'proyecto_descripcion' => 'required|string|max:1000',
            'proyecto_responsable' => 'required|string|max:255',
        ], $this->mensajes);

        //busca el proyecto
        $proyecto = Proyecto::findOrFail($_id);

        $datos = $_request->only('_token', 'proyecto_nombre', 'proyecto_descripcion', 'proyecto_responsable');

        $cambios = 0;

        // solo si es distinto actualiza
        if ($proyecto->nombre != $datos['proyecto_nombre']) {
            $proyecto->nombre = $datos['proyecto_nombre'];
            $cambios += 1;
        }
        if ($proyecto->descripcion != $datos['proyecto_descripcion']) {
            $proyecto->descripcion = $datos['proyecto_descripcion'];
            $cambios += 1;
        }
        if ($proyecto->responsable != $datos['proyecto_responsable']) {
            $proyecto->responsable = $datos['proyecto_responsable'];
            $cambios += 1;
        }

        if ($cambios > 0) {
            try {
                $proyecto->user_id_last_update = $user->id;
                $proyecto->save();
                return redirect()->route('proyectos.index')->with('success', "[id: $proyecto->id] [Proyecto: $proyecto->nombre] actualizado con éxito.");
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "[id: $proyecto->id] [Proyecto: $proyecto->nombre] no se realizaron cambios.");
        }
    }
}
