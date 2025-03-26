<?php
include("../config/conexion_bd.php"); // Conexión a la base de datos

// Verificar si se envió el formulario
if (isset($_POST['btningresar'])) {
    // Verificar campos vacíos
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error_message'] = "⚠️ Los campos no pueden estar vacíos";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Consulta preparada para evitar SQL injection
        $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "⚠️ Usuario o contraseña incorrectos";
        }
    }
    
    // Redirigir para evitar reenvío del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>