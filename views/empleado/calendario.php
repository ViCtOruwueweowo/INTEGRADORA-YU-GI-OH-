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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendario Web</title>    
    <script src="js/jquery.min.js"></script>    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">    
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css">    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-clockpicker.js"></script>
    <link rel="stylesheet" href="../../img/fondo bonito.jpg">

    <!--  Full Calendar -->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <script src="js/moment.min.js"></script>
    
<!-- esto es de fullcalendar -->
<script src="js/fullcalendar.min.js"></script>
<script src="js/es.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
</head>
<body style="background-color: rgba(235,235,235,255);">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">WorkStack</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto justify-content-right" style="text-align: center;">
      <li class="nav-item active">
        <a class="nav-link" href="calendario.php">Calendario<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
         Inventario
        </a>
        <ul class="dropdown-menu" >
          <a href="funciones/listarPersonasConBusqueda.php" class="dropdown-item">Cartas</a>
          <a href="funciones/listarPersonasConBusqueda2.php" class="dropdown-item">Productos</a>
          </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
       Mi Agenda
        </a>
        <ul class="dropdown-menu">
          <li><a href="ac.php" class="dropdown-item">Acreedores</a></li>
          <li><a href="deuda_c.php" class="dropdown-item">Deudores Cartas</a></li>
          <li><a href="deuda_p.php" class="dropdown-item">Deudores Productos</a></li>
          <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/agregar_cliente.php">Agregar Cliente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="funciones/hola2.php">Venta Cartas</a></li>
            <li><a class="dropdown-item" href="funciones/hola.php">Venta Productos</a></li>
          </ul>
      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
        <?php echo $nombreUsuario; ?>
        </a>
        <div class="dropdown-menu">
        <a href="../../config/cerrarSesion.php" class="dropdown-item dropdown-responsive">Cerrar Sesión</a>
        </div>
      </li>
    </ul>
 
  </div>
</nav>

<br>

  </div> 
</div>

    <div class="container">

            <div><div id="CalendarioWeb" style=" background-color: rgba(0, 0, 0, 0.500);; ;color:white ;font-size:25px" class="fc fc-media-screen fc-direction-ltr  "  ></div></div>
          
    </div>

<script>
    $(document).ready(function(){
        // Variable global para almacenar el identificador del evento porque luego agarra el que le da su gana o de plano ninguno y así no juego yo eh tampoco vamos a ser maldosos con uno :c
  var selectedEventId = null;

        // Función para limpiar los campos del modal
  function limpiarModal() {
    $('#tituloEvento').html('');
    $('#txtID').val('');
    $('#txtFecha').val('');
    $('#txtTitulo').val('');
    $('#txtDescripcion').val('');
    $('#txtColor').val('#ff0000');
    $('#txtFechaFin').val('');
  }

        $('#CalendarioWeb').fullCalendar({
            header:{
                left:'today, prev,next', 
                center:'title',
                right:'month, basicWeek'
            
            },
  
            // events:'http://3.80.76.204/views/administrador/eventos.php',

             events: '../administrador/eventos.php',

           eventClick:function(calEvent,jsEvent,view){
            console.log('Evento clickeado', calEvent);
            if (calEvent.id === selectedEventId) {
        // El clic proviene de la misma cintilla de color, mostrar información del evento

        // Mostrar la fecha de inicio en el modal
        var fechaInicio = moment(calEvent.start).format('YYYY-MM-DD');
        $('#txtFecha').val(fechaInicio);

          // Mostrar la fecha de inicio seleccionada en el campo "Fecha de Inicio Seleccionada"
          $('#fechaInicioSeleccionada').text(fechaInicio);

          // Ajustar la fecha de fin para que no sea menor que la fecha de inicio
          $('#txtFechaFin').attr('min', fechaInicio);
          var fechaFin = moment(calEvent.end).format('YYYY-MM-DD');
          $('#txtFechaFin').val(fechaFin);


            limpiarModal();

            $('#btnAgregar').prop("disabled",true);
              $('#btnModificar').prop("disabled",false);
              $('#btnEliminar').prop("disabled",false);


            // H2
            $('#tituloEvento').html(calEvent.title);

            //Mostrar la info del evento en los inputs
            $('#txtDescripcion').val(calEvent.descripcion);
            $('#txtID').val(calEvent.id);
            $('#txtTitulo').val(calEvent.title);
            $('#txtColor').val(calEvent.color);
            $('#txtFecha').val(calEvent.start.format());
            $('#txtFechaFin').val(calEvent.end.format());
 

            $("#ModalEventos").modal();


          } else {
        // El clic proviene de otra cintilla de color, actualizar el identificador y no hacer nada
        selectedEventId = calEvent.id;
        }
           },
           editable:false,
           eventDrop:function(calEvent){
        // Actualizar la fecha de inicio con la nueva fecha inicial después de ser arrastrada
        var newStartDate = calEvent.start.format();
        var newEndDate = calEvent.end.format();
        ActualizarFechasEnDB(calEvent.id, newStartDate, newEndDate);

            
            $('#txtID').val(calEvent.id);
            $('#txtTitulo').val(calEvent.title);
            $('#txtColor').val(calEvent.color);
            $('#txtDescripcion').val(calEvent.descripcion);

            var fecha=calEvent.start.format();
            $('#txtFecha').val(calEvent.start.format());

            RecolectarDatosGUI();
            EnviarInformacion('modificar',NuevoEvento,true); 



        }
    });

    function ActualizarFechasEnDB(eventId, newStartDate, newEndDate) {
    // Crear un objeto con los datos del evento para enviar en la solicitud AJAX
    var eventoActualizado = {
      id: calEvent.id,
    title: calEvent.title,
    descripcion: calEvent.descripcion,
    color: calEvent.color,
    textColor: calEvent.textColor,
    start: calEvent.start.format(),
    end: calEvent.end.format(),
    };

    // Realizar la solicitud AJAX para actualizar las fechas en la base de datos
    $.ajax({
      type: 'POST',
      url: 'eventos.php?accion=modificar', // Reemplaza esto con la URL que maneje la actualización en tu servidor
      data: {
            id: eventId,
            start: newStartDate,
            end: newEndDate
        },
        success: function (response) {
            console.log('Evento actualizado en la base de datos:', response);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            console.log(status);
            console.log(error);
            alert('Error al actualizar el evento en la base de datos.');
        },
    });
  }
});
</script>

