<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class ProductoController extends BaseController
{
    /**
     * Crear un nuevo producto
     * @OA\Post (
     *     path="/api/producto/nuevo",
     *     tags={"Producto"},
     *     @OA\RequestBody(
     *         description="Datos necesarios para crear un nuevo producto",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Se ha creado el registro de producto correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Los datos a validar no son correctos.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Los datos a validar no son correctos."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 additionalProperties={
     *                     "type": "string"
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        $data = $request->all();
        $producto = new Producto($data);
        $producto->save();

        return $this->sendResponse(null, 'Se ha creado el registro de producto correctamente.');
    }

    /**
     * Actualizar un producto existente
     * @OA\Put (
     *     path="/api/producto/idProducto/editar",
     *     tags={"Producto"},
     *     @OA\Parameter(
     *         name="idProducto",
     *         in="path",
     *         description="ID del producto a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Datos necesarios para actualizar un producto existente",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="El registro de producto ha sido actualizado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Los datos a validar no son correctos.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Los datos a validar no son correctos."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 additionalProperties={
     *                     "type": "string"
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idProducto)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        $data = $request->all();
        $producto = Producto::findOrFail($idProducto);
        $producto->update($data);

        return $this->sendResponse(null, 'El registro de producto ha sido actualizado correctamente.');
    }

    /**
     * Listar todos los productos
     * @OA\Get (
     *     path="/api/producto/index",
     *     tags={"Producto"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Listado de productos obtenido correctamente."
     *             ),
     *             @OA\Property(
     *                 property="productos",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Producto")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $productos = Producto::all();
        return $this->sendResponse(['productos' => $productos], 'Listado de productos obtenido correctamente.');
    }

    /**
     * Mostrar un producto específico
     * @OA\Get (
     *     path="/api/producto/idProducto",
     *     tags={"Producto"},
     *     @OA\Parameter(
     *         name="idProducto",
     *         in="path",
     *         description="ID del producto a mostrar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró el producto.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No se encontró el producto."
     *             )
     *         )
     *     )
     * )
     */
    public function show($idProducto)
    {
        $producto = Producto::find($idProducto);

        if (is_null($producto)) {
            return $this->sendError('No se encontró el producto.');
        }

        return $this->sendResponse(['producto' => $producto], 'Producto obtenido correctamente.');
    }

    /**
     * Eliminar un producto específico
     * @OA\Delete (
     *     path="/api/producto/idProducto/eliminar",
     *     tags={"Producto"},
     *     @OA\Parameter(
     *         name="idProducto",
     *         in="path",
     *         description="ID del producto a eliminar",
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
     *                 example="El registro de producto ha sido eliminado correctamente."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró el producto.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No se encontró el producto."
     *             )
     *         )
     *     )
     * )
     */
    public function destroy($idProducto)
    {
        $producto = Producto::find($idProducto);

        if (is_null($producto)) {
            return $this->sendError('No se encontró el producto.');
        }

        $producto->delete();

        return $this->sendResponse(null, 'El registro de producto ha sido eliminado correctamente.');
    }

    /**
     * Buscar un producto por su categoría
     * @OA\Post (
     *     path="/api/producto/buscarCategoria",
     *     tags={"Producto"},
     *     @OA\RequestBody(
     *         description="Nombre de la categoría para buscar",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="nombreCategoria",
     *                 type="string",
     *                 example="Pastel",
     *                 description="Nombre de la categoría"
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
     *                 example="Categorías encontradas correctamente."
     *             ),
     *             @OA\Property(
     *                 property="categoria",
     *                 ref="#/components/schemas/Categoria"
     *             ),
     *             @OA\Property(
     *                 property="productos",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Producto")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron categorías con ese nombre",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No se encontraron categorías con ese nombre."
     *             )
     *         )
     *     )
     * )
     */
    public function buscarProductoCategoria(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreCategoria' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Los datos a validar no son correctos.', $validator->errors());
        }

        $nombreCategoria = $request->input('nombreCategoria');
        $categoria = Categoria::where('nombreCategoria', $nombreCategoria)->first();

        if (is_null($categoria)) {
            return $this->sendError('No se encontraron categorías con ese nombre.');
        }

        $productos = Producto::where('idCategoria', $categoria->idCategoria)->get();

        return $this->sendResponse(['categoria' => $categoria, 'productos' => $productos], 'Categorías encontradas correctamente.');
    }

    /**
     * Obtener reglas de validación para Producto
     *
     * @return array
     */
    private function getValidationRules()
    {
        return [
            'nombreProducto' => 'required|string|max:100',
            'descripcionProducto' => 'string|max:255',
            'cantidadInventario' => 'integer',
            'precioProducto' => 'numeric',
            'idCategoria' => 'required|integer|exists:categorias,idCategoria',
        ];
    }
}
