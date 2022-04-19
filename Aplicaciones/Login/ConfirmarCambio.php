<?php
require("../Con_Database/Conexion.php");
require("../Con_Database/SQL_Protection.php");

session_start();

if(isset($_POST['Cambiar'])){
    $Conexion=Con_Database('db_proyecto');
    if($Conexion->connect_errno){
        die("Error de Conexion (".$Conection->connect_errno.") ". $Conection->connect_error);
    }else{
        $SQL="UPDATE TRABAJADORES SET Change_password=0,
        `Password`=Password('".$_POST['Password']."')
        WHERE DNI='".$_SESSION['ChangeDNI']."'";
        print_r($SQL);
        if(!$Conexion->query($SQL)){
            print("<h3>Ha habido un problema al actualizar su contraseña</h3>");
        }else{
            print("<h3>Su contraseña se ha cambiado correctamente</h3>");
        }
        unset($_SESSION['ChangeDNI']);
        unset($_SESSION['Password']);
        print("<p><a href=\"Login.php\">Volver al Login</a></p>");
    }
}else{
    header("Location: Login.php");
}

?>