<?php
// configuracion.php
session_start();

// Configuración
$adminPassword = "12345"; // Contraseña de administrador predefinida

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "amigosdb");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificación de la contraseña de administrador
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $adminPassword) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            echo "<p>Contraseña incorrecta.</p>";
        }
    }

    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        echo '<form method="post">
                <label for="password">Contraseña de administrador:</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Ingresar</button>
              </form>';
        exit;
    }
}

// Deslogueo
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: configuracion.php");
    exit;
}

// Operaciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $nombre = $_POST['nombre'];
                $codigoAcceso = rand(10000, 99999);
                $sql = "INSERT INTO amigos (nombre, codigoAcceso) VALUES ('$nombre', '$codigoAcceso')";
                $conn->query($sql);
                break;

            case 'update':
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $idAmigo = $_POST['idAmigo'];
                $sql = "UPDATE amigos SET nombre='$nombre', idAmigo=$idAmigo WHERE id=$id";
                $conn->query($sql);
                break;

            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM amigos WHERE id=$id";
                $conn->query($sql);
                break;

            case 'randomize':
                $result = $conn->query("SELECT id FROM amigos");
                $ids = [];
                while ($row = $result->fetch_assoc()) {
                    $ids[] = $row['id'];
                }

                shuffle($ids);
                for ($i = 0; $i < count($ids); $i++) {
                    $idAmigo = $ids[($i + 1) % count($ids)];
                    $id = $ids[$i];
                    $conn->query("UPDATE amigos SET idAmigo=$idAmigo WHERE id=$id");
                }
                echo "<p>Asignaciones aleatorias completadas.</p>";
                break;
        }
    }
}

// Mostrar tabla de amigos
$result = $conn->query("SELECT * FROM amigos");

echo '<table border="1">';
echo '<tr><th>ID</th><th>Nombre</th><th>ID Amigo</th><th>Código Acceso</th><th>Acciones</th></tr>';
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['idAmigo']}</td>
            <td>{$row['codigoAcceso']}</td>
            <td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <input type='hidden' name='action' value='delete'>
                    <button type='submit'>Eliminar</button>
                </form>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <input type='text' name='nombre' value='{$row['nombre']}'>
                    <input type='number' name='idAmigo' value='{$row['idAmigo']}'>
                    <input type='hidden' name='action' value='update'>
                    <button type='submit'>Actualizar</button>
                </form>
            </td>
          </tr>";
}
echo '</table>';

// Formulario para agregar nuevo amigo
echo '<form method="post">
        <h3>Agregar nuevo amigo</h3>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="hidden" name="action" value="add">
        <button type="submit">Agregar</button>
      </form>';

// Botón para randomizar amigos
echo '<form method="post">
        <input type="hidden" name="action" value="randomize">
        <button type="submit">Randomizar amigos</button>
      </form>';

// Botones de volver y deslogueo
echo '<form method="post" style="display:inline;">
        <button type="submit" name="logout">Cerrar sesión</button>
      </form>';
echo '<form action="index.php" style="display:inline;">
        <button type="submit">Volver</button>
      </form>';

$conn->close();
?>
