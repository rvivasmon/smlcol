<?php 
include 'db.php';

?>

<html lang="es">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" type="image/ico" href="img/Logo.png">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script> src = "id_generation.php"</script>
		<title>Nuevo Servicio</title> 
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<h3 style="text-align:center">NUEVO SERVICIO TÉCNICO <br> (STC)</h3>
			</div>
			
			<form class="form-horizontal" method="POST" action="guardar.php" enctype="multipart/form-data" autocomplete="off">
				
				<div class="form-group">
					<label for="id_stc" class="col-sm-2 control-label">ID STC</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="id_stc" name="id_stc" placeholder="Id_STC"  required>
					</div>
				</div>
				
				<div class="form-group">
					<label for="fecha_ingreso" class="col-sm-2 control-label">Fecha Ingreso</label>
					<div class="col-sm-5">
						<input type="date" value= "<?php echo date("y-m-d"); ?> "class="form-control" id="fecha_ingreso" name="fecha_ingreso" placeholder="Fecha Ingreso" required>
					</div>
				</div>
				
				<div class="form-group">
					<label for="medio_ingreso" class="col-sm-2 control-label">Medio Ingreso</label>
					<div class="col-sm-5">
						<select class="form-control" id="medio_ingreso" name="medio_ingreso" placeholder="Medio Ingreso">
							<option value="Email">EMAIL</option>
							<option value="Llamada">LLAMADA</option>
							<option value="Whatsapp">WHATSAPP</option>
							<option value="Otro">OTRO</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="ticket_externo" class="col-sm-2 control-label">Ticket Externo</label>
					<div class="col-sm-5">
						<input type="ticket_externo" class="form-control" id="ticket_externo" name="ticket_externo" placeholder="Ticket Externo">
					</div>
				</div>
				
				<div class="form-group">
					<label for="tipo_servicio" class="col-sm-2 control-label">Tipo Servicio</label>
					<div class="col-sm-5">
						<select class="form-control" name="tipo_servicio" placeholder="Tipo Servicio">
							
							<?php 
								require("db.php");
								$getTipoServicio1 = "SELECT * FROM tipo_servicio order by id";
								$getTipoServicio2 = mysqli_query($conn, $getTipoServicio1);
								
								while ($row = mysqli_fetch_array($getTipoServicio2))
								{
								$id = $row["id"];
								$descripcion = $row["servicio_stc"];
								
							?>
							
							<option value="<?php echo $id; ?>"><?php echo $descripcion; ?></option>
							
							<?php 
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="id_producto" class="col-sm-2 control-label">ID Producto</label>
					<div class="col-sm-5">
						<input type="id_producto" class="form-control" id="id_producto" name="id_producto" placeholder="ID Producto">
					</div>
				</div>
				
				<div class="form-group">
					<label for="falla" class="col-sm-2 control-label">Falla</label>
					<div class="col-sm-5">
						<input type="falla" class="form-control" id="falla" name="falla" placeholder="Falla">
					</div>
				</div>
				
				<div class="form-group">
					<label for="observacion" class="col-sm-2 control-label">Observación</label>
					<div class="col-sm-5">
						<input type="observacion" class="form-control" id="observacion" name="observacion" placeholder="Observación">
					</div>
				</div>
				
				<div class="form-group">
					<label for="cliente" class="col-sm-2 control-label">Cliente</label>
					<div class="col-sm-5">
						<select type="cliente" class="form-control" id="cliente" name="cliente" placeholder="Cliente">						
							
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="ciudad" class="col-sm-2 control-label">Ciudad</label>
					<div class="col-sm-5">
						<select class="form-control" name="ciudad" placeholder="Ciudad">
							
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="proyecto" class="col-sm-2 control-label">Proyecto</label>
					<div class="col-sm-5">
						<input type="proyecto" class="form-control" id="proyecto" name="proyecto" placeholder="Proyecto">
					</div>
				</div>
				
				<div class="form-group">
					<label for="op" class="col-sm-2 control-label">OP</label>
					<div class="col-sm-5">
						<input type="op" class="form-control" id="op" name="op" placeholder="OP">
					</div>
				</div>
				
				<div class="form-group">
					<label for="estado_stc" class="col-sm-2 control-label">Estado STC</label>
					<div class="col-sm-5">
						<select class="form-control" name="estado_stc" placeholder="Estado STC">						
							
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="persona_contacto" class="col-sm-2 control-label">Persona Contacto</label>
					<div class="col-sm-5">
						<input type="persona_contacto" class="form-control" id="persona_contacto" name="persona_contacto" placeholder="Persona Contacto">
					</div>
				</div>
				
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email Contacto</label>
					<div class="col-sm-5">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email Contacto">
					</div>
				</div>
				
				<div class="form-group">
					<label for="id_usuario" class="col-sm-2 control-label">ID Usuario</label>
					<div class="col-sm-5">
						<select class="form-control" name="id_usuario" placeholder="ID Usuario">
						
						<?php 
								require("db.php");
								$getusuario1 = "SELECT * FROM usuarios order by id";
								$getusuario2 = mysqli_query($conn, $getusuario1);
								
								while ($row = mysqli_fetch_array($getusuario2))
								{
								$id = $row["id"];
								$descripcion = $row["nombre"];
								
							?>
							
							<option value="<?php echo $id; ?>"><?php echo $descripcion; ?></option>
							
							<?php 
								}
							?>

						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="archivo" class="col-sm-2 control-label">Archivo Adjunto</label>
					<div class="col-sm-5">
						<input type="file" class="form-control" id="archivo" name="archivo">
					</div>
				</div>
				
				<!--
				
				<div class="form-group">
					<label for="estado_civil" class="col-sm-2 control-label">Estado Civil</label>
					<div class="col-sm-10">
						<select class="form-control" id="estado_civil" name="estado_civil">
							<option value="SOLTERO">SOLTERO</option>
							<option value="CASADO">CASADO</option>
							<option value="OTRO">OTRO</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="hijos" class="col-sm-2 control-label">¿Tiene Hijos?</label>
					
					<div class="col-sm-10">
						<label class="radio-inline">
							<input type="radio" id="hijos" name="hijos" value="1" checked> SI
						</label>
						
						<label class="radio-inline">
							<input type="radio" id="hijos" name="hijos" value="0"> NO
						</label>
					</div>
				</div>
				
				<div class="form-group">
					<label for="intereses" class="col-sm-2 control-label">INTERESES</label>
					
					<div class="col-sm-10">
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Libros"> Libros
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Musica"> Musica
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Deportes"> Deportes
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Otros"> Otros
						</label>
					</div>
				</div>
				-->
				<br>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="index.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>