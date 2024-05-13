<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Reservacion;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReservacionController extends BaseController
{
    /**
     * @OA\Post (
     *     path="/api/reservacion/nueva",
     *     tags={"Reservaciones"},
     *     @OA\RequestBody(
     *         description="Datos de la reservación para crear",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example=44,
     *                 description="ID del usuario asociado a la reservación"
     *             
     * ),
     *             @OA\Property(
     *                 property="IdServicio",
     *                 type="int",
     *                 example="1",
     *                 description="ID del servicio"
     * ),
     *             @OA\Property(
     *                 property="FechaReserva",
     *                 type="string",
     *                 format="date-time",
     *                 example="2023-11-21 12:00:00",
     *                 description="Fecha de la reservación"
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
     *                 example="Se ha creado la reservación correctamente."
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
     *         description="Ha ocurrido un error al crear la reservación",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al crear la reservación."
     *             )
     *         )
     *     )
     * )
     */

     
     public function create(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'IdUsuario' => 'required|integer',
             'FechaReserva' => 'required|date_format:Y-m-d H:i:s',
             'IdServicio' => 'required|exists:servicios,IdServicio',  // Asegúrate de que el servicio exista
         ]);
     
         if ($validator->fails()) {
             return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
         }
     
         DB::beginTransaction();
     
         try {
             $data = $request->all();
             $reservacion = new Reservacion($data);
             $reservacion->save();
     
             // Obtener datos del usuario
             $usuario = User::find($request->input('IdUsuario'));
     
             // Obtener datos del servicio
             $servicio = Servicio::find($request->input('IdServicio'));
     
             DB::commit();
     
             // Puedes devolver los datos del usuario y del servicio en la respuesta
             return $this->sendResponse([
                 'reservacion' => $reservacion,
                 'usuario' => $usuario,
                 'servicio' => $servicio,
             ], 'Se ha creado la reservación correctamente.');
         } catch (\Exception $e) {
             DB::rollBack();
             return $this->sendError('Ha ocurrido un error al crear la reservación.', $e->getMessage());
         }
     }
     
/**
     * Actualizar un registro de reservación específico
     *
     * @OA\Put (
     *     path="api/reservacion/idReservacion/editar",
     *     tags={"Reservaciones"},
     *     @OA\Parameter(
     *         name="idReservacion",
     *         in="path",
     *         description="ID de la reservación a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos de la reservación para actualizar",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example=1,
     *                 description="ID del usuario asociado a la reservación"
     *             ),
     *             @OA\Property(
     *                 property="FechaReserva",
     *                 type="string",
     *                 format="date-time",
     *                 example="2023-11-21 15:30:00",
     *                 description="Fecha de la reservación"
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
     *                 example="La reservación ha sido actualizada correctamente."
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
     *         description="Ha ocurrido un error al actualizar la reservación",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al actualizar la reservación."
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idReservacion)
    {
        $validator = Validator::make($request->all(), [
            'IdUsuario' => 'required|integer',
            'FechaReserva' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $reservacion = Reservacion::findOrFail($idReservacion);
            $reservacion->update($data);

            DB::commit();

            return $this->sendResponse(null, 'La reservación ha sido actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar la reservación.', $e->getMessage());
        }
    }

/**
 *
 * @OA\Get (
 *     path="/api/reservacion/index",
 *     tags={"Reservaciones"},
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
 *                         property="IdReservacion",
 *                         type="number",
 *                         example="1"
 *                     ),
 *                     @OA\Property(
 *                         property="IdUsuario",
 *                         type="integer",
 *                         example=1
 *                     ),
 *                     @OA\Property(
 *                         property="FechaReserva",
 *                         type="string",
 *                         format="date-time",
 *                         example="2023-11-21 15:30:00"
 *                     ),
 *                     @OA\Property(
 *                         property="created_at",
 *                         type="string",
 *                         format="date-time",
 *                         example="2023-11-21T00:09:16.000000Z"
 *                     ),
 *                     @OA\Property(
 *                         property="updated_at",
 *                         type="string",
 *                         format="date-time",
 *                         example="2023-11-21T12:33:45.000000Z"
 *                     )
 *                 )
 *             )
 *         )
 *     )
 * )
 */
public function index()
{
    $reservaciones = Reservacion::all();
    return $this->sendResponse($reservaciones, 'Todos los registros de reservación han sido listados correctamente.');
}

/**
 * Mostrar una reservación específica
 *
 * @OA\Get (
 *     path="/api/reservacion/idReservacion",
 *     tags={"Reservaciones"},
 *     @OA\Parameter(
 *         name="idReservacion",
 *         in="path",
 *         description="ID de la reservación a mostrar",
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
 *                 property="IdReservacion",
 *                 type="number",
 *                 example="1"
 *             ),
 *             @OA\Property(
 *                 property="IdUsuario",
 *                 type="integer",
 *                 example=1
 *             ),
 *             @OA\Property(
 *                 property="FechaReserva",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-11-21 15:30:00"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-11-21T00:09:16.000000Z"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-11-21T12:33:45.000000Z"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Ha ocurrido un error al mostrar la reservación",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al mostrar la reservación."
 *             )
 *         )
 *     )
 * )
 */
public function show($idReservacion)
{
    DB::beginTransaction();

    try {
        $reservacion = Reservacion::where('IdReservacion', '=', $idReservacion)->get();

        DB::commit();

        return $this->sendResponse($reservacion, 'Se ha listado el registro de reservación correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return $this->sendError('Ha ocurrido un error al mostrar la reservación.', $e->getMessage());
    }
}

/**
 * Eliminar una reservación específica
 *
 * @OA\Delete (
 *     path="/api/reservacion/idReservacion/eliminar",
 *     tags={"Reservaciones"},
 *     @OA\Parameter(
 *         name="idReservacion",
 *         in="path",
 *         description="ID de la reservación a eliminar",
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
 *                 example="La reservación ha sido eliminada correctamente."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Ha ocurrido un error al eliminar la reservación",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al eliminar la reservación."
 *             )
 *         )
 *     )
 * )
 */
public function destroy($idReservacion)
{
    DB::beginTransaction();
    try {
        $reservacion = Reservacion::findOrFail($idReservacion);
        $reservacion->delete();

        DB::commit();

        return $this->sendResponse(null, 'La reservación ha sido eliminada correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return $this->sendError('Ha ocurrido un error al eliminar la reservación.', $e->getMessage());
    }

    }
}
