<?php
session_start();
if(!isset($_SESSION['ChangeClient'])){
    header("Location: index.php");
}

require_once "../../Con_Database/Conexion.php";
require_once "../../Con_Database/SQL_Protection.php";

$Conexion=Con_Database(GetScheme("../../Scheme.txt"));

if(isset($_POST['submit'])){
    $_POST=SQLProtection($_POST);
    $SQL="SELECT * FROM clientes WHERE `Password`=PASSWORD('".$_POST['OldPassword']."') AND `NIF/CIF`='".$_SESSION['ChangeClient']."'";
    if($Conexion->query($SQL)->num_rows!=1){
        $Error['Password']="La contraseña no es correcta";
    }
    if($_POST['NewPassword']!=$_POST['RepeatPassword']){
        $Error['RepeatPassword']="La nueva contraseña no concuerda con la repetida";
    }
    if(!isset($Error)){
        $SQL="UPDATE clientes set `Password`=PASSWORD('".$_POST['NewPassword']."') WHERE `NIF/CIF`='".$_SESSION['ChangeClient']."'";
        if(!$Conexion->query($SQL)){
            $Error['SQL']="Ha habido un problema en la insercion de la nueva contraseña";
        }
    }
}

include_once "../../ClientHeader.php";
?>
<form action="<?php print($_SERVER['PHP_SELF']);?>" method="POST">
    <label>Contraseña vieja</label><br/>
    <input type="Password" name="OldPassword"/><br/>

    <?php
        if(isset($Error['Password'])){
            print("<p class='Error'>".$Error['Password']."</p>");
        }
    ?>

    <label>Contraseña nueva</label><br/>
    <input type="Password" name="NewPassword"/><br/>
    <label>Repetir contraseña</label><br/>
    <input type="Password" name="RepeatPassword"/><br/>
    
    <?php
        if(isset($Error['RepeatPassword'])){
            print("<p class='Error'>".$Error['RepeatPassword']."</p>");
        }
    ?>

    <input type="submit" name="submit"/>

    <?php
        if(isset($Error['SQL'])){
            print("<p class='Error'>".$Error['SQL']."</p>");
        }
    ?>

</form>
<?php
    if(!isset($Error) && isset($_POST['submit'])){
        print("<p class='Confirmacion'>Su contraseña se ha cambiado correctamente</p>");

        print("<p><a href='index.php' class='SpaceBetween'>Volver al panel de administracion</a></p>");
        unset($_SESSION['ChangeClient']);
    }
?>
<?php
include_once "../../Footer.php";
?>