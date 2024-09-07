<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public $mensajes = [
        //login
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'El email no tiene un formato válido.',
        'password.required' => 'La contraseña es obligatoria.',
        //crear usuario por formulario login
        'nombre.required' => 'El nombre es obligatorio.',
        'email.required' => 'El email es obligatorio.',
        'email.unique' => 'El email ya está registrado.',
        'password.required' => 'La contraseña es obligatoria.',
        'rePassword.required' => 'Repetir contraseña es obligatoria.',
        'dayCode.required' => 'El código del día es obligatorio.',
        'terms.required' => 'Debe aceptar los términos y condiciones.',
        //crear/actualizar usuario por backoffice
        'usuario_nombre.required' => 'El nombre es obligatorio :(',
        'usuario_email.required' => 'El email es obligatorio :(',
        'usuario_email.unique' => 'El email ya existe :(',
        'usuario_password.required' => 'La contraseña es obligatoria :(',
        //crear/actualizar proyecto por backoffice
        'proyecto_nombre.required' => 'El nombre del proyecto es obligatorio.',
        'proyecto_nombre.unique' => 'El nombre del proyecto ya existe.',
        'proyecto_descripcion.required' => 'La descripción del proyecto es obligatoria.',
        'proyecto_descripcion.max' => 'La descripción del proyecto no puede tener más de 1000 caracteres.',
        'proyecto_responsable.required' => 'El responsable del proyecto es obligatorio.',
        'proyecto_responsable.max' => 'El responsable del proyecto no puede tener más de 255 caracteres.',
    ];

    public function getTextToast($_mantenedor, $_accion, $_estado, $_nombre, $_mensaje)
    {
        $retorno = '';
        if ($_estado == 'success') {
            switch ($_accion) {
                case 'create':
                    $retorno = $_mantenedor . ' [' . $_nombre . '] creado exitosamente :)';
                    break;
                case 'enable':
                    $retorno = $_mantenedor . ' [' . $_nombre . '] activado exitosamente :)';
                    break;
                case 'disable':
                    $retorno = $_mantenedor . ' [' . $_nombre . '] desactivado exitosamente :)';
                    break;
                case 'delete':
                    $retorno = $_mantenedor . ' [' . $_nombre . '] eliminado exitosamente :)';
                    break;
                case 'update':
                    $retorno = $_mantenedor . ' [' . $_nombre . '] actualizado exitosamente :)';
                    break;
                default:
                    # code...
                    break;
            }
        } else if ($_estado == 'error') {
            switch ($_accion) {
                case 'create':
                    $retorno = 'Error al crear el ' . $_mantenedor . ' [' . $_nombre . ']: ' . $_mensaje;
                    break;
                case 'enable':
                    $retorno = 'Error al activar el ' . $_mantenedor . ' [' . $_nombre . ']: ' . $_mensaje;
                    break;
                case 'disable':
                    $retorno = 'Error al desactivar el ' . $_mantenedor . ' [' . $_nombre . ']: ' . $_mensaje;
                    break;
                case 'delete':
                    $retorno = 'Error al eliminar el ' . $_mantenedor . ' [' . $_nombre . ']: ' . $_mensaje;
                    break;
                case 'delete':
                    $retorno = 'Error al actualizar el ' . $_mantenedor . ' [' . $_nombre . ']: ' . $_mensaje;
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $retorno;
    }
}
