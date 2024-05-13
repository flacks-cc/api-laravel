<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class ClienteController extends BaseController
{
    /**
     * Crear un nuevo registro
     * @OA\Post (
     *     path="/api/cliente/nuevo",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         description="Datos del cliente para crear",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Se ha creado el registro correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Los datos a validar no son correctos",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Los datos a validar no son correctos."
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors(), 400);
        }

        $data = $request->all();
        $cliente = new Cliente($data);
        $cliente->save();

        return $this->sendResponse(null, 'Se ha creado el registro correctamente.', 201);
    }

    /**
     * Actualizar un registro específico
     * @OA\Put (
     *     path="/api/cliente/idCliente/editar",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="idCliente",
     *         in="path",
     *         description="ID del cliente a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos del cliente para actualizar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="El registro ha sido actualizado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Los datos a validar no son correctos",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Los datos a validar no son correctos."
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idCliente)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        $data = $request->all();
        $cliente = Cliente::findOrFail($idCliente);
        $cliente->update($data);
        return $this->sendResponse(null, 'El registro ha sido actualizado correctamente.');
    }

    /**
     * Listado de registros
     * @OA\Get (
     *     path="/api/cliente/index",
     *     tags={"Clientes"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="idCliente",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombreCliente",
     *                         type="string",
     *                         example="Aderson Felix"
     *                     ),
     *                     @OA\Property(
     *                         property="correo",
     *                         type="string",
     *                         example="JaraLazaro@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $clientes = Cliente::all();
        return $this->sendResponse($clientes, 'Todos los registros han sido listados correctamente.');
    }

    /**
     * Mostrar un registro específico
     * @OA\Get (
     *     path="/api/cliente/idCliente",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="idCliente",
     *         in="path",
     *         description="ID del cliente a buscar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente no encontrado."
     *             )
     *         )
     *     )
     * )
     */
    public function show($idCliente)
    {
        $cliente = Cliente::find($idCliente);
        if (is_null($cliente)) {
            return $this->sendError('Cliente no encontrado.');
        }
        return $this->sendResponse($cliente, 'Se ha listado el registro correctamente.');
    }

    /**
     * Eliminar un registro específico
     * @OA\Delete (
     *     path="/api/cliente/idCliente/eliminar",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="idCliente",
     *         in="path",
     *         description="ID del cliente a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="El registro ha sido eliminado correctamente."
     *             )
     *         )
     *     )
     * )
     */
    public function delete($idCliente)
    {
        $cliente = Cliente::findOrFail($idCliente);
        $cliente->delete();
        return $this->sendResponse(null, 'El registro ha sido eliminado correctamente.');
    }

    /**
     * Obtener reglas de validación para Cliente
     *
     * @return array
     */
    private function getValidationRules()
    {
        return [
            'nombreCliente' => 'required|string|max:100',
            'correo' => 'required|email',
            'idUsuario' => 'integer|nullable',
        ];
    }
}
