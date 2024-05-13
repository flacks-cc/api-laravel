<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Empleado;
use App\Models\DetalleGeneral;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmpleadoController extends BaseController
{
    /**
     * @OA\Post (
     *     path="/api/empleado/nuevo",
     *     tags={"Empleados"},
     *     @OA\RequestBody(
     *         description="Datos del empleado para crear",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="nombreEmpleado",
     *                 type="string",
     *                 example="Juan Pérez",
     *                 description="Nombre del empleado"
     *             ),
     *             @OA\Property(
     *                 property="Salario",
     *                 type="float",
     *                 example=55000.00,
     *                 description="Salario del empleado"
     *             ),
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example=1,
     *                 description="ID del usuario asociado al empleado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
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
        $validator = Validator::make($request->all(), [
            'nombreEmpleado' => 'required|string|max:100',
            'Salario' => 'required|numeric',
            'IdUsuario' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        try {
            $empleado = Empleado::create($request->all());
            return $this->sendResponse(null, 'Se ha creado el registro correctamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al crear el registro.', $e->getMessage());
        }
    }

    /**
     * @OA\Put (
     *     path="/api/empleado/idEmpleado/editar",
     *     tags={"Empleados"},
     *     @OA\Parameter(
     *         name="idEmpleado",
     *         in="path",
     *         description="ID del empleado a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos del empleado para actualizar",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="nombreEmpleado",
     *                 type="string",
     *                 example="Juan Pérez",
     *                 description="Nombre del empleado"
     *             ),
     *             @OA\Property(
     *                 property="Salario",
     *                 type="float",
     *                 example=55000.00,
     *                 description="Salario del empleado"
     *             ),
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example=1,
     *                 description="ID del usuario asociado al empleado"
     *             )
     *         )
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
    public function updated(Request $request, $idEmpleado)
    {
        $validator = Validator::make($request->all(), [
            'nombreEmpleado' => 'required|string|max:100',
            'Salario' => 'required|numeric',
            'IdUsuario' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        try {
            $empleado = Empleado::findOrFail($idEmpleado);
            $empleado->update($request->all());
            return $this->sendResponse(null, 'El registro ha sido actualizado correctamente.');
        } catch (ModelNotFoundException $e) {
            return $this->sendError('No se encontró el empleado con ese ID.', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar el registro.', $e->getMessage());
        }
    }

    /**
     * @OA\Get (
     *     path="/api/empleado/index",
     *     tags={"Empleados"},
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
     *                         property="idEmpleado",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="nombreEmpleado",
     *                         type="string",
     *                         example="Juan Pérez"
     *                     ),
     *                     @OA\Property(
     *                         property="Salario",
     *                         type="float",
     *                         example=55000.00
     *                     ),
     *                     @OA\Property(
     *                         property="IdUsuario",
     *                         type="integer",
     *                         example=1
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
        try {
            $empleados = Empleado::all();
            return $this->sendResponse($empleados, 'Todos los registros han sido listados correctamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al obtener los registros de empleados.', $e->getMessage());
        }
    }

    /**
     * @OA\Get (
     *     path="/api/empleado/idEmpleado",
     *     tags={"Empleados"},
     *     @OA\Parameter(
     *         name="idEmpleado",
     *         in="path",
     *         description="ID del empleado a mostrar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="idEmpleado",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="nombreEmpleado",
     *                 type="string",
     *                 example="Juan Pérez"
     *             ),
     *             @OA\Property(
     *                 property="Salario",
     *                 type="float",
     *                 example=55000.00
     *             ),
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="created_at",
     *                 type="string",
     *                 example="2023-02-23T00:09:16.000000Z"
     *             ),
     *             @OA\Property(
     *                 property="updated_at",
     *                 type="string",
     *                 example="2023-02-23T12:33:45.000000Z"
     *             )
     *         )
     *     )
     * )
     */
    public function show($idEmpleado)
    {
        try {
            $empleado = Empleado::findOrFail($idEmpleado);
            return $this->sendResponse($empleado, 'Se ha listado el registro correctamente.');
        } catch (ModelNotFoundException $e) {
            return $this->sendError('No se encontró el empleado con ese ID.', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return $this->sendError('Error al obtener el registro de empleado.', $e->getMessage());
        }
    }

    /**
     * @OA\Delete (
     *     path="/api/empleado/idEmpleado/eliminar",
     *     tags={"Empleados"},
     *     @OA\Parameter(
     *         name="idEmpleado",
     *         in="path",
     *         description="ID del empleado a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="El registro ha sido eliminado correctamente."
     *             )
     *         )
     *     )
     * )
     */
    public function delete($idEmpleado)
    {
        try {
            $empleado = Empleado::findOrFail($idEmpleado);
            $empleado->delete();
            return $this->sendResponse(null, 'El registro ha sido eliminado correctamente.');
        } catch (ModelNotFoundException $e) {
            return $this->sendError('No se encontró el empleado con ese ID.', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return $this->sendError('Error al eliminar el registro de empleado.', $e->getMessage());
        }
    }
}