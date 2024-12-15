<?php
// Incluir la conexión a la base de datos
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Invisible</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }
        #configuracion {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 16px;
            text-decoration: none;
            color: #007BFF;
            cursor: pointer;
        }
        #configuracion:hover {
            text-decoration: underline;
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
        }
        form {
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Enlace de configuración -->
    <a id="configuracion" href="configuracion.php">Configuración</a>
    
    <!-- Título principal -->
    <h1>Ingresa tu código para saber tu amigo invisible</h1>
    
    <!-- Formulario -->
    <form action="amigo.php" method="POST">
        <input type="text" name="codigo" placeholder="Ingresa tu código" required>
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
