<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Rol;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RolesController extends BaseController
{
    /**
     * Crear un nuevo registro de rol
     * @OA\Post (
     *     path="/api/rol/nuevo",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *         description="Datos del rol para crear",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="nombreRol",
     *                 type="string",
     *                 example="Admin",
     *                 description="Nombre del rol"
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
     *                 example="Se ha creado el registro de rol correctamente."
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
     *         description="Ha ocurrido un error al crear el registro de rol",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al crear el registro de rol."
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreRol' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $rol = new Rol($data);
            $rol->save();

            DB::commit();

            return $this->sendResponse(null, 'Se ha creado el registro de rol correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al crear el registro de rol.', $e->getMessage());
        }
    }

    /**
     * Actualizar un registro de rol específico
     * @OA\Put (
     *     path="api/rol/idRol/editar",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="idRol",
     *         in="path",
     *         description="ID del rol a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos del rol para actualizar",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="nombreRol",
     *                 type="string",
     *                 example="Admin",
     *                 description="Nombre del rol"
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
     *                 example="El registro de rol ha sido actualizado correctamente."
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
     *         description="Ha ocurrido un error al actualizar el registro de rol",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al actualizar el registro de rol."
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idRol)
    {
        $validator = Validator::make($request->all(), [
            'nombreRol' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $rol = Rol::findOrFail($idRol);
            $rol->update($data);

            DB::commit();

            return $this->sendResponse(null, 'El registro de rol ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar el registro de rol.', $e->getMessage());
        }
    }

    /**
     * Listado de registros de rol
     * @OA\Get (
     *     path="/api/rol/index",
     *     tags={"Roles"},
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
     *                         property="idRol",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombreRol",
     *                         type="string",
     *                         example="Admin"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Fecha de creación del rol"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Fecha de última actualización del rol"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $roles = Rol::all();
        return $this->sendResponse($roles, 'Todos los registros de rol han sido listados correctamente.');
    }

    /**
     * Mostrar un registro de rol específico
     * @OA\Get (
     *     path="/api/rol/idRol",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="idRol",
     *         in="path",
     *         description="ID del rol a mostrar",
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
     *                 property="idRol",
     *                 type="number",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="nombreRol",
     *                 type="string",
     *                 example="Admin"
     *             ),
     *             @OA\Property(
     *                 property="created_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Fecha de creación del rol"
     *             ),
     *             @OA\Property(
     *                 property="updated_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Fecha de última actualización del rol"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al mostrar el registro de rol",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al mostrar el registro de rol."
     *             )
     *         )
     *     )
     * )
     */
    public function show($idRol)
    {
        DB::beginTransaction();

        try {
            $rol = Rol::findOrFail($idRol);

            DB::commit();

            return $this->sendResponse($rol, 'Se ha listado el registro de rol correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al mostrar el registro de rol.', $e->getMessage());
        }
    }

    /**
     * Eliminar un registro de rol específico
     * @OA\Delete (
     *     path="/api/rol/idRol/eliminar",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="idRol",
     *         in="path",
     *         description="ID del rol a eliminar",
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
     *                 example="El registro de rol ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al eliminar el registro de rol",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al eliminar el registro de rol."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($idRol)
    {
        DB::beginTransaction();

        try {
            $rol = Rol::findOrFail($idRol);
            $rol->delete();

            DB::commit();

            return $this->sendResponse(null, 'El registro de rol ha sido eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al eliminar el registro de rol.', $e->getMessage());
        }
    }
}
