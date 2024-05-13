<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Esta clase (BaseController) se utiliza como una base para otros controladores en la aplicación API
// y proporciona métodos para responder a solicitudes con respuestas JSON en caso de éxito o error.

class BaseController extends Controller
{
    // Método para regresar una respuesta exitosa
    public function sendResponse($result, $message) {
        // Crea un arreglo de respuesta con la marca de éxito, datos y mensaje
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        // Retorna una respuesta JSON con el código de estado 200 (OK)
        // Este método regresa una respuesta de tipo 200 si es correcto
        return response()->json($response, 200);
    }
    
    // Método para enviar una respuesta de error
    public function sendError($error, $errorMessages = [], $code = 404) {
        // Crea un arreglo de respuesta con la marca de error y el mensaje de error
        $response = [
            'success' => false,
            'message' => $error,
        ];

        // Si se proporcionan mensajes de error adicionales, se agregan al arreglo de respuesta
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        // Retorna una respuesta JSON con el código de estado proporcionado (predeterminado: 404)
        return response()->json($response, $code);
    }
}
