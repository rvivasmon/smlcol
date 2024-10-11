<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$pitch = $_POST['pitch'];
$categoria = $_POST['categoria'];
$sub = $_POST['sub'];
$tipo = $_POST['tipo'];
$medidas = $_POST['medidas'];
$nits = $_POST['nits'];
$refresh = $_POST['refresh'];
$standard = $_POST['standard'];

// Obtener el ID del cliente seleccionado del formulario
$usuario = $_POST['id_usuario'];



        $sql = "INSERT INTO tabla_modulos (categoria, producto, tipo, pitch, medida, nits, refresh, standard, usuario) VALUES (:categoria, :sub, :tipo, :pitch, :medidas, :nits, :refresh, :standard, :usuario)";

        $sentencia = $pdo->prepare($sql);

        $sentencia->bindParam(':categoria', $categoria);
        $sentencia->bindParam(':sub', $sub);
        $sentencia->bindParam(':tipo', $tipo);
        $sentencia->bindParam(':pitch', $pitch);
        $sentencia->bindParam(':medidas', $medidas);
        $sentencia->bindParam(':nits', $nits);
        $sentencia->bindParam(':refresh', $refresh);
        $sentencia->bindParam(':standard', $standard);
        $sentencia->bindParam(':usuario', $usuario);

        try {
            if ($sentencia->execute()) {

            session_start();
                $_SESSION['Mensajes'] = array(
                    'title' => 'Good job!',
                    'text' => '¡Usuario creado exitosamente!',
                    'icon' => 'success'
                );
                header('Location: '.$URL.'admin/almacen/crear_modulos/');
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
