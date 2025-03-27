
<?php 
$conexion = new mysqli('localhost', 'root', '', 'goway', '3306');

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar el juego de caracteres a UTF-8
$conexion->set_charset('utf8_bin');
?>
