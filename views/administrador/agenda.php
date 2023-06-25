<?php
require '../../config/database.php';
$db = new Database ;
$con = $db->conectar();
$sql = $con->prepare("SELECT  
clientes.nom_cli as 'cliente',
clientes.tel_cli as telefono,
dogma.producto,
dogma.estado as 'E_deuda',
dogma.total as 'T_productos',
dogma.precio as precio_producto,
albaz.carta as Carta,
albaz.precio as precio_carta,
albaz.estado as 'E_deuda_c',
albaz.total as 'T_cs'
from
clientes
inner join
(Select 
clientes.nom_cli as cliente,
clientes.tel_cli as telefono,
productos.nom_p as producto,
deuda_p.estado_p as estado,
productos.precio as precio,
(deuda_p.precio_p - deuda_p.abono_p) as total
from
clientes inner join deuda_p on clientes.id_cli=deuda_p.id_clientep inner join productos on deuda_p.id_p=productos.id_pro) as dogma
on clientes.nom_cli=dogma.cliente 
left join
(Select 
clientes.nom_cli as cliente,
cartas.nombre_c as carta,
deuda_c.estado_c as estado,
deuda_c.precio_c as precio,
(deuda_c.precio_c  - deuda_c.abono_c) as total
from
clientes inner join deuda_c on clientes.id_cli=deuda_c.id_clientec inner join cartas on
deuda_c.id_c=cartas.id_car inner join car_rar on cartas.id_car=car_rar.id_carar inner join rareza on
car_rar.id_rar=rareza.id_ra) as albaz
on dogma.cliente=albaz.cliente 
group by albaz.carta; ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
<body>
<link rel="stylesheet" href="../../css/bootstrap.min.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Mis Atajos</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="calendario.php">Calendario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="funciones/listarPersonasConBusqueda.php">Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php">Empleados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="agenda.php">Agenda</a>
            </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../index.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>
 
  <!--Apartir de aqui se esta manejando todo el apartado de las deudas de los clientes-->
  <div class="container">
  <div class="container mt-3">
        <br>
        <!-- Nav pills -->
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="pill" href="#home">Mis Deudores Cartas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#menu1">Mis Deudores Producto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="pill" href="#menu2">Mis Acreedores</a>
          </li>
        </ul>
      
        <!-- Tab panes -->
        <div class="tab-content">
          <div id="home" class="container tab-pane active"><br>
            <table class="table table-hover">
  <thead class="table-dark table-hover">
    <tr>
      <th scope="col" colspan="2" class="text-center col-2">Cliente</th>
      <th scope="col" colspan="2" class="text-center col-2">Telefono</th>
      <th scope="col" colspan="2" class="text-center col-2">Carta</th>
      <th scope="col" colspan="2" class="text-center col-2">Precio</th>
      <th scope="col" colspan="2" class="text-center col-2">Total A Pagar</th>


    </tr>
  </thead>
  <tbody>
    <?php foreach($resultado as $fila): ?>
    <tr>
      <td colspan="2" class="text-center"><?php echo $fila ['cliente'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['telefono'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['Carta'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['precio_carta'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['T_cs'] ?></td>


</td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>
          </div>
          <div id="menu2" class="container tab-pane fade"><br>
meter aqui la consulta de Acredores
          </div>
        </div>
      </div>

      <div id="menu1" class="container tab-pane fade"><br>
      <table class="table table-hover">
  <thead class="table-dark table-hover">
    <tr>
      <th scope="col" colspan="2" class="text-center col-2">Cliente</th>
      <th scope="col" colspan="2" class="text-center col-2">Telefono</th>
      <th scope="col" colspan="2" class="text-center col-2">Producto</th>
      <th scope="col" colspan="2" class="text-center col-2">Precio</th>
      <th scope="col" colspan="2" class="text-center col-2">Total A Pagar</th>


    </tr>
  </thead>
  <tbody>
    <?php foreach($resultado as $fila): ?>
    <tr>
      <td colspan="2" class="text-center"><?php echo $fila ['cliente'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['telefono'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['producto'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['precio_producto'] ?></td>
      <td colspan="2" class="text-center"><?php echo $fila ['T_productos'] ?></td>


</td>
    </tr>
      <?php endforeach; ?>
  </tbody>
</table>          </div>
        </div>
      </div>

</div>

<script src="../../js/bootstrap.min.js"></script>
</body>
</html>