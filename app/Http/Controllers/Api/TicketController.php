<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TicketController extends BaseController
{
    /**
     * Crear un nuevo ticket
     * @OA\Post (
     *     path="/api/ticket/nuevo",
     *     tags={"Ticket"},
     *     @OA\RequestBody(
     *         description="Datos del ticket para crear",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="IdDetallesGeneral",
     *                 type="integer",
     *                 example="1",
     *                 description="ID del detalle general"
     *             ),
     *             @OA\Property(
     *                 property="fecha",
     *                 type="string",
     *                 example="2023-02-23",
     *                 description="Fecha del ticket"
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
     *                 example="Se ha creado el ticket correctamente."
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
     *         description="Ha ocurrido un error al crear el ticket",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al crear el ticket."
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdDetallesGeneral' => 'required|integer',
            'fecha' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $ticket = new Ticket($data);
            $ticket->save();

            DB::commit();

            return $this->sendResponse(null, 'Se ha creado el ticket correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al crear el ticket.', $e->getMessage());
        }
    }

    /**
     * Actualizar un ticket específico
     * @OA\Put (
     *     path="api/ticket/idTicket/editar",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="idTicket",
     *         in="path",
     *         description="ID del ticket a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos del ticket para actualizar",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="IdDetallesGeneral",
     *                 type="integer",
     *                 example="1",
     *                 description="ID del detalle general"
     *             ),
     *             @OA\Property(
     *                 property="fecha",
     *                 type="string",
     *                 example="2023-02-23",
     *                 description="Fecha del ticket"
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
     *                 example="El ticket ha sido actualizado correctamente."
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
     *         description="Ha ocurrido un error al actualizar el ticket",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al actualizar el ticket."
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idTicket)
    {
        $validator = Validator::make($request->all(), [
            'IdDetallesGeneral' => 'required|integer',
            'fecha' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $ticket = Ticket::findOrFail($idTicket);
            $ticket->update($data);

            DB::commit();

            return $this->sendResponse(null, 'El ticket ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar el ticket.', $e->getMessage());
        }
    }

    /**
     * Listado de tickets
     * @OA\Get (
     *     path="/api/ticket/index",
     *     tags={"Ticket"},
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
     *                         property="Idticket",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="IdDetallesGeneral",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="fecha",
     *                         type="string",
     *                         example="2023-02-23"
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
        $tickets = Ticket::all();
        return $this->sendResponse($tickets, 'Todos los tickets han sido listados correctamente.');
    }

    /**
     * Mostrar un ticket específico
     * @OA\Get (
     *     path="/api/ticket/idTicket",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="idTicket",
     *         in="path",
     *         description="ID del ticket a mostrar",
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
     *                 property="Idticket",
     *                 type="integer",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="IdDetallesGeneral",
     *                 type="integer",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="fecha",
     *                 type="string",
     *                 example="2023-02-23"
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
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al mostrar el ticket",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al mostrar el ticket."
     *             )
     *         )
     *     )
     * )
     */
    public function show($idTicket)
    {
        DB::beginTransaction();

        try {
            $ticket = Ticket::where('Idticket', '=', $idTicket)->get();

            DB::commit();

            return $this->sendResponse($ticket, 'Se ha listado el ticket correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al mostrar el ticket.', $e->getMessage());
        }
    }

    /**
     * Eliminar un ticket específico
     * @OA\Delete (
     *     path="/api/ticket/idTicket/eliminar",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="idTicket",
     *         in="path",
     *         description="ID del ticket a eliminar",
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
     *                 example="El ticket ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al eliminar el ticket",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al eliminar el ticket."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($idTicket)
    {
        DB::beginTransaction();

        try {
            $ticket = Ticket::findOrFail($idTicket);
            $ticket->delete();

            DB::commit();

            return $this->sendResponse(null, 'El ticket ha sido eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al eliminar el ticket.', $e->getMessage());
        }
    }
}
