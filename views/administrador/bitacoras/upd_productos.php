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
require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();

$filtroCliente = isset($_GET['filtro_cliente']) ? $_GET['filtro_cliente'] : null;

// Obtén las opciones de clientes desde la base de datos
$sqlOpcionesCliente = $con->prepare("SELECT id_cli, nom_cli FROM clientes ORDER BY nom_cli ASC");
$sqlOpcionesCliente->execute();
$opcionesCliente = $sqlOpcionesCliente->fetchAll(PDO::FETCH_ASSOC);

$sql = $con->prepare("
    SELECT SIU.nom_cli, SIU.nombre_c, SIU.rareza, SIU.cantidad_c, SIU.precio_c, reporteactdeuda_c.fecha_actualizada,
    reporteactdeuda_c.act_abono, SIU.concepto, reporteactdeuda_c.act_estado
    FROM reporteactdeuda_c
    INNER JOIN (
        SELECT deuda_c.id_dc, clientes.nom_cli, WA.nombre_c, WA.rareza, deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.concepto,
        deuda_c.estado_c
        FROM clientes
        INNER JOIN deuda_c ON clientes.id_cli = deuda_c.id_clientec
        INNER JOIN (
            SELECT cartas.nombre_c, rareza.rareza, car_rar.id_cr
            FROM cartas
            INNER JOIN car_rar ON car_rar.id_carar = cartas.id_car
            INNER JOIN rareza ON rareza.id_ra = car_rar.id_rar
        ) AS WA ON deuda_c.cr_fk = WA.id_cr
    ) AS SIU ON SIU.id_dc = reporteactdeuda_c.id
    WHERE :filtroCliente IS NULL OR SIU.id_cli = :filtroCliente
    ORDER BY reporteactdeuda_c.fecha_actualizada DESC
");

$sql->bindValue(':filtroCliente', $filtroCliente, PDO::PARAM_INT);
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Deuda Cartas</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Cabecera y menú (omito el contenido para simplificar) -->

    <!-- Formulario de filtro -->
    <form method="get">
        <label for="filtro_cliente">Filtrar por Cliente:</label>
        <select name="filtro_cliente" id="filtro_cliente">
            <option value="">Seleccionar Cliente</option>
            <?php foreach ($opcionesCliente as $opcion) : ?>
                <option value="<?php echo $opcion['id_cli']; ?>"
                    <?php if ($filtroCliente === $opcion['id_cli']) echo 'selected'; ?>>
                    <?php echo $opcion['nom_cli']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>
    <br>

    <!-- Tabla de resultados -->
    <div class="container">
        <h1 class="text-center">Reporte Deuda Cartas</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fecha Actualizacion</th>
                        <th scope="col">Deudor</th>
                        <th scope="col">Carta</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Abono</th>
                        <th scope="col">Concepto</th>
                        <th scope="col">Estado Deudor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultado as $fila) : ?>
                        <tr>
                            <td style="color:whitesmoke;"><?php echo $fila['fecha_actualizada'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['nom_cli'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['nombre_c'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['cantidad_c'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['precio_c'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['act_abono'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['concepto'] ?></td>
                            <td style="color:whitesmoke;"><?php echo $fila['act_estado'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
