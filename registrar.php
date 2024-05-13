<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set("error_log", "D:/xampp/htdocs/barberia/php_error.log");

$conexion = mysqli_connect('localhost', 'root', '', 'bdbarberia');

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $idrol = isset($_POST['idrol']) ? $_POST['idrol'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $firstlastname = isset($_POST['firstlastname']) ? $_POST['firstlastname'] : '';
    $secondlastname = isset($_POST['secondlastname']) ? $_POST['secondlastname'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Validar datos
    if (empty($name) || empty($email) || empty($password) || empty($idrol) || empty($phone)) {
        die(json_encode(["success" => false, "message" => "Error: Todos los campos son obligatorios"]));
    }

    // Verificar si las contraseñas coinciden
    if ($password !== $repeatPassword) {
        die(json_encode(["success" => false, "message" => "Error: Las contraseñas no coinciden"]));
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Sentencia preparada para evitar inyección SQL
    $query = "INSERT INTO users (name, email, password, idrol, firstname, firstlastname, secondlastname, phone) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $email, $hashed_password, $idrol, $firstname, $firstlastname, $secondlastname, $phone);

    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        echo json_encode(["success" => true, "message" => "Datos insertados correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al insertar datos", "error" => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Acceso no permitido"]);
}

mysqli_close($conexion);
?>
