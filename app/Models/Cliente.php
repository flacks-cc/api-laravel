<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Cliente",
 *     type="object",
 *     @OA\Property(
 *         property="idCliente",
 *         type="integer",
 *         description="ID del cliente"
 *     ),
 *     @OA\Property(
 *         property="nombreCliente",
 *         type="string",
 *         description="Nombre del cliente"
 *     ),
 *     @OA\Property(
 *         property="correo",
 *         type="string",
 *         description="Correo del cliente"
 *     ),
 *     @OA\Property(
 *         property="idUsuario",
 *         type="integer",
 *         description="ID del usuario asociado al cliente"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación del cliente"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización del cliente"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de eliminación del cliente"
 *     )
 * )
 */
class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    // Nombre de la tabla en la base de datos
    protected $table = 'clientes'; 
    
    // Nombre de la clave primaria
    protected $primaryKey = 'idCliente';
    
    // Nombre de atributos en la base de datos
    protected $fillable = [
        'nombreCliente',
        'correo',
        'idUsuario', // Añade el campo 'idUsuario' al array fillable
    ];
    
    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Define la relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
}
