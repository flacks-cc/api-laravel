<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Reservacion",
 *     type="object",
 *     @OA\Property(
 *         property="idReservacion",
 *         type="integer",
 *         description="ID de la reservación"
 *     ),
 *     @OA\Property(
 *         property="idUsuario",
 *         type="integer",
 *         description="ID del usuario asociado a la reservación"
 *     ),
 *     @OA\Property(
 *         property="fechaReserva",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de la reservación"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación de la reservación"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización de la reservación"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de eliminación de la reservación"
 *     )
 * )
 */
class Reservacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'reservaciones';
    protected $primaryKey = 'IdReservacion';
    protected $fillable = [
        'IdUsuario',
        'FechaReserva',
        'IdServicio',  // Agrega la columna de la clave foránea
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }

    // Relación con el modelo Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'IdServicio');
    }
}
