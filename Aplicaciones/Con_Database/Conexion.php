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

//Esta funcion procura de minimizar la cantidad de conexiones
//que un usuario puede hacer navegando en esta revisando si existe
//una conexion en la session y si no la hay la crea.
function MaintainConection(){
    if(isset($_SESSION['Conexion'])){
        print_r($_SESSION['Conexion']);
        return;
    }else{
        $Conexion=Con_Database("db_proyecto");
        $_SESSION['Conexion']=serialize($Conexion);
        print_r($_SESSION['Conexion']);
        return;
    }
}
function GetScheme(String $File="Scheme.txt"){
    if(!isset($_SESSION['SCHEME']) || empty($_SESSION['SCHEME'])){
        $Content=fopen($File, "r");
        feof($Content);
        $_SESSION['SCHEME']=fgets($Content);
    }
    return $_SESSION['SCHEME'];
}
?>