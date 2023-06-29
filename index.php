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
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="img/puto.png"   class="img-fluid" alt="Sample image">
        </div>
   
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <!--Recuerda todo va dentro de un formulario-->
          <form>
            <!-- Parte del correo -->
            <div class="form-outline mb-4">
              <input type="usser" id="" class="form-control form-control-lg"
                placeholder="Ingresar Usuario Registrador. . ." />
              <label class="form-label" for="" style="color:gold"><b>Usuario</b></label>
            </div>

            <!-- Parte de la contraseña -->
            <div class="form-outline mb-3">
              <input type="password" id="" class="form-control form-control-lg"
                placeholder="Ingresar Contraseña. . ." />
              <label class="form-label" for="" style="color:gold"><b>Contraseña</b></label>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
            <a href="views/administrador/index.php"><button type="button" class="btn btn-outline-danger btn-lg"
        style="padding-left: 2.5rem; padding-right: 2.5rem;"><b>Iniciar Sesion</b></button></a>
            </div>

          </form>
        </div>
      </div>
    </div>
   
  </section>
</html>