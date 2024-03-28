<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/form-validation.css">
    <link rel="icon" type="image/ico" href="IMG/Logo.png">
    <title>Creación Cliente</title>
</head>
<body>

<h1>CREACIÓN CLIENTE</h1>
    
<form action="procesar.php" method="post">
    <label for="nombre_comercial">Nombre Comercial:</label>
    <input type="text" id="nombre_comercial" name="nombre_comercial" required>
    <br><br>
    <label for="razon_social">Razón Social:</label>
    <input type="text" id="razon_social" name="razon_social" required>
    <br><br>
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br><br>
    <label for="telefono">Teléfono:</label>
    <input type="telefono" id="telefono" name="telefono" required>
    <br><br>
    <label for="contacto">Persona Contacto:</label>
    <input type="text" id="contacto" name="contacto" required>    
    <br><br>
    <label for="nit">NIT:</label>
    <input type="number" id="nit" name="nit" required>
    <br><br>
    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="direccion" required>
    <br><br>
    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" required>
    <br><br>
    <label for="departamento">Departamento:</label>
    <input type="text" id="departamento" name="departamento" required>
    <br><br>
    <label for="pais">País:</label>
    <input type="text" id="pais" name="pais" required>
    <br><br>
    <input type="submit" value="Procesar">
</form>

</body>
</html>