<?php
session_start();
if(!isset($_SESSION['ChangeClient'])){
    header("Location: index.php");
}

require_once "../../Con_Database/Conexion.php";
require_once "../../Con_Database/SQL_Protection.php";

if(isset($_POST['submit'])){
    $_POST=SQLProtection($_POST);
    $SQL="SELECT * FROM clientes WHERE ";
}

include_once "../../ClientHeader.php";
?>
<form action="<?php print($_SERVER['PHP_SELF']);?>" method="POST">
    <label>Contraseña vieja</label><br/>
    <input type="Password" name="OldPassword"/><br/>
    <label>Contraseña nueva</label><br/>
    <input type="Password" name="NewPassword"/><br/>
    <label>Repetir contraseña</label><br/>
    <input type="Password" name="RepeatPassword"/><br/>
    <input type="submit" name="submit"/>
</form>

<?php
include_once "../../Footer.php";
?>