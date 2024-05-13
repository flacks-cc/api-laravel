<?php

error_log("Datos recibidos: " . print_r($_POST, true));

// Configurar la visualización de errores en el navegador
ini_set('display_errors', 1);
ini_set('log_errors', 1);
// Configurar la ubicación del archivo de registro de errores
ini_set("error_log", "D:/xampp/htdocs/panaderia/php_error.log");

$conexion = mysqli_connect('localhost', 'root', '', 'bdbarberia');

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegurarse de que se están enviando datos POST
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conexion, $_POST['name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conexion, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conexion, $_POST['password']) : '';
    $repeatpassword = isset($_POST['repeatpassword']) ? mysqli_real_escape_string($conexion, $_POST['repeatpassword']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conexion, $_POST['phone']) : '';

    // Validar datos (puedes agregar más validaciones según tus necesidades)
    if (empty($name) || empty($email) || empty($password) || empty($repeatpassword) || empty($phone)) {
        die("Error: Todos los campos son obligatorios");
    }

    // Verificar si las contraseñas coinciden
    if ($password !== $repeatpassword) {
        die("Error: Las contraseñas no coinciden");
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Evitar la inserción de la contraseña repetida en la base de datos
    // La contraseña repetida no debería almacenarse en la base de datos
    $query = "INSERT INTO users (name, email, password, phone) VALUES ('$name', '$email', '$hashed_password', '$phone')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "Datos insertados correctamente";
    } else {
        echo "Error al insertar datos: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no permitido";
}

mysqli_close($conexion);
?>
