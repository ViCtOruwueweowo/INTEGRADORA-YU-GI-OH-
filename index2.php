<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--Links-->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="js/bootstrap.js">  </script>
</head>
<style>
        #contendor{
            width: 40%;
            margin: auto;
        }
    </style>
<body>
<?php
session_start();

if (isset($_SESSION['usuario'])) {
  $nombreUsuario = $_SESSION['usuario'];

  echo "<div class='container' id='contenedor'>
  <div class='alert alert-warning text-center' role='alert'>
 <h1 style='text-aling:center'>¡Ups, Parece Ser Que Ya Existe Una Sesion Activo!</h1>
 <br>
 <div class='spinner-border text-dark' role='status'>
<span class='visually-hidden'>Loading...</span>
</div>
<br>
 <h6>Usuario En Linea: $nombreUsuario</h6>
 <a class='btn btn-outline-danger' href='config/cerrarSesion.php'>[Cerrar sesión]</a>
</div>
</div>   ";    

    exit();
}
?>

  <section class="vh-100">
    <div class="container-fluid h-custom"> 
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="img/ws.png"   class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <!--Recuerda todo va dentro de un formulario-->
          <!-- <form action="views/administrador/index.php" method="post"> -->
          <form action="config/validar_login.php" method="post">
            <!-- Parte del usuario -->
            <div class="form-outline mb-4">
              <input type="text" class="form-control form-control-lg"
                name="usuario" placeholder="Ingresa tu usuario. . ." required/>
              <label class="form-label" for="" style="color:red"><b>Usuario</b></label>
            </div>
            <!-- Parte de la contraseña -->
            <div class="form-outline mb-3">
              <input type="password" class="form-control form-control-lg"
               name="password"  placeholder="Ingresa tu contraseña. . ." required/>
              <label class="form-label" for="" style="color:red" ><b>Contraseña</b></label>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">

            <input type="submit" class="btn btn-2 btn-outline-danger btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" value="Iniciar sesión"></input>

            </div>
          </form>
        </div>
      </div>
    </div>
   
  </section>

</body>
</html>




