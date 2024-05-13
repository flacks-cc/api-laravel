<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Servicio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ServicioController extends BaseController
{
 /**
 * Crear un nuevo registro de servicio
 * @OA\Post(
 *     path="/api/servicio/nuevo",
 *     tags={"Servicios"},
 *     @OA\RequestBody(
 *         description="Datos del servicio para crear",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="Precio",
 *                 type="integer",
 *                 description="Precio del servicio.",
 *                 example=100
 *             ),
 *             @OA\Property(
 *                 property="NombreServicio",
 *                 type="string",
 *                 description="Nombre del servicio.",
 *                 example="Corte"
 *             ),
 *             @OA\Property(
 *                 property="Duracion",
 *                 type="string",
 *                 format="time",
 *                 description="Duración del servicio.",
 *                 example="01:00:00"
 *             ),
 *             @OA\Property(
 *                 property="Descripcion",
 *                 type="string",
 *                 description="Descripción del servicio.",
 *                 example="Descripcion"
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
 *                 example="Se ha creado el registro de servicio correctamente."
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
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Ha ocurrido un error al crear el registro de servicio",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al crear el registro de servicio."
 *             )
 *         )
 *     )
 * )
 */

public function create(Request $request)
{
    $validator = Validator::make($request->all(), [
        'Precio' => 'required|integer',
        'NombreServicio' => 'required|string|max:100',
        'Duracion' => 'required|date_format:H:i:s',
        'Descripcion' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
    }

    DB::beginTransaction();

    try {
        $data = $request->all();
        $servicio = new Servicio($data);
        $servicio->save();

        DB::commit();

        return $this->sendResponse(null, 'Se ha creado el registro de servicio correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return $this->sendError('Ha ocurrido un error al crear el registro de servicio.', $e->getMessage());
    }
}

/**
 * Actualizar un registro de servicio específico
 * @OA\Put (
 *     path="api/servicio/idServicio/editar",
 *     tags={"Servicios"},
 *     @OA\Parameter(
 *         name="idServicio",
 *         in="path",
 *         description="ID del servicio a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Datos del servicio para actualizar",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="Precio",
 *                 type="integer",
 *                 description="Nuevo precio del servicio."
 *             ),
 *             @OA\Property(
 *                 property="NombreServicio",
 *                 type="string",
 *                 description="Nuevo nombre del servicio."
 *             ),
 *             @OA\Property(
 *                 property="Duracion",
 *                 type="string",
 *                 format="time",
 *                 description="Nueva duración del servicio."
 *             ),
 *             @OA\Property(
 *                 property="Descripcion",
 *                 type="string",
 *                 description="Nueva descripción del servicio."
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
 *                 example="El registro de servicio ha sido actualizado correctamente."
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
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Ha ocurrido un error al actualizar el registro de servicio",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al actualizar el registro de servicio."
 *             )
 *         )
 *     )
 * )php
 */

    public function update(Request $request, $idServicio)
    {
        $validator = Validator::make($request->all(), [
            'Precio' => 'required|integer',
            'NombreServicio' => 'required|string|max:100',
            'Duracion' => 'required|date_format:H:i:s',
            'Descripcion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $servicio = Servicio::findOrFail($idServicio);
            $servicio->update($data);

            DB::commit();

            return $this->sendResponse(null, 'El registro de servicio ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar el registro de servicio.', $e->getMessage());
        }
    }

    /**
     * Listado de registros de servicio
     * @OA\Get (
     *     path="/api/servicio/index",
     *     tags={"Servicios"},
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
     *                         type="integer",
     *                         property="IdServicio"
     *                     ),
     *                     @OA\Property(
     *                         type="integer",
     *                         property="Precio"
     *                     ),
     *                     @OA\Property(
     *                         type="string",
     *                         property="NombreServicio"
     *                     ),
     *                     @OA\Property(
     *                         type="string",
     *                         property="Duracion"
     *                     ),
     *                     @OA\Property(
     *                         type="string",
     *                         property="Descripcion"
     *                     ),
     *                     @OA\Property(
     *                         type="string",
     *                         property="created_at"
     *                     ),
     *                     @OA\Property(
     *                         type="string",
     *                         property="updated_at"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $servicios = Servicio::all();
        return $this->sendResponse($servicios, 'Todos los registros de servicio han sido listados correctamente.');
    }

    /**
     * Mostrar un registro de servicio específico
     * @OA\Get (
     *     path="/api/servicio/idServicio",
     *     tags={"Servicios"},
     *     @OA\Parameter(
     *         name="idServicio",
     *         in="path",
     *         description="ID del servicio a mostrar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Servicio")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al mostrar el registro de servicio",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al mostrar el registro de servicio."
     *             )
     *         )
     *     )
     * )
     */
    public function show($idServicio)
    {
        DB::beginTransaction();

        try {
            $servicio = Servicio::find($idServicio);

            DB::commit();

            return $this->sendResponse($servicio, 'Se ha listado el registro de servicio correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al mostrar el registro de servicio.', $e->getMessage());
        }
    }

    /**
     * Eliminar un registro de servicio específico
     * @OA\Delete (
     *     path="/api/servicio/idServicio/eliminar",
     *     tags={"Servicios"},
     *     @OA\Parameter(
     *         name="idServicio",
     *         in="path",
     *         description="ID del servicio a eliminar",
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
     *                 example="El registro de servicio ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al eliminar el registro de servicio",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al eliminar el registro de servicio."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($idServicio)
    {
        DB::beginTransaction();
        try {
            $servicio = Servicio::findOrFail($idServicio);
            $servicio->delete();

            DB::commit();

            return $this->sendResponse(null, 'El registro de servicio ha sido eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al eliminar el registro de servicio.', $e->getMessage());
        }
    }
}
