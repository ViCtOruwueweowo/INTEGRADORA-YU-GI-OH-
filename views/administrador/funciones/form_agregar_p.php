<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/index2.css">
    <script src="../../../js/bootstrap.bundle.min.js"></script>
</head>
<body>
<br>
<div class="container">
<h1>Agregar Producto</h1>
<hr>
<form action="producto_g.php" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-12">
    <label  class="form-label">Ingresar Nombre Del Producto:</label>
    <input type="text" class="form-control col-lg-6" id="nom_p" name="nom_p" placeholder="Nombre Producto. . ." require>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Existencias Del Producto:</label>
    <input type="text" class="form-control col-lg-6" id="existencias" name="existencias" placeholder="Ingresar Existencias. . ." require>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Precio Del Producto:</label>
    <input type="text" class="form-control col-lg-6" id="precio" name="precio" placeholder="Ingresar Precio. . ." require>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Nombre De La Imagen:</label>
    <input type="text" class="form-control col-lg-6" id="imagen_p" name="imagen_p" placeholder="Nombre De La Imagen. . ." require>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Descripcion Del Producto:</label>
    <input type="text" class="form-control col-lg-6" id="notas_prod" name="notas_prod" placeholder="Detalles. . ." require>
    </div>
    <div class="col-12">
    <label  class="form-label">Ingresar Archivo</label><br>
    <input type="file" name="imagen" accept="image/webp">
    </div>
    
    <div class="col-12">
        <br>
    <input type="submit" class="btn btn-primary btn-lg" value="Subir imagen">
    </div>
</div>
</form>
   </div>
</body>
</html>