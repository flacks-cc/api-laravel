<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoriaController extends BaseController
{
    /**
 * Crear un nuevo registro de categoría
 * @OA\Post (
 *     path="/api/categoria/nuevo",
 *     tags={"Categorias"},
 *     @OA\RequestBody(
 *         description="Datos de la categoría para crear",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="NombreCategoria",
 *                 type="string",
 *                 maxLength=100,
 *                 description="Nombre de la categoría, máximo 100 caracteres."
 *             ),
 *             @OA\Property(
 *                 property="DescripcionCategoria",
 *                 type="string",
 *                 maxLength=255,
 *                 description="Descripción de la categoría, máximo 255 caracteres."
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
 *                 example="Se ha creado el registro de categoría correctamente."
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
 *         description="Ha ocurrido un error al crear el registro de categoría",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al crear el registro de categoría."
 *             )
 *         )
 *     )
 * )
 */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NombreCategoria' => 'required|string|max:100',
            'DescripcionCategoria' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $categoria = new Categoria($data);
            $categoria->save();

            DB::commit();

            return $this->sendResponse(null, 'Se ha creado el registro de categoría correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al crear el registro de categoría.', $e->getMessage());
        }
    }
/**
 * Actualizar un registro de categoría específico
 * @OA\Put (
 *     path="api/categoria/idCategoria/editar",
 *     tags={"Categorias"},
 *     @OA\Parameter(
 *         name="idCategoria",
 *         in="path",
 *         description="ID de la categoría a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Datos de la categoría para actualizar",
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="NombreCategoria",
 *                 type="string",
 *                 maxLength=100,
 *                 description="Nombre de la categoría, máximo 100 caracteres."
 *             ),
 *             @OA\Property(
 *                 property="DescripcionCategoria",
 *                 type="string",
 *                 maxLength=255,
 *                 description="Descripción de la categoría, máximo 255 caracteres."
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
 *                 example="El registro de categoría ha sido actualizado correctamente."
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
 *         description="Ha ocurrido un error al actualizar el registro de categoría",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Ha ocurrido un error al actualizar el registro de categoría."
 *             )
 *         )
 *     )
 * )
 */
    public function update(Request $request, $idCategoria)
    {
        $validator = Validator::make($request->all(), [
            'NombreCategoria' => 'required|string|max:100',
            'DescripcionCategoria' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $categoria = Categoria::findOrFail($idCategoria);
            $categoria->update($data);

            DB::commit();

            return $this->sendResponse(null, 'El registro de categoría ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar el registro de categoría.', $e->getMessage());
        }
    }

    /**
     * Listado de registros de categoría
     * @OA\Get (
     *     path="/api/categoria/index",
     *     tags={"Categorias"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(ref="#/components/schemas/Categoria")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $categorias = Categoria::all();
        return $this->sendResponse($categorias, 'Todos los registros de categoría han sido listados correctamente.');
    }

    /**
     * Mostrar un registro de categoría específico
     * @OA\Get (
     *     path="/api/categoria/idCategoria",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="idCategoria",
     *         in="path",
     *         description="ID de la categoría a mostrar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Categoria")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al mostrar el registro de categoría",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al mostrar el registro de categoría."
     *             )
     *         )
     *     )
     * )
     */
    public function show($idCategoria)
    {
        DB::beginTransaction();

        try {
            $categoria = Categoria::findOrFail($idCategoria);

            DB::commit();

            return $this->sendResponse($categoria, 'Se ha listado el registro de categoría correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al mostrar el registro de categoría.', $e->getMessage());
        }
    }

    /**
     * Eliminar un registro de categoría específico
     * @OA\Delete (
     *     path="/api/categoria/idCategoria/eliminar",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="idCategoria",
     *         in="path",
     *         description="ID de la categoría a eliminar",
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
     *                 example="El registro de categoría ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al eliminar el registro de categoría",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al eliminar el registro de categoría."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($idCategoria)
    {
        DB::beginTransaction();

        try {
            $categoria = Categoria::findOrFail($idCategoria);
            $categoria->delete();

            DB::commit();

            return $this->sendResponse(null, 'El registro de categoría ha sido eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al eliminar el registro de categoría.', $e->getMessage());
        }
    }
}
