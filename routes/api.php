<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| En este archivo, puedes registrar las rutas de la API para tu aplicación.
| Estas rutas se cargan a través del RouteServiceProvider dentro del grupo 'api',
| al cual se le asigna el middleware "api". ¡Disfruta construyendo tu API!
|
*/

// Rutas de autenticación del usuario
Route::post('register', [App\Http\Controllers\Api\RegistroController::class, 'register']);
Route::post('login', [App\Http\Controllers\Api\RegistroController::class, 'login']);
Route::put('update/{id}', [App\Http\Controllers\Api\RegistroController::class, 'update']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('/show', [App\Http\Controllers\Api\RegistroController::class, 'show']); // Ruta para mostrar información del usuario autenticado
    });

    Route::group(['prefix' => 'empleado'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\EmpleadoController::class, 'create']); // Ruta para crear un nuevo empleado
        Route::put('/idEmpleado/editar', [App\Http\Controllers\Api\EmpleadoController::class, 'update']); // Ruta para actualizar un empleado por su ID
        Route::get('/index', [App\Http\Controllers\Api\EmpleadoController::class, 'index']); // Ruta para obtener una lista de empleados
        Route::get('/idEmpleado', [App\Http\Controllers\Api\EmpleadoController::class, 'show']); // Ruta para mostrar un empleado específico por su ID
        Route::get('/idEmpleado/eliminar', [App\Http\Controllers\Api\EmpleadoController::class, 'delete']); // Ruta para eliminar un empleado
        Route::post('/buscarVenta/{idEmpleado}', [App\Http\Controllers\Api\EmpleadoController::class, 'buscarVentaEmpleado']);
    });

    Route::group(['prefix' => 'cliente'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\ClienteController::class, 'create']); // Ruta para crear un nuevo cliente
        Route::put('/idCliente/editar', [App\Http\Controllers\Api\ClienteController::class, 'updated']); // Ruta para actualizar un cliente por su ID
        Route::get('/index', [App\Http\Controllers\Api\ClienteController::class, 'index']); // Ruta para obtener una lista de clientes
        Route::get('/idCliente', [App\Http\Controllers\Api\ClienteController::class, 'show']); // Ruta para mostrar un cliente específico por su ID
        Route::delete('/idCliente/eliminar', [App\Http\Controllers\Api\ClienteController::class, 'delete']); // Ruta para eliminar un cliente
    });

    Route::group(['prefix' => 'categoria'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\CategoriaController::class, 'create']); // Ruta para crear una nueva categoría
        Route::put('/idCategoria/editar', [App\Http\Controllers\Api\CategoriaController::class, 'update']); // Ruta para actualizar una categoría por su ID
        Route::get('/index', [App\Http\Controllers\Api\CategoriaController::class, 'index']); // Ruta para obtener una lista de categorías
        Route::get('/idCategoria', [App\Http\Controllers\Api\CategoriaController::class, 'show']); // Ruta para mostrar una categoría específica por su ID
        Route::delete('/idCategoria/eliminar', [App\Http\Controllers\Api\CategoriaController::class, 'destroy']); // Ruta para eliminar una categoría
    });

    Route::group(['prefix' => 'cliente'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\ClienteController::class, 'create']); // Ruta para crear un nuevo cliente
        Route::put('/idCliente/editar', [App\Http\Controllers\Api\ClienteController::class, 'update']); // Ruta para actualizar un cliente por su ID
        Route::get('/index', [App\Http\Controllers\Api\ClienteController::class, 'index']); // Ruta para obtener una lista de clientes
        Route::get('/idCliente', [App\Http\Controllers\Api\ClienteController::class, 'show']); // Ruta para mostrar un cliente específico por su ID
        Route::delete('/idCliente/eliminar', [App\Http\Controllers\Api\ClienteController::class, 'delete']); // Ruta para eliminar un cliente
    });

    Route::group(['prefix' => 'detallegeneral'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\DetalleGeneralController::class, 'create']);
        Route::put('/idDetalleGeneral/editar', [App\Http\Controllers\Api\DetalleGeneralController::class, 'update']);
        Route::get('/index', [App\Http\Controllers\Api\DetalleGeneralController::class, 'index']);
        Route::get('/idDetalleGeneral', [App\Http\Controllers\Api\DetalleGeneralController::class, 'show']);
        Route::delete('/idDetalleGeneral/eliminar', [App\Http\Controllers\Api\DetalleGeneralController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'detalleproducto'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\DetalleProductoController::class, 'create']);
        Route::put('/id/editar', [App\Http\Controllers\Api\DetalleProductoController::class, 'update']);
        Route::get('/index', [App\Http\Controllers\Api\DetalleProductoController::class, 'index']);
        Route::get('/id', [App\Http\Controllers\Api\DetalleProductoController::class, 'show']);
        Route::delete('/id/eliminar', [App\Http\Controllers\Api\DetalleProductoController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'reservacion'], function () {
        Route::post('/nueva', [App\Http\Controllers\Api\ReservacionController::class, 'create']);
        Route::put('/idReservacion/editar', [App\Http\Controllers\Api\ReservacionController::class, 'update']);
        Route::get('/index', [App\Http\Controllers\Api\ReservacionController::class, 'index']);
        Route::get('/idReservacion', [App\Http\Controllers\Api\ReservacionController::class, 'show']);
        Route::delete('/idReservacion/eliminar', [App\Http\Controllers\Api\ReservacionController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'rol'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\RolesController::class, 'create']);
        Route::put('/idRol/editar', [App\Http\Controllers\Api\RolesController::class, 'update']);
        Route::get('/index', [App\Http\Controllers\Api\RolesController::class, 'index']);
        Route::get('/idRol', [App\Http\Controllers\Api\RolesController::class, 'show']);
        Route::delete('/idRol/eliminar', [App\Http\Controllers\Api\RolesController::class, 'destroy']);
    });

    Route::group(['prefix' => 'servicio'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\ServicioController::class, 'create']);
        Route::put('/idServicio/editar', [App\Http\Controllers\Api\ServicioController::class, 'update']);
        Route::get('/index', [App\Http\Controllers\Api\ServicioController::class, 'index']);
        Route::get('/idServicio', [App\Http\Controllers\Api\ServicioController::class, 'show']);
        Route::delete('/idServicio/eliminar', [App\Http\Controllers\Api\ServicioController::class, 'destroy']);
    });

    Route::group(['prefix' => 'ticket'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\TicketController::class, 'create']);
        Route::put('/idTicket/editar', [App\Http\Controllers\Api\TicketController::class, 'update']);
        Route::get('/index', [App\Http\Controllers\Api\TicketController::class, 'index']);
        Route::get('/idTicket', [App\Http\Controllers\Api\TicketController::class, 'show']);
        Route::delete('/idTicket/eliminar', [App\Http\Controllers\Api\TicketController::class, 'destroy']);
    });

    Route::group(['prefix' => 'producto'], function () {
        Route::post('/nuevo', [App\Http\Controllers\Api\ProductoController::class, 'create']); // Ruta para crear un nuevo producto
        Route::put('/idProducto/editar', [App\Http\Controllers\Api\ProductoController::class, 'update']); // Ruta para actualizar un producto por su ID
        Route::get('/index', [App\Http\Controllers\Api\ProductoController::class, 'index']); // Ruta para obtener una lista de productos
        Route::get('/idProducto', [App\Http\Controllers\Api\ProductoController::class, 'show']); // Ruta para mostrar un producto específico por su ID
        Route::delete('/idProducto/eliminar', [App\Http\Controllers\Api\ProductoController::class, 'destroy']); // Ruta para eliminar un producto
    });

    Route::group(['prefix' => 'producto'], function () {
            Route::post('/buscarNombre', [App\Http\Controllers\Api\ProductoController::class, 'buscarProductoNombre']);
            Route::post('/buscarCategoria', [App\Http\Controllers\Api\ProductoController::class, 'buscarProductoCategoria']);
    });
