<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Categoria",
 *     type="object",
 *     @OA\Property(
 *         property="idCategoria",
 *         type="integer",
 *         description="ID de la categoría"
 *     ),
 *     @OA\Property(
 *         property="nombreCategoria",
 *         type="string",
 *         description="Nombre de la categoría"
 *     ),
 *     @OA\Property(
 *         property="descripcionCategoria",
 *         type="string",
 *         description="Descripción de la categoría"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación de la categoría"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización de la categoría"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de eliminación de la categoría"
 *     )
 * )
 */
class Categoria extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    // Nombre de la tabla en la base de datos
    protected $table = 'categorias';  // Corregir el nombre de la tabla en minúsculas
    
    // Nombre de la clave primaria
    protected $primaryKey = 'IdCategoria';  // Nombre de la clave primaria

    // Nombre de atributos en la base de datos
    protected $fillable = [
        'NombreCategoria',
        'DescripcionCategoria',
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
