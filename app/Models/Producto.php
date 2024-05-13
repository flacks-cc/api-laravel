<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Producto",
 *     type="object",
 *     @OA\Property(
 *         property="idProducto",
 *         type="integer",
 *         description="ID del producto"
 *     ),
 *     @OA\Property(
 *         property="nombreProducto",
 *         type="string",
 *         description="Nombre del producto"
 *     ),
 *     @OA\Property(
 *         property="precio",
 *         type="integer",
 *         description="Precio del producto"
 *     ),
 *     @OA\Property(
 *         property="descripcionProducto",
 *         type="string",
 *         description="Descripción del producto"
 *     ),
 *     @OA\Property(
 *         property="stock",
 *         type="integer",
 *         description="Cantidad en inventario"
 *     ),
 *     @OA\Property(
 *         property="idCategoria",
 *         type="integer",
 *         description="ID de la categoría del producto"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación del producto"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización del producto"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de eliminación del producto"
 *     )
 * )
 */
class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    // Nombre de la tabla en la base de datos
    protected $table = 'productos';

    // Nombre de la clave primaria
    protected $primaryKey = 'IdProducto'; 
    
    // Nombre de atributos en la base de datos
    protected $fillable = [
        'NombreProducto', // Adecuar el nombre del atributo según tu tabla
        'Precio', // Adecuar el nombre del atributo según tu tabla
        'DescripcionProducto',
        'Stock', // Adecuar el nombre del atributo según tu tabla
        'IdCategoria',
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con el modelo Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria');
    }
}
