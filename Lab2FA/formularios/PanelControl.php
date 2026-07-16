<?php
include($_SERVER['DOCUMENT_ROOT'] . "/Lab2FA/comunes/bloque_Seguridad.php");

$menu08 = " id=\"current\"";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<meta name="Description" content="Sistema Central." />
<meta name="Keywords" content="your, keywords" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="fulano de tal - fulano@gmail.com" />
<meta name="Robots" content="index,follow" />

<title>Panel de Control</title>

<!-- CSS CORRECTO (SEGÚN TU RUTA REAL) -->
<link rel="stylesheet" href="/Lab2FA/public/assets/css/Techmania.css" />
<link rel="stylesheet" href="/Lab2FA/public/assets/css/mainModificado.css">
<link rel="stylesheet" href="/Lab2FA/public/assets/css/shortcodes.css">
<link rel="stylesheet" href="/Lab2FA/public/assets/css/settings.css">
<link rel="stylesheet" href="/Lab2FA/public/assets/css/color-scheme/turquoise.css">

<!-- ICONO -->
<link rel="shortcut icon" href="/Lab2FA/public/assets/img/iconos/gnome.ico">

</head>

<body>

<?php
$Usuario = $_SESSION['Usuario'];
?>

<div id="wrap">

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Lab2FA/comunes/cabecera4.php"); ?>

<div id="content-wrap">
<div id="main">

<h1>USUARIO: <?php echo strtoupper($Usuario); ?></h1>

<?php if (isset($_GET['id_mess'])) { ?>
    <p><code>
        <font color="#FF0000">
            <?php echo Mensajes($_GET['id_mess']); ?>
        </font>
    </code></p>
<?php } ?>

<p><code>

<?php
$dia = date("j");
$mes = date("n");
$anio = date("Y");

$meses = [
  1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",
  5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",
  9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
];

if ($mes == 12) {
    echo "Dios me los bendiga y Feliz Navidad y Próspero Año Nuevo.<br>";
} else {
    echo "Bendiciones en este día.<br>";
}

echo "Hoy es $dia de {$meses[$mes]} de $anio.<br>";
?>

</code></p>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Lab2FA/formularios/TableroMenu.php"); ?>

<br><br><br>

</div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/Lab2FA/comunes/footer.php"); ?>

</div>

</body>
</html>