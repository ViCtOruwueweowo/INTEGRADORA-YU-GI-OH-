
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div id="formulariocarta" class="container mt-5">
    <form action="procesar_pedido2.php" method="post"> <!-- Nuevo formulario para enviar datos a procesar_pedido.php -->
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
            $sqlProductos = "SELECT CONCAT(cartas.nombre_c,' ', rareza.rareza) AS nombre, car_rar.id_cr, car_rar.p_beto FROM cartas inner join car_rar ON cartas.id_car=car_rar.id_carar INNER JOIN rareza ON car_rar.id_rar=rareza.id_ra ORDER BY cartas.nombre_c ASC";
            $resultProductos = $conn->query($sqlProductos);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
        ?>

        <div id="clienteFILTRAO" class="form-group">
            <label for="cliente">Selecciona un cliente:</label>
            <select class="form-control" name="id_cli" id="id_cli">
                <?php
                foreach ($resultClientes as $row) {
                    echo "<option name='id_cli' value='" . $row["id_cli"] . "'>" . $row["nom_cli"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div id="cartona">
        <div class="form-group">
            <label for="producto">Selecciona una carta:</label>
            <select class="form-control" name="id_cr" id="id_cr">
                <?php
                foreach ($resultProductos as $row) {
                    echo "<option name='id_pro' value='" . $row["id_cr"] . "' precio='" . $row["p_beto"] . "'>" . $row["nombre"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" min="1" class="form-control" name="cantidad_c" id="cantidad" placeholder="Cantidad" required>
        </div>

        <div class="form-group">
            <label for="notas">Notas:</label>
            <input type="text" class="form-control" name="notas" id="notas" value="COMPRA" placeholder="Ingrese notas extra para adjuntar a la orden de compra" required>
        </div>

        <?php
    echo '<input type="hidden" name="resultado" id="resultadoHidden">';
    ?>
    </div>

        <button type="submit" class="btn btn-primary">Enviar Pedido</button> <!-- Botón para enviar el formulario -->
    </form>

    <div id="resultado" class="mt-3">
        <!-- Aquí se mostrará el resultado de la multiplicación -->
    </div>
</div>

<!-- Agregar el script de Bootstrap y el script JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
var selectClienteElement = document.getElementById("id_cli");
var selectProductoElement = document.getElementById("id_cr");
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

<br><br>
<div class="container mt-5">
<button id="agregarFormulario" class="btn btn-primary">Agregar otro pedido</button>
</div>

<script>
    // Código JavaScript para repetir el formulario
    document.getElementById('agregarFormulario').addEventListener('click', function() {
        // Clonamos el formulario original
        var formContainer = document.getElementById('formulariocarta');
        var formOriginal = formContainer.querySelector('form');
        var formClone = formOriginal.cloneNode(true);

        // Reseteamos los valores de los campos clonados (opcional)
        var formFields = formClone.querySelectorAll('input');
        formFields.forEach(function(field) {
            field.value = '';
        });

        // Agregamos el formulario clonado al contenedor
        formContainer.appendChild(formClone);
    });
</script>

</body>
</html>











