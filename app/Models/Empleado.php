<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Define la tabla de la base de datos a la que se asocia este modelo
    protected $table = 'empleados';

    // Especifica el nombre de la columna de la clave primaria
    protected $primaryKey = 'idEmpleado';

    // Especifica los campos que se pueden llenar con datos
    protected $fillable = [
        'Salario',
        'nombreEmpleado', // Cambiado de 'NombreEmpleado' a 'nombreEmpleado'
        'IdUsuario'
        // Agregar más campos si es necesario
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }
}
