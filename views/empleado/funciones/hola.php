
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "2") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selección de Productos</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="../../../css/index2.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script></head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php" style="  color: whitesmoke;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;">WorkStack</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
    <div class="offcanvas-header" >
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label" >Mis Atajos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
     <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
        <li class="nav-item">
          <a type="button" class="nav-link" href="../calendario.php" data-bs-target="#staticBackdrop">
 Calendario 
</a>

          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background-color: transparent !important;
">
        Mi Inventario
          </a>
          <ul class="dropdown-menu" >
          <a href="listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
          </ul>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Agenda
          </a>
          <ul class="dropdown-menu">
          <li><a href="../ac.php" class="dropdown-item">Acreedores</a></li>
          <li><a href="../deuda_c.php" class="dropdown-item">Deudores Cartas</a></li>
          <li><a href="../deuda_p.php" class="dropdown-item">Deudores Productos</a></li>
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="hola2.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="hola.php">Venta Productos</a></li>
          </ul>
      </li>
     <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $nombreUsuario = $_SESSION['usuario']; echo "$nombreUsuario";?>
          </a>
          <ul class="dropdown-menu">
          <a href="../../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
        </ul>
    </div>
  </div>
</nav>

<div class="container mt-5" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550);
    box-shadow: 0 4px 5px rgba(10, 2, 1, 55);text-align:left;color:white">

<h4 class="text-center">Registrar Nueva Venta Producto</h4>
<br>
    <form action="procesar_pedido.php" method="post"> <!-- Nuevo formulario para enviar datos a procesar_pedido.php -->
        <?php
        // Conexión a la base de datos (reemplaza con tus propios datos de conexión)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "workstack";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta para obtener los datos de los clientes
            $sqlClientes = "SELECT id_cli, nom_cli FROM clientes";
            $resultClientes = $conn->query($sqlClientes);

            // Consulta para obtener los datos de los productos
            $sqlProductos = "SELECT id_pro, nom_p, precio FROM productos";
            $resultProductos = $conn->query($sqlProductos);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
        ?>

        <div class="form-group">
            <label for="cliente">Selecciona un cliente:</label>
            <select class="form-control" name="id_cli" id="id_cli">
                <?php
                foreach ($resultClientes as $row) {
                    echo "<option name='id_cli' value='" . $row["id_cli"] . "'>" . $row["nom_cli"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="producto">Selecciona un producto:</label>
            <select class="form-control" name="id_pro" id="id_pro">
                <?php
                foreach ($resultProductos as $row) {
                    echo "<option name='id_pro' value='" . $row["id_pro"] . "' precio='" . $row["precio"] . "'>" . $row["nom_p"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" min="1" class="form-control" name="cantidad_p" id="cantidad" placeholder="Cantidad" required>
        </div>

        <div class="form-group">
            <label for="notas">Notas:</label>
            <input type="text" class="form-control" name="notas" id="notas" value="COMPRA" placeholder="Ingrese notas extra para adjuntar a la orden de compra" required>
        </div>

        <?php
    echo '<input type="hidden" name="resultado" id="resultadoHidden">';
    ?>
<br>
        <button type="submit" class="btn btn-primary">Enviar Pedido</button> <!-- Botón para enviar el formulario -->
    </form>
    <br>

    <div id="resultado" class="mt-3">
        <!-- Aquí se mostrará el resultado de la multiplicación -->
    </div>
</div>

<!-- Agregar el script de Bootstrap y el script JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
var selectClienteElement = document.getElementById("id_cli");
var selectProductoElement = document.getElementById("id_pro");
var cantidadElement = document.getElementById("cantidad");
var resultadoElement = document.getElementById("resultado");

selectClienteElement.addEventListener("change", function() {
    // Puedes acceder al valor seleccionado y utilizarlo en tu lógica
});

selectProductoElement.addEventListener("change", function() {
    actualizarResultado();
});

cantidadElement.addEventListener("input", function() {
    actualizarResultado();
});

function actualizarResultado() {
    var selectedOption = selectProductoElement.options[selectProductoElement.selectedIndex];
    var precio = parseFloat(selectedOption.getAttribute("precio"));

    var cantidad = parseFloat(cantidadElement.value);

    if (!isNaN(precio) && !isNaN(cantidad)) {
        var resultado = precio * cantidad;
        resultadoElement.innerHTML = "Total: $" + resultado.toFixed(2);
        document.getElementById("resultadoHidden").value = resultado.toFixed(2); // Actualizar el campo oculto
    } else {
        resultadoElement.innerHTML = "Total: "; // Dejar el div vacío
        document.getElementById("resultadoHidden").value = ''; // Dejar el campo oculto en blanco
    }
}

</script>

</body>
</html>
