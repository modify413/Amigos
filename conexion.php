<?php
// Configuración de la conexión
$host = "localhost"; // Host (generalmente 'localhost')
$user = "tu_usuario";      // Usuario de la base de datos
$password = "tu_contraseña";;      // Contraseña del usuario (vacía por defecto en servidores locales)
$dbname = "amigosdb"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Conexión exitosa

?>
