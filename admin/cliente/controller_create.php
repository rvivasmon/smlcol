<?php 

	include('../../app/config/config.php');
	include('../../app/config/conexion.php');

	include('../../layout/admin/sesion.php');
	include('../../layout/admin/datos_sesion_user.php');	


	//$id = $_POST['id'];
	$id_stc = $_POST['idstc'];
	$fecha_ingreso = $_POST['fechaingreso'];
	$medio_ingreso = $_POST['medio_ingreso'];
	$ticket_externo = $_POST['ticketexterno'];
	$servicio = $_POST['tiposervicio'];
	$id_producto = $_POST['id_producto'];
	$proyecto = $_POST['proyecto'];
	$estado = $_POST['idestado'];
	$ciudad = $_POST['idciudad'];
	$usuario = $_POST['idusuario'];
	$cliente = $_POST['idcliente'];
	$persona_contacto = $_POST['personacontacto'];
	$medio_contacto = $_POST['medio_contacto'];	
	$falla = $_POST['falla'];
	$observacion = $_POST['observacion'];
	$anio_mes = $_POST['anio_mes'];
	$contador = $_POST['contador'];	
	

	$sql = "INSERT INTO stc (id_stc, fecha_ingreso, medio_ingreso, ticket_externo, tipo_servicio, id_producto, proyecto, estado, ciudad, id_usuario, cliente, persona_contacto, email_contacto, falla, observacion, anio_mes, contador) 
    VALUES (:id_stc, :fechaingreso, :medio_ingreso, :ticketexterno, :servicio, :id_producto, :proyecto, :idestado, :ciudad, :idusuario, :cliente, :personacontacto, :medio_contacto, :falla, :observacion, :anio_mes, :contador)";


	$sentencia = $pdo->prepare($sql);

	$sentencia->bindParam(':id_stc', $id_stc);
	$sentencia->bindParam(':fechaingreso', $fecha_ingreso);
	$sentencia->bindParam(':medio_ingreso', $medio_ingreso);
	$sentencia->bindParam(':ticketexterno', $ticket_externo);
	$sentencia->bindParam(':servicio', $servicio);	
	$sentencia->bindParam(':id_producto', $id_producto);
	$sentencia->bindParam(':proyecto', $proyecto);
	$sentencia->bindParam(':idestado', $estado);
	$sentencia->bindParam(':ciudad', $ciudad);
	$sentencia->bindParam(':idusuario', $usuario);
	$sentencia->bindParam(':cliente', $cliente);
	$sentencia->bindParam(':personacontacto', $persona_contacto);
	$sentencia->bindParam(':medio_contacto', $medio_contacto);
	$sentencia->bindParam(':falla', $falla);
	$sentencia->bindParam(':observacion', $observacion);
	$sentencia->bindParam(':anio_mes', $anio_mes);
	$sentencia->bindParam(':contador', $contador);
			
	try {
		if ($sentencia->execute()) {
			// Éxito al ejecutar la consulta
			header('Location:' .$URL. 'admin/clientes');
			session_start();
			$_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
		} else {
			session_start();
			$_SESSION['msj'] = "Error al introducir la información";
		}
	} catch (PDOException $e) {
		echo "Error al ejecutar la consulta: " . $e->getMessage();
	}


