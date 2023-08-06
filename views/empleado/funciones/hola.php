<!DOCTYPE html>
<html>
<head>
    <title>Selección de Productos</title>
    <!-- Agregar enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
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
            <select class="form-control" name="cliente" id="cliente">
                <?php
                foreach ($resultClientes as $row) {
                    echo "<option name='id_cli' value='" . $row["id_cli"] . "'>" . $row["nom_cli"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="producto">Selecciona un producto:</label>
            <select class="form-control" name="producto" id="producto">
                <?php
                foreach ($resultProductos as $row) {
                    echo "<option name='id_pro' value='" . $row["id_pro"] . "' precio='" . $row["precio"] . "'>" . $row["nom_p"] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="text" class="form-control" name="cantidad_p" id="cantidad" placeholder="Cantidad">
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
var selectClienteElement = document.getElementById("cliente");
var selectProductoElement = document.getElementById("producto");
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
        resultadoElement.textContent = "Total: $" + resultado.toFixed(2);
    } else {
        resultadoElement.textContent = "Total: ";
    }
}
</script>

</body>
</html>
