<?php 

// Localmente

define('BD_SERVIDOR','localhost');
define('BD_USUARIO','TIadmin');
define('BD_PASSWORD','TI_2024*');
define('BD_SISTEMA','bd_smlcol');


// Servidor
/*
define('BD_SERVIDOR','201.148.107.151');
define('BD_USUARIO','smartled_SIGCP_admin');
define('BD_PASSWORD','TI_2024*');
define('BD_SISTEMA','smartled_BD_SIGCP_2024');

*/
// Localmente
//$URL = 'http://localhost/www.smlcol.com/';

// Servidor House
//$URL = 'http://192.168.1.8/www.smlcol.com/';

// SmartLed3 LAN
$URL = 'http://192.168.0.234/www.smlcol.com/';

// SmartLed
//$URL = 'http://192.168.0.124/www.smlcol.com/';

// SmarteLed2
//$URL = 'http://192.168.1.26/www.smlcol.com/';

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


$fecha_actual = date(format: 'Y-m-d');
$dia_actual = date(format: 'd');
$mes_actual = date(format: 'm');
$anio_actual = date(format: 'Y');
