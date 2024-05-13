<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleProducto extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Nombre de la tabla en la base de datos
    protected $table = 'detallesproducto';

    // Especifica el nombre de la columna de la clave primaria
    protected $primaryKey = 'IdDetalleProducto';

    // Nombre de atributos en la base de datos
    protected $fillable = [
        'IdProducto', // Adecuar el nombre del atributo según tu tabla
        'IdUsuario', // Adecuar el nombre del atributo según tu tabla
        'CantidadProductos',
        'PrecioUnitario',
        'MontoTotal',
    ];

    // Define los campos de fecha que se utilizarán para marcar las fechas de creación, actualización y eliminación
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'IdProducto'); // Adecuar el nombre del atributo según tu tabla
    }

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario'); // Adecuar el nombre del atributo según tu tabla
    }
}
