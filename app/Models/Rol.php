<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Rol",
 *     type="object",
 *     @OA\Property(
 *         property="idRol",
 *         type="integer",
 *         description="ID del rol"
 *     ),
 *     @OA\Property(
 *         property="nombreRol",
 *         type="string",
 *         description="Nombre del rol"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación del rol"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización del rol"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de eliminación del rol"
 *     )
 * )
 */
class Rol extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    // Nombre de la tabla en la base de datos
    protected $table = 'roles'; 
    
    // Nombre de la clave primaria
    protected $primaryKey = 'idRol'; 

    // Nombre de atributos en la base de datos
    protected $fillable = [
        'nombreRol',
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
