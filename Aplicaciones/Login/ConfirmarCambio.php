<?php
session_start();
if(isset($_POST['Cambiar'])){
    MaintainConection();
    $Conexion=$_SESSION['Conexion'];
    if($Conection->connect_errno){
        die("Error de Conexion (".$Conection->connect_errno.") ". $Conection->connect_error);
    }else{

    }
}

?>