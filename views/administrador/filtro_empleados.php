<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filtro = $_POST["filtro"];

    try {
        // Preparar la consulta SQL filtrada
        $stmt = $conexio->prepare("SELECT * FROM usuarios WHERE columna LIKE :filtro");
        $stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
        $stmt->execute();

        // Verificar si se encontraron resultados
        if ($stmt->rowCount() > 0) {
            // Mostrar los resultados en una tabla HTML
            echo "<table>";
            echo "<tr><th>Columna 1</th><th>Columna 2</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["columna1"] . "</td>";
                echo "<td>" . $row["columna2"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }
    } catch(PDOException $e) {
        echo "Error al ejecutar la consulta: " . $e->getMessage();
    }
}
?>