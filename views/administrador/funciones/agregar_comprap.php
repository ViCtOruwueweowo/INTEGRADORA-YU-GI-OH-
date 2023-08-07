
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
<!DOCTYPE html>
<html>
<head>
    <title>Compra Productos</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap -->
<link rel="stylesheet" href="../../../css/bootstrap.min.css">
<link rel="stylesheet" href="../../../css/index2.css">
<script src="../../../js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="../empleados.php">Empleados</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listarPersonasConBusqueda.php">Inventario Carta</a></li>
            <li><a class="dropdown-item" href="listarPersonasConBusqueda2.php">Inventario Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agenda
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../acreedores.php">Mis Acreedores</a></li>
            <li><a class="dropdown-item" href="../deudores_cartas.php">Mis Deudores Cartas</a></li>
            <li><a class="dropdown-item" href="../deudores_productos.php">Mis Deudores Productos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_cliente.php">Agregar Cliente</a></li>
            <li><a class="dropdown-item" href="../funciones/modificar_cliente.php">Modificar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="agregar_comprac.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="agregar_comprap.php">Venta Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Registro
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../bitacoras/upd_cartas.php">Actualizaciones En Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_productos.php">Actualizaciones En Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dc.php">Reporte Deuda Cartas</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Deuda Productos</a></li>
            <li><a class="dropdown-item" href="../bitacoras/upd_dp.php">Reporte Acreedores</a></li>

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
    </div>
  </nav>

<br>
<div class="container mt-5">
    <form action="procesar_pedidop.php" method="post"> <!-- Nuevo formulario para enviar datos a procesar_pedido.php -->
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
