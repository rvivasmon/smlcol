<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$id_cargo = $_POST['id_cargo'];
$password = $_POST['password'];
$verificar_password = $_POST['verificar_password'];

$passwordencriptada = password_hash($password, PASSWORD_DEFAULT);

if($password == $verificar_password) {
    //echo "Contraseñas Correctas";

    // Obtener el ID del cliente seleccionado del formulario
    $id_cliente = $_POST['id_cliente'];

    // Validar si el usuario existe
    $email_tabla = '';
    $query_usuarios = $pdo->prepare("SELECT * FROM usuarios WHERE email = '$email'");
    $query_usuarios->execute();
    $usuarios = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as $usuario){
        $email_tabla = $usuario['email'];
    }
    if( $email_tabla == $email){
        echo "Este usuario ya existe";
    }else{

        $sql = "INSERT INTO usuarios (nombre, email, usuario, contraseña, id_cargo, id_cliente) VALUES (:nombre, :email, :usuario, :password, :id_cargo, :id_cliente)";

        $sentencia = $pdo->prepare($sql);

        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':usuario', $usuario);
        $sentencia->bindParam(':password', $passwordencriptada);
        $sentencia->bindParam(':id_cargo', $id_cargo);
        $sentencia->bindParam(':id_cliente', $id_cliente);

        try {
            if ($sentencia->execute()) {
                // Obtener el ID del usuario insertado
                $id_usuario_insertado = $pdo->lastInsertId();
                
                // Actualizar el campo id_usuario en la tabla clientes
                $sql_actualizar_cliente = "UPDATE clientes SET id_usuario = :id_usuario WHERE id = :id_cliente";

                $sentencia_actualizar_cliente = $pdo->prepare($sql_actualizar_cliente);
                $sentencia_actualizar_cliente->bindParam(':id_usuario', $id_usuario_insertado);
                $sentencia_actualizar_cliente->bindParam(':id_cliente', $id_cliente);
                $sentencia_actualizar_cliente->execute();


            session_start();
                $_SESSION['Mensajes'] = array(
                    'title' => 'Good job!',
                    'text' => '¡Usuario creado exitosamente!',
                    'icon' => 'success'
                );
                header('Location: '.$URL.'admin/ti/usuarios/');
                exit;
            } else {
                throw new Exception("Error al insertar el usuario");
            }
        } catch (Exception $e) {
            session_start();
            $_SESSION['Mensajes'] = array(
                'title' => 'Error',
                'text' => 'Error al introducir la información: ' . $e->getMessage(),
                'icon' => 'error'
            );
            header('Location: ' . $URL . 'admin/ti_usuarios/create.php');
            exit;
        };
    };
}