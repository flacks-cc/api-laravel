<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Servicio",
 *     type="object",
 *     @OA\Property(
 *         property="idServicio",
 *         type="integer",
 *         description="ID del servicio"
 *     ),
 *     @OA\Property(
 *         property="precio",
 *         type="integer",
 *         description="Precio del servicio"
 *     ),
 *     @OA\Property(
 *         property="nombreServicio",
 *         type="string",
 *         description="Nombre del servicio"
 *     ),
 *     @OA\Property(
 *         property="duracion",
 *         type="string",
 *         format="time",
 *         description="Duración del servicio"
 *     ),
 *     @OA\Property(
 *         property="descripcion",
 *         type="string",
 *         description="Descripción del servicio"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación del servicio"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización del servicio"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de eliminación del servicio"
 *     )
 * )
 */
class Servicio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'servicios';
    protected $primaryKey = 'IdServicio';
    protected $fillable = [
        'Precio',
        'NombreServicio',
        'Duracion',
        'Descripcion',
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'IdServicio');
    }
}