<!-- Modal(Agregar, Modificar, Eliminar) -->
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

        <div class="form-row">

          <!-- tal vez agregue otra variable de fecha para la final-->
          <div class="form-group col-md-12">
            <label>Título: </label>
            <input type="text" id="txtTitulo" class="form-control" placeholder="Título del evento" required readonly>
          </div>
          <div class="form-group col-md-6">
            Fecha de inicio: 
          <input type="date" id="txtFecha" name="txtFecha" readonly>
          </div>
          <div class="form-group col-md-6">
          Fecha Fin: <input type="date" id="txtFechaFin" class="form-control" name="txtFechaFin" required readonly/><br/>
          </div>
          
          
        </div>
        <div class="form-group">
        <label>Descripcion: </label>
        <textarea id="txtDescripcion" rows="3" class="form-control" required readonly></textarea>
          </div>
          <div class="form-group">
          <label>Color: </label>
          <input type="color" value="#ff0000" id="txtColor" class="form-control" style="height:36px;" readonly>
          </div>
   
        </div>
        <div class="modal-footer">

 
        </div>
      </div>
    </div>
  </div>
<script>
  function validarCampos() {
  var titulo = $('#txtTitulo').val().trim();
  var fechaInicio = $('#txtFecha').val().trim();
  var fechaFin = $('#txtFechaFin').val().trim();

  if (titulo.trim() === '' || fechaInicio.trim() === '' || fechaFin.trim() === '') {
    alert('Debes llenar todos los campos obligatorios que son: Título y fecha de finalización, para guardar este evento.');
    return false;
  }
  return true;
}

function validarFechas() {
    var fechaInicio = moment($('#txtFecha').val());
    var fechaFin = moment($('#txtFechaFin').val());

    if (fechaFin.isBefore(fechaInicio)) {
      alert('La fecha final no puede ser menor que la fecha de inicio.');
      return false;
    }

    return true;
  }
  
  function validarRangoFechas() {
    var fechaInicio = moment($('#txtFecha').val());
    var fechaFin = moment($('#txtFechaFin').val());

    var diffDays = fechaFin.diff(fechaInicio, 'days');

    if (diffDays > 366) {
      alert('El rango de fechas no puede ser mayor a 1 año.');
      return false;
    }

    return true;
  }

var NuevoEvento;



function RecolectarDatosGUI(){
  var fechaInicio = $('#txtFecha').val();
  var fechaFin = $('#txtFechaFin').val();

  // Verificar si la fecha de inicio y fin son iguales
  if (fechaInicio === fechaFin) {
    // Sumar un día a la fecha de fin
    var nuevaFechaFin = moment(fechaFin).add(1, 'days').format('YYYY-MM-DD');
    $('#txtFechaFin').val(nuevaFechaFin);
  }

  NuevoEvento= {
    id: $('#txtID').val(),
    title: $('#txtTitulo').val(),
    start: fechaInicio,
    end: $('#txtFechaFin').val(),
    color: $('#txtColor').val(),
    descripcion: $('#txtDescripcion').val(),
    textColor: "#FFFFFF",
  };
}

function EnviarInformacion(accion,objEvento,modal){
  $.ajax({
    type:'POST',
    url:'eventos.php?accion='+accion,
    data: {
      id: objEvento.id,
      title: objEvento.title,
      descripcion: objEvento.descripcion,
      color: objEvento.color,
      textColor: objEvento.textColor,
      start: objEvento.start,
      end: objEvento.end
    },
    success:function(msg){
      if(msg){
        $('#CalendarioWeb').fullCalendar('refetchEvents');
        if(!modal){
          $("#ModalEventos").modal('toggle');
        }


      }
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText); // Imprimir la respuesta del servidor en la consola
      console.log(status); // Imprimir el estado de la solicitud en la consola
      console.log(error); // Imprimir el error en la consola
      alert("Hay un error en la solicitud, puede ser que el nombre ya esté en uso o que estés insertando en una fecha anterior a este mes...");
    }
    
  });  
};

</script>

</body>
</html>