<?php
	require 'db.php';
	
	$where = "";
	
	if(!empty($_POST))
	{
		$valor = $_POST['campo'];
		if(!empty($valor)){
			$where = "WHERE proyecto LIKE '%$valor%'";
		}
	}
	$sql = "SELECT * FROM stc $where LIMIT 1000";
	$resultado = mysqli_query($conn, $sql);
	
?>
<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">		
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />
		<link rel="icon" type="image/ico" href="img/Logo.png">
		<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>		
		
		
		<script>
			$(document).ready(function() {
				$('#mitabla').DataTable({
					"order":[[1, "asc"]],
					"language":{
					"lengthMenu": "Mostrar _MENU_ registros por pagina",
					"info": "Mostar pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtrada de _MAX_ registros)",
						"loadingRecords": "Cargando...",
						"processing": 	  "Procesando...",
						"search": "Buscar:",
						"zeroRecords":     "No se encontraron registros coincidentes",
						"paginate": {
							"next":        "Siguiente",
							"previous":    "Anterior"
						},
					},
					"bProcessing": true,
					"bServerSide": false, /* OJOJOJO HAY QUE REVISAR ESTA PARTE YA QUE NO ESTÁ CONECTANDO AL SERVER PROCESS */
					"sAjaxSource": "server_process.php"
				});
			});
		</script>
		
	

	</head>
	
	<body>
		
		<form class="form-horizontal" method="POST" action="guardar.php" autocomplete="off">
			<input type="hidden" id="id_stc" name="id_stc" value="">
			<div class="form-group">
			</div>

		<div class="container">
			<div class="row">
				<h2 style="text-align:center">SERVICIO TÉCNICO AL CLIENTE</h2>
			</div>
			<br>
		</form>
			
			<br>
			
			<div class="row">
				<a href="nuevo.php" class="btn btn-primary">Nuevo Registro</a>
				
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST"><br>
					<b>Proyecto: </b><input type="text" id="campo" name="campo" />
					<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-info" />
				</form>
			</div>
			
			<br>
			
			<div class="row table-responsive">
				<table class="display" id="mitabla">
					<thead>
						<tr>
							<th>ID</th>
							<th>ID STC</th>
							<th>Fecha Ingreso</th>
							<th>Medio de Ingreso</th>
                            <th>Ticket Externo</th>
                            <th>Tipo Servicio</th>
                            <th>Id Producto</th>
							<th>Falla</th>
							<th>Observación</th>
                            <th>Cliente</th>
                            <th>Ciudad</th>
                            <th>Proyecto</th>
                            <th>OP</th>
                            <th>Estado STC</th>
							<th>Persona Contacto</th>
                            <th>Email Contacto</th>
							<th>ID Usuario</th>
                            <th></th>
                            <th></th>
						</tr>
					</thead>
					
					<tbody>
						<?php while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['id_stc']; ?></td>
                                <td><?php echo $row['fecha_ingreso']; ?></td>
                                <td><?php echo $row['medio_ingreso']; ?></td>
                                <td><?php echo $row['ticket_externo']; ?></td>
                                <td><?php echo $row['tipo_servicio']; ?></td>
                                <td><?php echo $row['id_producto']; ?></td>
                                <td><?php echo $row['falla']; ?></td>
                                <td><?php echo $row['observacion']; ?></td>
                                <td><?php echo $row['cliente']; ?></td>
                                <td><?php echo $row['ciudad']; ?></td>
                                <td><?php echo $row['proyecto']; ?></td>
                                <td><?php echo $row['op']; ?></td>
								<td><?php echo $row['estado']; ?></td>
								<td><?php echo $row['persona_contacto']; ?></td>
                                <td><?php echo $row['email_contacto']; ?></td>
								<td><?php echo $row['id_usuario']; ?></td>
								<td><a href="modificar.php?id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><a href="#" data-href="eliminar.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
					</div>
					
					<div class="modal-body">
						¿Desea eliminar este registro?
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a class="btn btn-danger btn-ok">Delete</a>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$('#confirm-delete').on('show.bs.modal', function(e) {
				$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
				
				$('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
			});
		</script>	
		
	</body>
</html>	


