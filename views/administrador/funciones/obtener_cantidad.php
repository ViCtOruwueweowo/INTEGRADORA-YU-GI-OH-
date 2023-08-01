<?php
// obtener_cantidad.php

// Reemplaza estos valores con la información de tu base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$basedatos = 'workstack';

$id_cr = $_POST['id_cr']; // Obtener el id_cr seleccionado

try {
  $conexion = new PDO("mysql:host=$host;dbname=$basedatos", $usuario, $contrasena);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Consulta para obtener la cantidad actual por id_cr
  $consulta = "SELECT cantidad FROM car_rar WHERE id_cr = :id_cr";
  $stmt = $conexion->prepare($consulta);
  $stmt->bindParam(':id_cr', $id_cr, PDO::PARAM_INT);
  $stmt->execute();

  // Obtener el resultado
  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($resultado) {
    echo $resultado['cantidad']; // Devolver el valor de cantidad
  } else {
    echo ""; // Si no hay resultado, devolver un valor vacío
  }
} catch (PDOException $e) {
  echo ""; // En caso de error, devolver un valor vacío
}
?>
