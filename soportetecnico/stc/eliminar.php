<?php
	
	require 'db.php';

	$id = $_GET['id'];
	
	$sql = "DELETE FROM stc WHERE id = '$id'";
	$resultado = mysqli_query($conn, $sql);

	eliminarDir('files/'.$id);

	function eliminarDir($carpeta) {
		if (!file_exists($carpeta)) {
			echo "";
			return;
		}
		if (is_dir($carpeta)) {
		foreach(glob($carpeta. "/*") as $archivo_carpeta) {
			if (is_dir($archivo_carpeta)) {
				eliminarDir($archivo_carpeta);
			} else {
				unlink($archivo_carpeta);
			}
		}
	} else {
		unlink($carpeta);
	}
		rmdir($carpeta);
	}
?>

<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<link rel="icon" type="image/ico" href="img/Logo.png">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>	
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="row" style="text-align:center">
				<?php if($resultado) { ?>
				<h3>REGISTRO ELIMINADO</h3>
				<?php } else { ?>
				<h3>ERROR AL ELIMINAR</h3>
				<?php } ?>
				
				<a href="index.php" class="btn btn-primary">Regresar</a>
				
				</div>
			</div>
		</div>
	</body>
</html>
