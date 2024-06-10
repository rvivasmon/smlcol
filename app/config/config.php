<?php 

// Localmente

define('BD_SERVIDOR','localhost');
define('BD_USUARIO','RandyVivas');
define('BD_PASSWORD','');
define('BD_SISTEMA','bd_sigcp_2024');


// Servidor
/*
define('BD_SERVIDOR','201.148.107.151');
define('BD_USUARIO','smartled_SIGCP_admin');
define('BD_PASSWORD','TI_2024*');
define('BD_SISTEMA','smartled_smartled_bd_sigcp_2024');

*/
// Localmente
//$URL = 'http://localhost/www.smlcol.com/';

// Smartled TI LAN
//$URL = 'http://192.168.1.105/www.smlcol.com/';

// SmartLed3 LAN
//$URL = 'http://192.168.88.23/www.smlcol.com/';

// House
$URL = 'http://192.168.1.8/www.smlcol.com/';

// LAN 3
//$URL = 'http://192.168.10.167/www.smlcol.com/';

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
