<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'jquery_prueba';

$conn = new mysqli($host, $user, $pass, $db);   
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$conn -> set_charset("utf8");
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == 'GET')
{
   $resultado = $conn->query("SELECT * FROM usuarios ORDER BY id DESC");
    $usuarios = [];
    while ($row = $resultado->fetch_assoc()) {
        $usuarios[] = $row;
    }
    echo json_encode($usuarios);
}

elseif ($metodo == 'POST'){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email) VALUES (?, ?, ?)");
    $stmt -> bind_param("sss", $nombre, $apellido, $email);

    if ($stmt -> execute()){
        echo json_encode (["id" => $conn->insert_id, "nombre" => $nombre, "apellido" => $apellido, "email" => $email]);
    } else {
        echo json_encode(["error" => "No se pudo insertar el registro: " . $stmt->error]);
    }
    $stmt -> close();
}

$conn -> close();

?>