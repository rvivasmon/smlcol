<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="IMG/Logo.png">
    <title>Registro de Usuarios</title>
</head>
<body>
    
    <h1 class="texto-center blanco">REGISTRO USUARIO</h1>

    <form class="text-center bg-dark" action="registro.php" method="POST">

        <img class="logo" src="IMG/smlnegro.png" width="10%" height="5%">
        <div class="mb-3"><br>

            <label for="exampleInputEmail1" class="form-label blanco">NOMBRE COMPLETO</label>
            <input type="text" class="form-control bg-ligth" name="txtNombre">
            <br><br>

        </div>
        <div class="mb-3">

            <label for="exampleInputPassword1" class="form-label blanco">USUARIO</label>
            <input type="text" class="form-control bg-ligth" name="txtUsuario">
            <br><br>
            
        </div>
        <div class="mb-3">

            <label for="exampleInputPassword1" class="form-label blanco">CONTRASEÑA</label>
            <input type="text" class="form-control bg-ligth" name="txtContraseña">
            <br><br>

        </div>
        <div>
            <label for="exampleInputUsuario" class="form-label blanco">TIPO USUARIO</label>
            <select name="txtTipoUsuario" class="form-control bg-ligth">

                <?php                       
                include("db.php");
                $getTipoUsuario1 ="SELECT* FROM cargo order by id";
                $getTipoUsuario2 = mysqli_query($conn, $getTipoUsuario1);

                while($row = mysqli_fetch_array($getTipoUsuario2))
                {
                    $id = $row["id"];
                    $descripcion = $row["descripcion"];

                ?>

                    <option value="<?php echo $id; ?>"><?php echo $descripcion; ?></option>

                <?php 
                }                
                ?>
            </select>
            <br><br>

            <div id="emailHelp" class="verde">VERIFIQUE LOS DATOS PROPORCIONADOS</div>
            <br><br>
        </div>
        <button type="submit" class="btn btn-success">REGISTRAR</button>
    </form><br>

</body>
</html>