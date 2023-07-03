<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--Links-->
    <link rel="stylesheet" href="css/estilo.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/index2.css">
    <script src="js/bootstrap.js">  </script>
</head>

<body>
<?php
    session_start();
    if (isset($_SESSION["usuario"]))
    {
        echo "<div class='alert 'alert-warning'>
        <h2 align='center'> Ya existe una sesion activa, usuario: ".$_SESSION["usuario"]."</h2>";
        echo "<h3 align-'center'>
        <a href='config/cerrarSesion.php'>[Cerrar Sesion]</a>
        </h3>
        </div>";
    }
    else
    {
        ?>

  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="img/puto.png"   class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <!--Recuerda todo va dentro de un formulario-->
          <form action="views/administrador/index.php" method="post">
            <!-- Parte del usuario -->
            <div class="form-outline mb-4">
              <input type="text" class="form-control form-control-lg"
                placeholder="Ingresar su nombre de usuario..." name="usuario"/>
              <label class="form-label" for="" style="color:blue"><b>Usuario</b></label>
            </div>
            <!-- Parte de la contraseña -->
            <div class="form-outline mb-3">
              <input type="password" class="form-control form-control-lg"
                placeholder="Ingrese su contraseña..." name="contraseña"/>
              <label class="form-label" for="" style="color:blue"><b>Contraseña</b></label>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" class="btn btn-outline-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" value="Iniciar sesión"></input>
            </div>
          </form>
        </div>
      </div>
    </div>
   
  </section>
  <?php
    }
        ?>
</body>
</html>




