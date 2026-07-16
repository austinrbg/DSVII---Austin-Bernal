<?PHP
session_start();  
include ("../config/mysql.inc.php");	
$db = new mod_db();

include("../app/Helpers/SanitizarEntrada.php");
include("../comunes/loginfunciones.php");
include("../app/Models/objLoginAdmin.php");

$tolog=false;
 
if (isset($_POST["tolog"])) {
    $tolog = $_POST["tolog"];
}
 
if(isset($tolog) && ($tolog=="true") && ($_SERVER['REQUEST_METHOD'] === 'POST') ){
    
    // --- DEBUG ANTI-CSRF TEMPORAL ---
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        
        $post_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : 'NO EXISTE EN EL FORMULARIO';
        $session_token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : 'NO EXISTE EN EL SERVIDOR';
        
        die("<div style='color:black; text-align:center; padding:20px; font-family:Arial; background: #f4f4f4; border: 2px solid red;'>
                <h3>🔍 Modo Debug: ¿Quién tiene la culpa?</h3>
                <p><b>Token que mandó tu formulario:</b> <br> $post_token</p>
                <p><b>Token que guardó el servidor:</b> <br> $session_token</p>
                <br>
                <a href='../login.php'>Volver al inicio</a>
             </div>");
    }
    // --------------------------------
             
    $Usuario = $_POST['usuario'];
    $ClaveKey = $_POST['contrasena'];

    $ipRemoto = $_SERVER['REMOTE_ADDR'];

    $Logearme = new ValidacionLogin($Usuario, $ClaveKey, $ipRemoto, $db);
    
    if ($Logearme->logger()){
        $Logearme->autenticar();
        
        if ($Logearme->getIntentoLogin()){
            
            $_SESSION['2fa_pendiente'] = "SI"; 
            $_SESSION['Usuario'] = $Logearme->getUsuario();
            
            $Logearme->registrarIntentos();
            $tolog=false;
            
            redireccionar("../Autenticar.php"); 
            
        } else {
            $Logearme->registrarIntentos();
            $_SESSION["emsg"] = 1;
            redireccionar("../login.php");
        }
        
    } else {
        $_SESSION["emsg"] = 1;
        redireccionar("../login.php");
    }
        
} else {
    redireccionar("../login.php");
}
?>