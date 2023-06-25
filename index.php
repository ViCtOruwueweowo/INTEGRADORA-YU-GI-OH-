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
    <script src="js/bootstrap.js">  </script>
</head>
<body>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="img/mamaste.jpg"   class="img-fluid" alt="Sample image">
        </div>
   
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <!--Recuerda todo va dentro de un formulario-->
          <form>
            <!-- Parte del correo -->
            <div class="form-outline mb-4">
              <input type="email" id="" class="form-control form-control-lg"
                placeholder="Ingresar Correo Electronico" />
              <label class="form-label" for="">Correo Electronico</label>
            </div>

            <!-- Parte de la contraseña -->
            <div class="form-outline mb-3">
              <input type="password" id="" class="form-control form-control-lg"
                placeholder="Ingresar Contraseña" />
              <label class="form-label" for="">Contraseña</label>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
            <a href="views/administrador/index.php"><button type="button" class="btn btn-warning btn-lg"
        style="padding-left: 2.5rem; padding-right: 2.5rem;">Iniciar Sesion</button></a>
            </div>

          </form>
        </div>
      </div>
    </div>
   
  </section>
</html>