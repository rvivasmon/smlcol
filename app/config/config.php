<?php 

// Localmente



define('BD_SERVIDOR','localhost');
define('BD_USUARIO','RandyVivas');
define('BD_PASSWORD','');
define('BD_SISTEMA','bd_sigcp_2024');



// Servidor

/*

define('BD_SERVIDOR','localhost');
define('BD_USUARIO','smartled_TIadmin');
define('BD_PASSWORD','TI_2024*');
define('BD_SISTEMA','smartled_bd_sigcp_2024');

*/

// Servidor
//$URL = 'http://sigcp2024.smartledcolombia.com/';

// House
$URL = 'http://192.168.2.3/www.smlcol.com/';

// Local
//$URL = 'http://192.168.88.17/www.smlcol.com/';


if(isset($_SESSION['mensaje'])){ 
    $respuesta = $_SESSION['mensaje']; ?>
<script>
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: '<?php echo $respuesta; ?>',
        showConfirmButton: false,
        timer: 2500
        })                    
</script>
<?php
unset($_SESSION['mensaje']);
}


$fecha_actual = date('Y-m-d');
$dia_actual = date('d');
$mes_actual = date('m');
$anio_actual = date('Y');
