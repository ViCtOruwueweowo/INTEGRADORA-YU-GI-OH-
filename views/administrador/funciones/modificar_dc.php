 
<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "Inicia sesión primero por favor :D";
    header("refresh:5 ../../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

// Verificar si el tipo de usuario no es 1 (Tipo de usuario que puede acceder a esta página, osea el admin)
if ($_SESSION['tipo_usuario'] !== "1") { 
      echo "Acceso no autorizado. Por favor, inicia sesión con una cuenta válida.";
    header("refresh:5 ../../../index.php");  // Redireccionamos al archivo de inicio de sesión
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
      
    <link rel="stylesheet" href="../../../css/index2.css">
</head>
<body>

    </head>

    
    <header>
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
          <a href="../../config/cerrarSesion.php" class="dropdown-item">Cerrar Sesion</a>
          </ul>
      </li>
          </ul>
  
       
        </div>
      </div>
    </div>
  </nav>

  <br>
  <?php
include 'date.php';
$conexion = new database();
$conexion->conectarDB();

// Obtener la lista de departamentos para el filtro
//$consulta = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Carta:',' ', cartas.nombre_c, ' ', rareza.rareza) as nombre, deuda_c.id_dc, deuda_c.precio_c, deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.notas, deuda_c.abono_c,car_rar.cantidad FROM deuda_c INNER JOIN clientes ON deuda_c.id_clientec = clientes.id_cli INNER JOIN car_rar ON car_rar.id_cr = deuda_c.cr_fk inner join cartas on car_rar.id_carar=cartas.id_car inner join rareza on car_rar.id_rar=rareza.id_ra GROUP BY nombre";
//$tabla = $conexion->seleccionar($consulta);

// Obtener la lista de departamentos para el filtro
$consulta = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Carta:',' ', cartas.nombre_c, ' ', rareza.rareza) as nombre, deuda_c.id_dc, deuda_c.precio_c, deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.notas, deuda_c.abono_c, deuda_c.estado_c, deuda_c.concepto ,car_rar.cantidad FROM deuda_c INNER JOIN clientes ON deuda_c.id_clientec = clientes.id_cli INNER JOIN car_rar ON car_rar.id_cr = deuda_c.cr_fk inner join cartas on car_rar.id_carar=cartas.id_car inner join rareza on car_rar.id_rar=rareza.id_ra WHERE deuda_c.estado_c='ACTIVO' ORDER BY clientes.nom_cli ASC";
$tabla = $conexion->seleccionar($consulta);



// Filtrar el departamento seleccionado
if (isset($_POST['depa'])) {
    $depa = $_POST['depa'];
    $consultaf = "SELECT CONCAT('Cliente:', ' ',clientes.nom_cli,'. ', 'Carta:',' ', cartas.nombre_c, ' ', rareza.rareza) as nombre, deuda_c.id_dc, deuda_c.precio_c,deuda_c.cantidad_c, deuda_c.precio_c, deuda_c.notas, deuda_c.abono_c,car_rar.cantidad FROM deuda_c INNER JOIN clientes ON deuda_c.id_clientec = clientes.id_cli INNER JOIN car_rar ON car_rar.id_cr = deuda_c.cr_fk 
    inner join cartas on car_rar.id_carar=cartas.id_car inner join rareza on car_rar.id_rar=rareza.id_ra WHERE id_dc ='$depa' ";
    $tablaf = $conexion->seleccionar($consultaf);
}
?>

<div class="container" style="color:whitesmoke;background-color: rgba(0, 0, 0, .550); box-shadow: 0 4px 5px rgba(10, 2, 1, 55); text-align:left">
    <h1 style="text-align: center;">Modificar Deudores Cartas</h1>

    <form class="row g-3" method="POST">
        <div class="col-auto">
        <h2>Seleccionar Deuda:</h2>
        </div>
        <div class="col-auto">
            <select class="form-select" name="depa" aria-label="Default select example">
                <?php
                foreach ($tabla as $registro) {
                    $selected = '';
                    if (isset($_POST['depa']) && $_POST['depa'] == $registro->id_dc) {
                        $selected = 'selected';
                    }
                    echo "<option value='" . $registro->id_dc . "' $selected>" . $registro->nombre . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Filtrar</button>
        </div>
<div class="row">
  
<?php
        // Mostrar los campos dentro del formulario principal
        if (isset($tablaf)) {
            foreach ($tablaf as $registro) {
                echo "<input type='hidden' name='id_dc' value='$registro->id_dc'> ";
                echo "<div class='col-3 col-lg-12'>";
                echo "<h3 for='cantidad_c'>Cantidad:</h3>";
                echo "</div>"; 
                
                
                echo "<div class='col-9 col-lg-12'>";
                echo "<input type='number' class='form-control' name='cantidad_c' value='$registro->cantidad_c' required readonly> ";
                echo "</div>"; 

                echo "<div class='col-2 col-lg-12'>";
                echo "<h3 for='notas'>Notas:</h3>";
                echo "</div>"; 

                echo "<div class='col-10 col-lg-12'>";
                echo "<input class='form-control' name='notas' value='$registro->notas' required> ";
                echo "</div>"; 




                
                echo "<div class='col-4 col-lg-12'>";
                echo "<h3 for='notas'>Nuevo Abono:</h3>";
                echo "</div>";
                
                echo "<div class='col-7 col-lg-12'>";
                echo "<input class='form-control' name='abono_c' oninput='this.value = this.value.replace(/[^0-9.]/g, \"\")'>";
                echo "</div>";
            
                
                



                echo "<div class='col-4 col-lg-12'>";
                echo "<h3 for='notas'>Estado Deuda:</h3>";
                echo "</div>"; 


                echo "<div class='col-6 col-lg-12'>";
                echo "<select class='form-control' name='estado_c'>";
                echo "<option value='ACTIVO' " . ($registro->estado == 'ACTIVO' ? 'selected' : '') . ">ACTIVO</option>";
                echo "<option value='CANCELADO' " . ($registro->estado == 'CANCELADO' ? 'selected' : '') . ">CANCELAR</option>";
                echo "</select>";
                echo "</div>"; 

                echo "<div class='col-4 col-lg-12'>";
                echo "<h3 for='notas' style='text-align:center'>Detalles Deuda</h3>";
                echo "</div>";



                echo "<div class='col-4 col-lg-3'>";
                echo "<h3 for='notas'>Precio Carta:</h3>";
                echo "</div>"; 

                echo "<div class='col-4 col-lg-3'>";
                echo "<label for='abono_c' value=>$registro->precio_c</label>";
                echo "</div>"; 


    
                echo "<div class='col-4 col-lg-3'>";
                echo "<h3 for='notas'>Abono:</h3>";
                echo "</div>"; 
              



                echo "<div class='col-6 col-lg-3'>";
                echo "<label for='abono_c' value=>$registro->abono_c</label>";
               echo "</div>"; 


               echo "<div class='col-4 col-lg-3'>";
               echo "<label for='cantidad_c'>cantidad en stock: $registro->cantidad</label>";
               echo "</div>"; 
             
                
            }


            echo "<script>
            function validateForm() {
                var nuevoAbono = document.getElementsByName('abono_c')[0].value;
                if (nuevoAbono.trim() === '') {
                    alert('El campo Nuevo Abono no puede estar vacío.');
                    return false;
                }
                return true;
            }
            </script>";
        


            echo "<div class='col-12'>
            <button type='submit' formaction='editar_dc.php' class='btn btn-primary'>Enviar Datos</button>
        </div>";
        }
        else {
          echo "<div class='col-12'>
          <button type='submit' formaction='editar_dc.php' class='btn btn-primary disabled'>Enviar Datos</button>
      </div>";
        }
        ?>

        
<script>
function validateForm() {
    var nuevoAbono = document.getElementsByName('abono_c')[0].value;
    if (nuevoAbono.trim() === '') {
        alert('El campo Nuevo Abono no puede estar vacío.');
        return false;
    }
    return true;
}
</script>

</div>

    </form>
</div>


</body>
</html>