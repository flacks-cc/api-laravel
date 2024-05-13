<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\DetalleGeneral;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetalleGeneralController extends BaseController
{
/**
 * Crear un nuevo detalle general
 * @OA\Post (
 *     path="/api/detallegeneral/nuevo",
 *     tags={"Detalle General"},
 *     @OA\RequestBody(
 *         description="Datos del detalle general para crear",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="IdEmpleado",
 *                 type="integer",
 *                 description="ID del empleado."
 *             ),
 *             @OA\Property(
 *                 property="IdReservacion",
 *                 type="integer",
 *                 description="ID de la reservación."
 *             ),
 *             @OA\Property(
 *                 property="IdDetalleProducto",
 *                 type="integer",
 *                 description="ID del detalle del producto."
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
 *                 example="Se ha creado el detalle general correctamente."
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
 *         description="Ha ocurrido un error al crear el detalle general",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al crear el detalle general."
 *             )
 *         )
 *     )
 * )
 */

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdEmpleado' => 'required|integer',
            'IdReservacion' => 'required|integer',
            'IdDetalleProducto' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $detalleGeneral = new DetalleGeneral($data);
            $detalleGeneral->save();

            DB::commit();

            return $this->sendResponse(null, 'Se ha creado el detalle general correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al crear el detalle general.', $e->getMessage());
        }
    }

    /**
 * Actualizar un detalle general específico
 * @OA\Put (
 *     path="/api/detallegeneral/idDetalleGeneral/editar",
 *     tags={"Detalle General"},
 *     @OA\Parameter(
 *         name="idDetalleGeneral",
 *         in="path",
 *         description="ID del detalle general a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Datos del detalle general para actualizar",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="IdEmpleado",
 *                 type="integer",
 *                 description="ID del empleado."
 *             ),
 *             @OA\Property(
 *                 property="IdReservacion",
 *                 type="integer",
 *                 description="ID de la reservación."
 *             ),
 *             @OA\Property(
 *                 property="IdDetalleProducto",
 *                 type="integer",
 *                 description="ID del detalle del producto."
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
 *                 example="El detalle general ha sido actualizado correctamente."
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
 *         description="Ha ocurrido un error al actualizar el detalle general",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al actualizar el detalle general."
 *             )
 *         )
 *     )
 * )
 */

    public function update(Request $request, $idDetalleGeneral)
    {
        $validator = Validator::make($request->all(), [
            'IdEmpleado' => 'required|integer',
            'IdReservacion' => 'required|integer',
            'IdDetalleProducto' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $detalleGeneral = DetalleGeneral::findOrFail($idDetalleGeneral);
            $detalleGeneral->update($data);

            DB::commit();

            return $this->sendResponse(null, 'El detalle general ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar el detalle general.', $e->getMessage());
        }
    }

    /**
     * Listado de detalles generales
     * @OA\Get (
     *     path="/api/detallegeneral/index",
     *     tags={"Detalle General"},
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
     *                         property="IdDetallesGeneral"
     *                     ),
     *                     @OA\Property(
     *                         type="integer",
     *                         property="IdEmpleado"
     *                     ),
     *                     @OA\Property(
     *                         type="integer",
     *                         property="IdReservacion"
     *                     ),
     *                     @OA\Property(
     *                         type="integer",
     *                         property="IdDetalleProducto"
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
        $detallesGenerales = DetalleGeneral::all();
        return $this->sendResponse($detallesGenerales, 'Todos los detalles generales han sido listados correctamente.');
    }

   /**
 * Mostrar un detalle general específico
 * @OA\Get (
 *     path="/api/detallegeneral/idDetalleGeneral",
 *     tags={"Detalle General"},
 *     @OA\Parameter(
 *         name="idDetalleGeneral",
 *         in="path",
 *         description="ID del detalle general a mostrar",
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
 *                 property="IdDetallesGeneral",
 *                 type="integer",
 *                 description="ID del detalle general."
 *             ),
 *             @OA\Property(
 *                 property="IdEmpleado",
 *                 type="integer",
 *                 description="ID del empleado."
 *             ),
 *             @OA\Property(
 *                 property="IdReservacion",
 *                 type="integer",
 *                 description="ID de la reservación."
 *             ),
 *             @OA\Property(
 *                 property="IdDetalleProducto",
 *                 type="integer",
 *                 description="ID del detalle del producto."
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="Fecha de creación del detalle general."
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="Fecha de última actualización del detalle general."
 *             ),
 *             @OA\Property(
 *                 property="deleted_at",
 *                 type="string",
 *                 format="date-time",
 *                 description="Fecha de eliminación del detalle general."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Ha ocurrido un error al mostrar el detalle general",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al mostrar el detalle general."
 *             )
 *         )
 *     )
 * )
 */

    public function show($idDetalleGeneral)
    {
        DB::beginTransaction();

        try {
            $detalleGeneral = DetalleGeneral::find($idDetalleGeneral);

            DB::commit();

            return $this->sendResponse($detalleGeneral, 'Se ha listado el detalle general correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al mostrar el detalle general.', $e->getMessage());
        }
    }

    /**
     * Eliminar un detalle general específico
     * @OA\Delete (
     *     path="/api/detallegeneral/idDetalleGeneral/eliminar",
     *     tags={"Detalle General"},
     *     @OA\Parameter(
     *         name="idDetalleGeneral",
     *         in="path",
     *         description="ID del detalle general a eliminar",
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
     *                 example="El detalle general ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al eliminar el detalle general",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al eliminar el detalle general."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($idDetalleGeneral)
    {
        DB::beginTransaction();
        try {
            $detalleGeneral = DetalleGeneral::findOrFail($idDetalleGeneral);
            $detalleGeneral->delete();

            DB::commit();

            return $this->sendResponse(null, 'El detalle general ha sido eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al eliminar el detalle general.', $e->getMessage());
        }
    }
}
