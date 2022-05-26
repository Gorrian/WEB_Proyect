<?php
include "../Con_Database/Conexion.php";
include "../Con_Database/SQL_Protection.php";
include "../head.php";
print("</head>");
session_start();
$Conexion=Con_Database(GetScheme("../Scheme.txt"));

if(isset($_POST['CerrarSession'])){
    unset($_SESSION['Client']);
    unset($_SESSION['ClientName']);
}
if(isset($_POST['IniciarSession'])){
    $_POST=SQLProtection($_POST);
    $SQL="SELECT * FROM clientes 
    WHERE `NIF/CIF`='".$_POST['ID']."' 
    AND `Password`=PASSWORD('".$_POST['password']."')";
    $User=$Conexion->query($SQL);
    if($User->num_rows==1){
        $Username=$User->fetch_assoc()['Nombre'];
        $_SESSION['Client']=$_POST['ID'];
        $_SESSION['ClientName']=$Username;
    }else{
        print("<p class='Error'>Sus credenciales o identificador son incorrectos</p>");
    }

}

print("<form action='".$_SERVER['PHP_SELF']."' method='post'>");
if(isset($_SESSION['Client'])){
    print("<p>".$_SESSION['ClientName']."</p>");
    print("<input type='submit' name='CerrarSession' value='Cerrar session'/>");
}else{
    print("<label>DNI/NIF</label><br/>");
    print("<input type='text' name='ID'/><br/>");
    print("<label>Contraseña</label><br/>");
    print("<input type='password' name='password'/><br/>");
    print("<input type='submit' name='IniciarSession' value='Iniciar session'/>");
}
print("</form>");
?>