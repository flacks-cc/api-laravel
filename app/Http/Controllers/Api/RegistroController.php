<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User; // Traer modelo usuario
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *             title="API Barberia", 
 *             version="1.0",
 *             description="Servicio de API tipo SOA para implementación en una barberia"
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000")
 */

 class RegistroController extends BaseController
 {
/**
 * Register a new user.
 *
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Usuarios"},
 *     summary="Register a new user",
 *     description="Create a new user in the system.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data of the new user",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="User's name"
 *             ),
 *             @OA\Property(
 *                 property="phone",
 *                 type="string",
 *                 description="User's phone number"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 description="User's email address"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 description="User's password"
 *             ),
 *             @OA\Property(
 *                 property="idrol",
 *                 type="integer",
 *                 description="ID of the user's role"
 *             ),
 *             @OA\Property(
 *                 property="firstname",
 *                 type="string",
 *                 description="User's first name"
 *             ),
 *             @OA\Property(
 *                 property="firstlastname",
 *                 type="string",
 *                 description="User's first last name"
 *             ),
 *             @OA\Property(
 *                 property="secondlastname",
 *                 type="string",
 *                 description="User's second last name"
 *             ),
 *             example={
 *                 "name": "John Doe",
 *                 "phone": "1234567890",
 *                 "email": "user@example.com",
 *                 "password": "password",
 *                 "idrol": 1,
 *                 "firstname": "John",
 *                 "firstlastname": "Doe",
 *                 "secondlastname": "Smith"
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="CREATED",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", description="Access token"),
 *             @OA\Property(property="user", type="object", description="Data of the registered user")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE CONTENT",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", description="Error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="CONFLICT",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", description="Error message")
 *         )
 *     )
 * )
 */
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'phone' => 'required|string|max:10',
        'email' => 'email|unique:users,email',
        'password' => 'required|string',
        'idrol' => 'integer',
        'firstname' => 'nullable|string', // Nueva validación para firstname
        'firstlastname' => 'nullable|string', // Nueva validación para firstlastname
        'secondlastname' => 'nullable|string', // Nueva validación para secondlastname
    ]);

    if ($validator->fails()) {
        return $this->sendError('Invalid data for validation', $validator->errors(), 422);
    }

    $input = $request->all();
    $input['password'] = bcrypt($input['password']);

    $user = User::create($input);

    $token = $user->createToken('MyApp')->accessToken;

    $response = [
        'token' => $token,
        'user' => $user,
    ];

    return $this->sendResponse($response, 'User registered successfully', 201);
}
/**
 * Update user information.
 *
 * @OA\Put(
 *     path="/api/user/update/{id}",
 *     tags={"Usuarios"},
 *     summary="Update user information",
 *     description="Update information of an existing user in the system.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user to update",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Updated data for the user",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="User's name"
 *             ),
 *             @OA\Property(
 *                 property="phone",
 *                 type="string",
 *                 description="User's phone number"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 description="User's email address"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 description="User's password"
 *             ),
 *             @OA\Property(
 *                 property="idrol",
 *                 type="integer",
 *                 description="ID of the user's role"
 *             ),
 *             @OA\Property(
 *                 property="firstname",
 *                 type="string",
 *                 description="User's first name"
 *             ),
 *             @OA\Property(
 *                 property="firstlastname",
 *                 type="string",
 *                 description="User's first last name"
 *             ),
 *             @OA\Property(
 *                 property="secondlastname",
 *                 type="string",
 *                 description="User's second last name"
 *             ),
 *             example={
 *                 "name": "John Doe",
 *                 "phone": "1234567890",
 *                 "email": "user@example.com",
 *                 "password": "newpassword",
 *                 "idrol": 2,
 *                 "firstname": "John",
 *                 "firstlastname": "Doe",
 *                 "secondlastname": "Smith"
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="user", type="object", description="Updated user data")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="NOT FOUND",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", description="User not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE CONTENT",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", description="Invalid data for validation")
 *         )
 *     )
 * )
 */
public function update(Request $request, $id)
{
    // Validación para el ID
    if (!$id) {
        return $this->sendError('El ID no fue ingresado, no puedes actualizar tu usuario', [], 422);
    }

    try {
        $user = User::findOrFail($id);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return $this->sendError('Usuario no encontrado', [], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'string',
        'phone' => 'string|max:10',
        'email' => 'email|unique:users,email,' . $id,
        'password' => 'string',
        'idrol' => 'integer',
        'firstname' => 'nullable|string',
        'firstlastname' => 'nullable|string',
        'secondlastname' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return $this->sendError('Datos inválidos para la validación', $validator->errors(), 422);
    }

    $input = $request->all();

    if (isset($input['password'])) {
        $input['password'] = bcrypt($input['password']);
    }

    try {
        $user->update($input);
    } catch (\Exception $e) {
        return $this->sendError('Error al actualizar el usuario', ['error' => $e->getMessage()], 500);
    }

    $response = [
        'usuario' => $user,
    ];

    return $this->sendResponse($response, 'Usuario actualizado exitosamente', 200);
}


/**
 * Login user and return access token.
 *
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Usuarios"},
 *     summary="Login a user",
 *     description="Authenticate a user and return an access token.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User login credentials",
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", description="User's email address"),
 *             @OA\Property(property="password", type="string", description="User's password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", description="ID of the logged-in user"),
 *             @OA\Property(property="token", type="string", description="Access token"),
 *             @OA\Property(property="name", type="string", description="User's name")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", description="Error message")
 *         )
 *     )
 * )
 */
public function login(Request $request)
{
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $success['id'] = $user->id; // Nuevo: Agregar el ID del usuario a la respuesta
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'Inicio de sesión correcto', ['name' => $user->name, 'id' => $user->id]);
    } else {
        return $this->sendError('Usuario no registrado', ['error' => 'NO autorizado'], 401);
    }
}

     /**
      * Obtener todos los usuarios.
      *
      * @OA\Get(
      *     path="/api/user/show",
      *     tags={"Usuarios"},
      *     summary="Obtener todos los usuarios",
      *     @OA\Response(
      *         response=200,
      *         description="OK",
      *         @OA\JsonContent(
      *             @OA\Property(property="usuarios", type="array", @OA\Items(type="object"), example={
      *                 {
      *                     "id": 1,
      *                     "NombreUsuario": "Usuario 1",
      *                     "Correo": "usuario1@example.com"
      *                 },
      *                 {
      *                     "id": 2,
      *                     "NombreUsuario": "Usuario 2",
      *                     "Correo": "usuario2@example.com"
      *                 }
      *         }),
      *         )
      *     )
      * )
      */
     public function show()
     {
         $users = User::all();
         $response = [
             'usuarios' => $users,
         ];
         return $this->sendResponse($response, 'Todos los usuarios');
     }
 }