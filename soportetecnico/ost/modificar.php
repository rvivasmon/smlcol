<?php
	
	require 'db.php';
	
	$id = $_GET['id'];
	
	$sql = "SELECT * FROM stc WHERE id = '$id'";
	$resultado = mysqli_query($conn, $sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);		
	
?>


<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" type="image/ico" href="img/Logo.png">
		<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>		

		<script type="text/javascript">
			$(document).ready(function() {
				$('.delet').click(function() {
					var parent = $(this).parent().attr('id');
					var service = $(this).parent().attr('data');
					var dataString = 'id='+service;

					$.ajax({
						type: "POST",
						url: "del_file.php",
						data: dataString,
						success: function() {
							location.reload();
						}
					});
				});
			});
		</script>

		<title>Modificar Servicio</title>
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<h3 style="text-align:center">MODIFICAR REGISTRO</h3>
			</div>
			
			<form class="form-horizontal" method="POST" action="update.php" enctype="multipart/form-data" autocomplete="off">
				<div class="form-group">
					<label for="id_stc" class="col-sm-2 control-label">ID STC</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="id_stc" name="id_stc" placeholder="id_stc" value="<?php echo $row['id_stc']; ?>" required>
					</div>
				</div>
				
				<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>" />
				
				<div class="form-group">
					<label for="fecha_ingreso" class="col-sm-2 control-label">Fecha de Ingreso</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" placeholder="fecha_ingreso" value="<?php echo $row['fecha_ingreso']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="medio_ingreso" class="col-sm-2 control-label">Medio de Ingreso</label>
					<div class="col-sm-10">
						<input type="medio_ingreso" class="form-control" id="medio_ingreso" name="medio_ingreso" placeholder="medio_ingreso" value="<?php echo $row['medio_ingreso']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="ticket_externo" class="col-sm-2 control-label">Ticket Externo</label>
					<div class="col-sm-10">
						<input type="ticket_externo" class="form-control" id="ticket_externo" name="ticket_externo" placeholder="ticket_externo" value="<?php echo $row['ticket_externo']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="tipo_servicio" class="col-sm-2 control-label">Tipo de Servicio</label>
					<div class="col-sm-10">
						<input type="tipo_servicio" class="form-control" id="tipo_servicio" name="tipo_servicio" placeholder="tipo_servicio" value="<?php echo $row['tipo_servicio']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="id_producto" class="col-sm-2 control-label">ID Producto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="id_producto" name="id_producto" placeholder="id_producto" value="<?php echo $row['id_producto']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="falla" class="col-sm-2 control-label">Falla</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="falla" name="falla" placeholder="falla" value="<?php echo $row['falla']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="observacion" class="col-sm-2 control-label">Observación</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="observacion" name="observacion" placeholder="observacion" value="<?php echo $row['observacion']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="cliente" class="col-sm-2 control-label">Cliente</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="cliente" name="cliente" placeholder="cliente" value="<?php echo $row['cliente']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="ciudad" class="col-sm-2 control-label">Ciudad</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="ciudad" value="<?php echo $row['ciudad']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="proyecto" class="col-sm-2 control-label">Proyecto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="proyecto" name="proyecto" placeholder="proyecto" value="<?php echo $row['proyecto']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="op" class="col-sm-2 control-label">OP</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="op" name="op" placeholder="op" value="<?php echo $row['op']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="estado" class="col-sm-2 control-label">Estado</label>
					<div class="col-sm-10">
						<input type="estado" class="form-control" id="estado" name="estado" placeholder="estado" value="<?php echo $row['estado']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="persona_contacto" class="col-sm-2 control-label">Persona Contacto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="persona_contacto" name="persona_contacto" placeholder="persona_contacto" value="<?php echo $row['persona_contacto']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email Contacto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="email" name="email" placeholder="email" value="<?php echo $row['email_contacto']; ?>"  required>
					</div>
				</div>

				<div class="form-group">
					<label for="archivo" class="col-sm-2 control-label">Archivo Adjunto</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" id="archivo" name="archivo">
						
						<?php
							$path = "files/".$id;
							if(file_exists($path)) {
								$directorio = opendir($path);
								while ($archivo = readdir($directorio)) 
								{
									if(!is_dir($archivo))
									{ 
										echo "<div data='".$path."/".$archivo."'><a href='".$path."/".$archivo."' title='Ver Archivo Adjunto'><span class='glyphicon glyphicon-picture'></span></a>";
										echo "$archivo <a href='#' class='delete' title='Ver Archivo Adjunto' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
										echo "<img src='files/$id/$archivo' width='300' />";
									}
								}
							}
						?>
					</div>
				</div>
				

				<!--
				<div class="form-group">
					<label for="telefono" class="col-sm-2 control-label">Telefono</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Telefono" value="<?php echo $row['telefono']; ?>" >
					</div>
				</div>
				
				<div class="form-group">
					<label for="estado_civil" class="col-sm-2 control-label">Estado Civil</label>
					<div class="col-sm-10">
						<select class="form-control" id="estado_civil" name="estado_civil">
							<option value="SOLTERO" <?php if($row['estado_civil']=='SOLTERO') echo 'selected'; ?>>SOLTERO</option>
							<option value="CASADO" <?php if($row['estado_civil']=='CASADO') echo 'selected'; ?>>CASADO</option>
							<option value="OTRO" <?php if($row['estado_civil']=='OTRO') echo 'selected'; ?>>OTRO</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="hijos" class="col-sm-2 control-label">¿Tiene Hijos?</label>
					
					<div class="col-sm-10">
						<label class="radio-inline">
							<input type="radio" id="hijos" name="hijos" value="1" <?php if($row['hijos']=='1') echo 'checked'; ?>> SI
						</label>
						
						<label class="radio-inline">
							<input type="radio" id="hijos" name="hijos" value="0" <?php if($row['hijos']=='0') echo 'checked'; ?>> NO
						</label>
					</div>
				</div>
				
				<div class="form-group">
					<label for="intereses" class="col-sm-2 control-label">INTERESES</label>
					
					<div class="col-sm-10">
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Libros" <?php if(strpos($row['intereses'], "Libros")!== false) echo 'checked'; ?>> Libros
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Musica" <?php if(strpos($row['intereses'], "Musica")!== false) echo 'checked'; ?>> Musica
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Deportes" <?php if(strpos($row['intereses'], "Deportes")!== false) echo 'checked'; ?>> Deportes
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Otros" <?php if(strpos($row['intereses'], "Otros")!== false) echo 'checked'; ?>> Otros
						</label>
					</div>
				</div>
				
				-->
				
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