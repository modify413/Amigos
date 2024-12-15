<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener el código del formulario
$codigoAcceso = $_POST['codigo'];

// Consulta para buscar el usuario por codigoAcceso
$sql = "SELECT nombre, idAmigo FROM amigos WHERE codigoAcceso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codigoAcceso);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si se encuentra un usuario con el código
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $idAmigo = $row['idAmigo'];

    // Buscar el nombre del amigo usando el idAmigo
    $sqlAmigo = "SELECT nombre FROM amigos WHERE id = ?";
    $stmtAmigo = $conn->prepare($sqlAmigo);
    $stmtAmigo->bind_param("i", $idAmigo);
    $stmtAmigo->execute();
    $resultAmigo = $stmtAmigo->get_result();

    if ($resultAmigo->num_rows > 0) {
        $rowAmigo = $resultAmigo->fetch_assoc();
        $nombreAmigo = $rowAmigo['nombre'];

        // Mostrar el mensaje con los nombres
        echo "<div class='container'>
                <h1>$nombre, tu amigo invisible es: $nombreAmigo</h1>
              </div>";
    } else {
        // En caso de que el idAmigo no tenga un amigo relacionado
        echo "<div class='container'>
                <h1>$nombre, no se pudo encontrar a tu amigo invisible. Contacta al administrador.</h1>
              </div>";
    }
} else {
    // Si el código no es válido
    echo "<div class='container'>
            <h1>Código no encontrado. Intenta nuevamente.</h1>
          </div>";
}

// Cerrar las conexiones
$stmt->close();
$conn->close();
?>

<!-- Estilos CSS -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #92a8d1;
        margin: 0;
        padding: 0;
    }
    
    .container {
        width: 80%;
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-radius: 10px;
    }

    h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .btn {
        background-color: #4CAF50;
        color: cyan;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin-top: 20px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .error {
        color: #ff0000;
        font-size: 18px;
        font-weight: bold;
    }

    .success {
        color: #28a745;
        font-size: 18px;
        font-weight: bold;
    }
</style>
