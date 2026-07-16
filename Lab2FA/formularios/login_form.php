<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta name="Description" content="Ejemplo de Login" />
    <meta name="Keywords" content="your, keywords" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Irina Fong - dreamsweb7@gmail.com" />
    <meta name="Robots" content="index,follow" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <link rel="shortcut icon" href="patria/5564844.png">

    <link rel="stylesheet" href="/Lab2FA/public/assets/css/cmxform.css">
    <link rel="stylesheet" href="/Lab2FA/public/assets/css/Techmania.css">
    <link rel="stylesheet" href="/Lab2FA/public/assets/css/general.css">
    
    <title>Ejemplo de Prueba del Login</title>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#deteccionUser").validate({
     		 rules: {
        		usuario: "required",
    			contrasena: "required",
    		 }
    	});	
     });
    </script>
</head>

<body>
<div id="wrap">
  <div id="headerlogin"></div>
  <p>
    <a href=""><img src="/Lab2FA/public/assets/img/regresar.gif" alt="Atr&aacute;s" width="90" height="30" longdesc="login.php" /></a>
  </p>

   <div align="center">
    <form class="cmxform" id="deteccionUser" name="deteccionUser" method="post" action="public/index.php">
      <?php
      if (empty($_SESSION['csrf_token'])) {
          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      }
      ?>
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <input type="hidden" name="tolog" id="tolog" value="true"/>
      
      <br />
      <table width="89%" border="0" align="center">
        <tr>
          <td height="19" colspan="2" align="center"><b>Desarrollo de Software VII | UTP</b></td>
        </tr>
        <tr>
          <td width="25%">Usuario:</td>
          <td width="42%"><input id="usuario" name="usuario" type="text" minlength="4" /></td>
        </tr>
        <tr>
          <td>Contrase&ntilde;a:</td>
          <td><input id="contrasena" name="contrasena" type="password" /></td>
        </tr>
		<tr>
          <td colspan="2" align="center">                     
            <div align="center">
              <input name="Submit" type="submit" class="clear" value="Buscar" />
              <br /><small>(*Dos clic o enter para entrar)</small>
            </div>
          </td>
        </tr>
        <?PHP if (isset($_SESSION["emsg"]) && $_SESSION["emsg"] == 1){ ?>
        <tr>
          <td colspan="2">
            <div id="error">
              <p class="login-error" align="center" style="color: #FF0000;">
                Usuario y contraseña incorrectos, vuelva a digitar la info.<br>
              </p>
            </div>
          </td>
        </tr>
        <?PHP 
            unset($_SESSION["emsg"]); 
        } 
        ?>
      </table>
      <br />
    </form>
   </div>
   <br />

  <?PHP include("comunes/footer.php");?>
</div>	
</body>
</html>