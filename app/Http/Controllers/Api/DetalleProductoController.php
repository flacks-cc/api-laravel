<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\DetalleProducto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetalleProductoController extends BaseController
{
    /**
     * Crear un nuevo detalle de producto
     * @OA\Post (
     *     path="/api/detalleproducto/nuevo",
     *     tags={"DetalleProducto"},
     *     @OA\RequestBody(
     *         description="Datos del detalle de producto para crear",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="IdProducto",
     *                 type="integer",
     *                 example="1",
     *                 description="ID del producto"
     *             ),
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example="1",
     *                 description="ID del usuario"
     *             ),
     *             @OA\Property(
     *                 property="CantidadProductos",
     *                 type="integer",
     *                 example="5",
     *                 description="Cantidad de productos"
     *             ),
     *             @OA\Property(
     *                 property="PrecioUnitario",
     *                 type="number",
     *                 example="10.99",
     *                 description="Precio unitario del producto"
     *             ),
     *             @OA\Property(
     *                 property="MontoTotal",
     *                 type="number",
     *                 example="54.95",
     *                 description="Monto total del detalle"
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
     *                 example="Se ha creado el detalle de producto correctamente."
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
     *         description="Ha ocurrido un error al crear el detalle de producto",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al crear el detalle de producto."
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdProducto' => 'required|integer',
            'IdUsuario' => 'required|integer',
            'CantidadProductos' => 'required|integer',
            'PrecioUnitario' => 'required|numeric',
            'MontoTotal' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $detalleProducto = new DetalleProducto($data);
            $detalleProducto->save();

            DB::commit();

            return $this->sendResponse(null, 'Se ha creado el detalle de producto correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al crear el detalle de producto.', $e->getMessage());
        }
    }

    /**
     * Actualizar un detalle de producto específico
     * @OA\Put (
     *     path="/api/detalleproducto/id/editar",
     *     tags={"DetalleProducto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del detalle de producto a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos del detalle de producto para actualizar",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="IdProducto",
     *                 type="integer",
     *                 example="1",
     *                 description="ID del producto"
     *             ),
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example="1",
     *                 description="ID del usuario"
     *             ),
     *             @OA\Property(
     *                 property="CantidadProductos",
     *                 type="integer",
     *                 example="5",
     *                 description="Cantidad de productos"
     *             ),
     *             @OA\Property(
     *                 property="PrecioUnitario",
     *                 type="number",
     *                 example="10.99",
     *                 description="Precio unitario del producto"
     *             ),
     *             @OA\Property(
     *                 property="MontoTotal",
     *                 type="number",
     *                 example="54.95",
     *                 description="Monto total del detalle"
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
     *                 example="El detalle de producto ha sido actualizado correctamente."
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
     *         description="Ha ocurrido un error al actualizar el detalle de producto",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al actualizar el detalle de producto."
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdProducto' => 'required|integer',
            'IdUsuario' => 'required|integer',
            'CantidadProductos' => 'required|integer',
            'PrecioUnitario' => 'required|numeric',
            'MontoTotal' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        DB::beginTransaction();

        try {
            $data = $request->all();
            $detalleProducto = DetalleProducto::findOrFail($id);
            $detalleProducto->update($data);

            DB::commit();

            return $this->sendResponse(null, 'El detalle de producto ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al actualizar el detalle de producto.', $e->getMessage());
        }
    }

    /**
     * Listado de detalles de productos
     * @OA\Get (
     *     path="/api/detalleproducto/index",
     *     tags={"DetalleProducto"},
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
     *                         property="IdDetalleProducto",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="IdProducto",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="IdUsuario",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="CantidadProductos",
     *                         type="integer",
     *                         example="5"
     *                     ),
     *                     @OA\Property(
     *                         property="PrecioUnitario",
     *                         type="number",
     *                         example="10.99"
     *                     ),
     *                     @OA\Property(
     *                         property="MontoTotal",
     *                         type="number",
     *                         example="54.95"
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
        $detallesProductos = DetalleProducto::all();
        return $this->sendResponse($detallesProductos, 'Todos los detalles de productos han sido listados correctamente.');
    }

    /**
     * Mostrar un detalle de producto específico
     * @OA\Get (
     *     path="/api/detalleproducto/id",
     *     tags={"DetalleProducto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del detalle de producto a mostrar",
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
     *                 property="IdDetalleProducto",
     *                 type="integer",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="IdProducto",
     *                 type="integer",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="IdUsuario",
     *                 type="integer",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="CantidadProductos",
     *                 type="integer",
     *                 example="5"
     *             ),
     *             @OA\Property(
     *                 property="PrecioUnitario",
     *                 type="number",
     *                 example="10.99"
     *             ),
     *             @OA\Property(
     *                 property="MontoTotal",
     *                 type="number",
     *                 example="54.95"
     *             ),
     *             @OA\Property(
     *                 property="created_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Fecha de creación del detalle de producto"
     *             ),
     *             @OA\Property(
     *                 property="updated_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Fecha de última actualización del detalle de producto"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error al mostrar el detalle de producto",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Ha ocurrido un error al mostrar el detalle de producto."
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        DB::beginTransaction();

        try {
            $detalleProducto = DetalleProducto::findOrFail($id);

            DB::commit();

            return $this->sendResponse($detalleProducto, 'Se ha listado el detalle de producto correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Ha ocurrido un error al mostrar el detalle de producto.', $e->getMessage());
        }
    }

    /**
     * Eliminar un detalle de producto específico
     * @OA\Delete (
     *     path="/api/detalleproducto/id/eliminar",
     *     tags={"DetalleProducto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del detalle de producto a eliminar",
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
     *                 example="El detalle de producto ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
* response=500,
* description="Ha ocurrido un error al eliminar el detalle de producto",
* @OA\JsonContent(
* @OA\Property(
* property="error",
* type="string",
* example="Ha ocurrido un error al eliminar el detalle de producto."
* )
* )
* )
* )
*/
public function destroy($id)
{
DB::beginTransaction();
    try {
        $detalleProducto = DetalleProducto::findOrFail($id);
        $detalleProducto->delete();

        DB::commit();

        return $this->sendResponse(null, 'El detalle de producto ha sido eliminado correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return $this->sendError('Ha ocurrido un error al eliminar el detalle de producto.', $e->getMessage());
    }
}
}