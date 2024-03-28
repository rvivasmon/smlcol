<?php 

    require 'db.php';
    
    $idstc = $_POST['id_stc'];
    $fechaingreso = $_POST['fecha_ingreso'];
    $medioingreso = $_POST['medio_ingreso'];
    $ticketexterno = $_POST['ticket_externo'];
    $tiposervicio = $_POST['tipo_servicio'];
    $idproducto = $_POST['id_producto'];
    $falla = $_POST['falla'];
    $observacion = $_POST['observacion'];
    $cliente = $_POST['cliente'];
    $ciudad = $_POST['ciudad'];
    $proyecto = $_POST['proyecto'];
    $op = $_POST['op'];
    $estadostc = $_POST['estado_stc'];
    $personacontacto = $_POST['persona_contacto'];
    $emailcontacto = $_POST['email'];
    $idusuario = $_POST['id_usuario'];
    

    $sql = "INSERT INTO stc (id_stc, fecha_ingreso, medio_ingreso, ticket_externo, tipo_servicio, id_producto, falla, observacion, cliente, ciudad, proyecto, op, estado, persona_contacto, email_contacto, id_usuario) VALUES ('$idstc', '$fechaingreso', '$medioingreso', '$ticketexterno', '$tiposervicio', '$idproducto', '$falla', '$observacion', '$cliente', '$ciudad', '$proyecto', '$op', '$estadostc', '$personacontacto', '$emailcontacto', '$idusuario')";

    $resultado = mysqli_query($conn, $sql);
    $id_insert = mysqli_insert_id($conn);
    
    if($_FILES["archivo"]["error"]>0) {
        echo "Error al cargar archivo";
        } else {
            $permitidos = array("image/gif", "image/png", "image/jpg", "image/jpeg", "application/pdf");
            $limite_kb = 30000;
        
    if(in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024) {
        
        $ruta = 'files/'.$id_insert.'/';
        $archivo = $ruta.$_FILES["archivo"]["name"];
        
    if(!file_exists($ruta)) {
        mkdir($ruta);
        }
        
    if(!file_exists($archivo)) {
            
            $resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);
        
    if($resultado) {
        echo "Archivo Guardado";
            } else {
            echo "Error al guardar archivo";
            }
            } else {
            echo "Archivo ya existe";
            }        
            } else {
            echo "Archivo no permitido o excede el tamaño";
        }
    }
?>

<html lang="es">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">		
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="icon" type="image/ico" href="img/Logo.png">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>Confirmación</title>
	</head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="row" style="text-align:center">
                <?php if($resultado) { ?>
                <h3>REGISTRO GUARDADO</h3>
                <?php } else { ?>
                <h3>ERROR AL GUARDAR</h3>
                <?php } ?>
                <a href="index.php" class="btn btn-primary">REGRESAR</a>

                </div>
            </div>
        </div>
    </body>
</html>