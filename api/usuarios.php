<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto de XAMPP
$dbname = "goway";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener método de la solicitud
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtener usuarios
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);
        
        $usuarios = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        echo json_encode($usuarios);
        break;
        
    case 'POST':
        // Añadir nuevo usuario
        $data = json_decode(file_get_contents("php://input"), true);
        $nombre = $data['nombre'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Usuario creado correctamente"));
        } else {
            echo json_encode(array("error" => "Error al crear usuario"));
        }
        break;
        
    case 'PUT':
        // Actualizar usuario
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $nombre = $data['nombre'];
        $email = $data['email'];
        
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Usuario actualizado correctamente"));
        } else {
            echo json_encode(array("error" => "Error al actualizar usuario"));
        }
        break;
        
    case 'DELETE':
        // Eliminar usuario
        $id = $_GET['id'];
        $sql = "DELETE FROM usuarios WHERE id=$id";
        if ($conn->query($sql)) {
            echo json_encode(array("message" => "Usuario eliminado correctamente"));
        } else {
            echo json_encode(array("error" => "Error al eliminar usuario"));
        }
        break;
}

$conn->close();
?>