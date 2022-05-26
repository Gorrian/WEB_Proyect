<?php
include_once "../../head.php";
print("</head>");
require("../../Con_Database/Conexion.php");
require("../../Con_Database/SQL_Protection.php");

session_start();

if(isset($_POST['Cambiar']) && $_POST['Password']==$_POST['Confirmar'] && $_SESSION['ChangePassword']!=$_POST['Password'] && !empty($_POST['Password'])){
    $Conexion=Con_Database('db_proyecto');
    if($Conexion->connect_errno){
        die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
    }else{
        $_POST=SQLProtection($_POST);
        $SQL="UPDATE TRABAJADORES SET Change_password=0,
        `Password`=Password('".$_POST['Password']."')
        WHERE DNI='".$_SESSION['ChangeDNI']."'";
        if(!$Conexion->query($SQL)){
            print("<h3>Ha habido un problema al actualizar su contraseña</h3>");
        }else{
            print("<h3>Su contraseña se ha cambiado correctamente</h3>");
        }
        unset($_SESSION['ChangeDNI']);
        unset($_SESSION['ChangePassword']);
        print("<p><a href=\"Login.php\">Volver al Login</a></p>");
    }
}else{
    if(!isset($_POST['Cambiar'])){
        header("Location: Login.php");
    }else if($_SESSION['ChangePassword']==$_POST['Password']){
        header("Location: ChangePassword.php?ERROR=1");
    }else if(empty($_POST['Password'])){
        header("Location: ChangePassword.php?ERROR=3");
    }else{
        header("Location: ChangePassword.php?ERROR=2");
    }
    
}

?>