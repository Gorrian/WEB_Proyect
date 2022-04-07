<?php
function Con_Database(String $Database=NULL){
    $Hostname="127.0.0.1";
    $User="root";    //IMPORTANTE: En produccion hay que cambiar el usuario por uno seguro
    $Password="";    //IMPORTANTE: Y claro que el usuario tenga una contraseña y que solo tenga acceso a la base de datos que le toca.

    if(is_null($Database)){
        $Conexion=new mysqli($Hostname,$User,$Password);
    }else{
        $Conexion= new mysqli ($Hostname,$User,$Password,$Database);
    }
    return $Conexion;
}
?>