<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Nombre de la tabla en la base de datos
    protected $table = 'ticket';

    // Especifica el nombre de la columna de la clave primaria
    protected $primaryKey = 'Idticket';

    // Nombre de atributos en la base de datos
    protected $fillable = [
        'IdDetallesGeneral',
        'fecha',
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'fecha'];

    // Relación con el modelo DetalleGeneral
    public function detallesGeneral()
    {
        return $this->belongsTo(DetalleGeneral::class, 'IdDetallesGeneral');
    }
}
