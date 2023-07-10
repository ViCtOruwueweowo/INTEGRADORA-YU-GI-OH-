<?php 
header('Content-Type: application/json');
$pdo=new PDO("mysql:dbname=workstack;host=127.0.0.1","root","");

$accion= (isset($_GET['accion']))?$_GET['accion']:'leer'; 

switch($accion){
    case 'agregar': 
         // Instrucción de agregado
        $sentenciaSQL = $pdo->prepare("INSERT INTO 
		calendario(title,descripcion,color,textColor,start,end)
		VALUES(:title,:descripcion,:color,:textColor,:start,:end)");
        
        $respuesta=$sentenciaSQL->execute(array(
            "title" =>$_POST['title'],
            "descripcion" => $_POST['descripcion'],
            "color" => $_POST['color'],
            "textColor" =>$_POST['textColor'],
            "start" => $_POST['start'],
            "end" => $_POST['end']
        ));
        echo json_encode($respuesta);
        break;
    case 'eliminar': 
        // Instrucción de eliminar
        // echo "Instrucción eliminar";
        $respuesta=false; 

        if(isset($_POST['id'])){

            $sentenciaSQL= $pdo->prepare("DELETE FROM calendario WHERE ID=:ID"); 
            $respuesta= $sentenciaSQL->execute(array("ID"=>$_POST['id']));
        }
        echo json_encode($respuesta);


        break;
    case 'modificar':
        // Instrucción de modificar

        $sentenciaSQL = $pdo->prepare("UPDATE calendario SET 
		title=:title,
		descripcion=:descripcion,
		color=:color,
		textColor=:textColor,
		start=:start,
		end=:end
		WHERE ID=:ID
        ");
        
        $respuesta=$sentenciaSQL->execute(array(
		    "ID" =>$_POST['id'], 
            "title" =>$_POST['title'],
            "descripcion" => $_POST['descripcion'],
            "color" => $_POST['color'],
            "textColor" =>$_POST['textColor'],
            "start" => $_POST['start'],
            "end" => $_POST['end']
        ));
        echo json_encode($respuesta);


        break;
    default:
        // Seleccionar los eventos del calendario
            $sentenciaSQL= $pdo->prepare("SELECT * FROM calendario");
            $sentenciaSQL->execute();

            $resultado= $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($resultado);
        break;
        
}


?>