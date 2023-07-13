<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendario Web</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index2.css">

    <!--  Full Calendar -->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/es.js"></script>
    <script src="js/bootstrap-clockpicker.js"></script>
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">WorkStack</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><b>Mis Atajos</b></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="calendario.php"><b>Calendario</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="empleados.php"><b>Empleados</b></a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Inventario</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda.php"><b>Inventario Carta</b></a></li>
            <li><a class="dropdown-item" href="funciones/listarPersonasConBusqueda2.php"><b>Inventario Productos</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/detallar.php">Detalle Carta</a></li>
          </ul>
        </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Agenda</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="acreedores.php"><b>Mis Acreedores</b></a></li>
            <li><a class="dropdown-item" href="deudores.php"><b>Mis Deudores</b></a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Registro</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="bitacoras/upd_cartas.php"><b>Actualizaciones En Cartas</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_productos.php"><b>Actualizaciones En Productos</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dc.php"><b>Reporte Deuda Cartas</b></a></li>
            <li><a class="dropdown-item" href="bitacoras/upd_dp.php"><b>Reporte Deuda Productos</b></a></li>
          </ul>
        </li>
          </ul>
          <form class="d-flex mt-3 mt-lg-0" role="search">
            <a href="../../config/cerrarSesion.php" class="btn btn-outline-success">Cerrar Sesion</a>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <body >
    <div class="container">
        
            <div> <br/><br/> <div id="CalendarioWeb" style=" background-color: rgba(0, 0, 0, 0.500);; ;color:white ;font-size:25px" class="fc fc-media-screen fc-direction-ltr  "  ></div></div>
          
    </div>
   

   
<script>
    $(document).ready(function(){
        $('#CalendarioWeb').fullCalendar({
            header:{
                left:'today,prev,next', 
                center:'title',
                right:'month,basicWeek'
            }, dayClick:function(date,jsEvent,view){

                $('#btnAgregar').prop("disabled",false);
                $('#btnModificar').prop("disabled",true);
                $('#btnEliminar').prop("disabled",true);


                limpiarFormulario();
                $('#txtFecha').val(date.format());
                $("#ModalEventos").modal();

            }, 
             events:'eventos.php',
            
           eventClick:function(calEvent,jsEvent,view){


                $('#btnAgregar').prop("disabled",true);
                $('#btnModificar').prop("disabled",false);
                $('#btnEliminar').prop("disabled",false);

                // H2
                $('#tituloEvento').html(calEvent.title);
                
               // Mostrar la información del evento en los inputs
                $('#txtDescripcion').val(calEvent.descripcion);
                $('#txtID').val(calEvent.id);
                $('#txtTitulo').val(calEvent.title);
                $('#txtColor').val(calEvent.color);
                
                FechaHora= calEvent.start._i.split(" ");
                $('#txtFecha').val(FechaHora[0]);
                
               
                $("#ModalEventos").modal();

           }, 
           editable:true, 
           eventDrop:function(calEvent){
                $('#txtID').val(calEvent.id);
                $('#txtTitulo').val(calEvent.title);
                $('#txtColor').val(calEvent.color);
                $('#txtDescripcion').val(calEvent.descripcion);

                var fechaHora=calEvent.start.format().split("T");
                $('#txtFecha').val(fechaHora[0]);
				$('#txtHora').val(fechaHora[1]);

                RecolectarDatosGUI();
                EnviarInformacion('modificar',NuevoEvento,true);

           }
        });

    });

</script>
<!-- Modal(Agregar, m¡Modificar, Eliminar) -->
<div class="modal fade" id="ModalEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloEvento"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <input type="hidden" id="txtID" name="txtID">
           <input type="hidden" id="txtFecha" name="txtFecha" />

          <div class="form-row">
                <div class="form-group col-md-8">
                    <label>Título:</label>
                    <input type="text" id="txtTitulo" class="form-control" placeholder="Título del evento" >
                </div>
                <div class="form-group col-md-4">
                        <label >Hora del evento:</label>
                       
                        <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" id="txtHora" value="10:30" class="form-control" />
                        </div>                        
                </div>
            </div>
            <div class="form-group" >
                    <label >Descripción:</label>
                    <textarea  id="txtDescripcion" rows="3" class="form-control"></textarea>
                </div>
                <div class="form-group" >   
                        <label >Color:</label>
                        <input type="color" value="#ff0000"id="txtColor" class="form-control" style="height:36px;">
                </div>
        </div>
        <div class="modal-footer">

            <button type="button" id="btnAgregar" class="btn btn-success" >Agregar</button>
            <button type="button" id="btnModificar" class="btn btn-success" >Modificar</button>
            <button type="button" id="btnEliminar" class="btn btn-danger" >Borrar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
<script>
var NuevoEvento; 
    
 $('#btnAgregar').click(function(){
   
     RecolectarDatosGUI();
     EnviarInformacion('agregar',NuevoEvento);
});
$('#btnEliminar').click(function(){
     RecolectarDatosGUI();
     EnviarInformacion('eliminar',NuevoEvento);
});
$('#btnModificar').click(function(){
     RecolectarDatosGUI();
     EnviarInformacion('modificar',NuevoEvento);
});


    
function RecolectarDatosGUI(){
    NuevoEvento= {
         id:$('#txtID').val(),
         title:$('#txtTitulo').val(), 
         start:$('#txtFecha').val()+" "+$('#txtHora').val(), 
         color:$('#txtColor').val(),
         descripcion:$('#txtDescripcion').val(),
         textColor:"#FFFFFF", 
         end:$('#txtFecha').val()+" "+$('#txtHora').val() 
        }; 
    
}
function EnviarInformacion(accion,objEvento,modal){
        $.ajax({
            type:'POST', 
            url:'eventos.php?accion='+accion, 
            data:objEvento, 
            success:function(msg){
             if(msg){
                $('#CalendarioWeb').fullCalendar('refetchEvents');  
                if(!modal){
                    $("#ModalEventos").modal('toggle');
                }
                

             }
            }, 
            error:function(){
                alert("Hay un error ..");
            }

        });

}

$('.clockpicker').clockpicker();
function limpiarFormulario(){
                $('#txtID').val('');
                $('#txtTitulo').val('Evento..');
                $('#txtColor').val('');
                $('#txtDescripcion').val('');

}

</script>

</body>
</html>