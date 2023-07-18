<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <title>Document</title>
</head>
<body>
<?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de departamentos para el filtro
$consulta = "SELECT * from productos";
$tabla = $conexion->seleccionar($consulta);

// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT * from productos WHERE id_pro ='$depa'";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>

<div class="container">
    <h1>Departamento filtrado</h1>

    <form class="row g-3" method="POST">
        <div class="col-auto">
            <label class="form-label">Filtro departamento</label>
        </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = '';
                    if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_pro) {
                        $selected = 'selected';
                    }
                    echo "<option value='" . $registro->id_pro . "' $selected>" . $registro->nom_p . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>

        <?php
        // Mostrar los campos dentro del formulario principal
        if (isset($tablaf)) {
            foreach ($tablaf as $registro) {
                echo "<input type='hidden' name='id_pro' value='$registro->id_pro'> ";
                echo "<label for='existencias'>existencias</label>";
                echo "<input class='form-control' name='existencias' value='$registro->existencias'> ";
                echo "<label for='precio'>precio</label>";
                echo "<input class='form-control' name='precio' value='$registro->precio'> ";
                echo "<label for='notas_prod'>Notas</label>";
                echo "<input class='form-control' name='notas_prod' value='$registro->notas_prod'> ";
                
                
            }
        }
        ?>

        <!-- Botón para enviar los datos al archivo car_rar.php -->
        <div class="col-12">
            <button type="submit" formaction="modificar_pro.php" class="btn btn-primary">Enviar Datos</button>
        </div>
    </form>
</div>

</body>
</html>