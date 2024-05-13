<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleGeneral extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Nombre de la tabla en la base de datos
    protected $table = 'detallesgenerales';

    // Especifica el nombre de la columna de la clave primaria
    protected $primaryKey = 'IdDetallesGeneral';

    // Nombre de atributos en la base de datos
    protected $fillable = [
        'IdEmpleado',
        'IdReservacion',
        'IdDetalleProducto',
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'IdEmpleado');
    }

    // Relación con el modelo Reservacion
    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class, 'IdReservacion');
    }

    // Relación con el modelo DetalleProducto
    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'IdDetalleProducto');
    }
}
