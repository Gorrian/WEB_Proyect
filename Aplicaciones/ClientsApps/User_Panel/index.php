<?php
include_once "../../Con_Database/Conexion.php";
include_once "../../Con_Database/SQL_Protection.php";
session_start();
$Conexion=Con_Database(GetScheme("../../Scheme.txt"));


if(isset($_POST['submit'])){
    $_POST=SQLProtection($_POST);
    if($_POST['submit']=="Cambiar"){
        foreach($_POST as $Index => $Value){
            if($Index!="submit" && $Index!="NIF/CIF"){
                if(empty($Value)){
                    $SQL="UPDATE clientes SET `".str_replace("_",".",$Index)."`=NULL WHERE `NIF/CIF`='".$_SESSION['Client']."'";
                }else{
                    $SQL="UPDATE clientes SET `".str_replace("_",".",$Index)."`='$Value' WHERE `NIF/CIF`='".$_SESSION['Client']."'";
                }
                
                $Status=$Conexion->query($SQL);
                if(!$Status){
                    $Error[$Index]="Error en la insercion de este elemento";
                }
            }
        }
    }else if($_POST['submit']=="Cambiar Contraseña"){
        $_SESSION['ChangeClient']=$_SESSION['Client'];
        header("Location: CambiarContraseña.php");
    }
}

if(!isset($_SESSION['Client'])){
    header("Location: /index.php?ERROR=1");
}



@include_once "../../ClientHeader.php";




$SQL="SELECT * FROM clientes WHERE `NIF/CIF`='".$_SESSION['Client']."'";
$UserInfo=$Conexion->query($SQL)->fetch_assoc();
print("<form action='".$_SERVER['PHP_SELF']."' method='POST'>");
print("<label>NIF/CIF</label><br/>");
print("<input type='text' name='NIF/CIF' value='".$UserInfo['NIF/CIF']."' readonly/><br/>");
if(isset($Error['NIF/CIF'])){
    print("<p class='Error'>".$Error['NIF/CIF']."</p>");
}
print("<label>Nombre</label><br/>");
print("<input type='text' name='Nombre' value='".$UserInfo['Nombre']."' required/><br/>");
if(isset($Error['Nombre'])){
    print("<p class='Error'>".$Error['Nombre']."</p>");
}
print("<label>Correo electronico</label><br/>");
print("<input type='text' name='C.electronico' value='".$UserInfo['C.electronico']."'/><br/>");
if(isset($Error['C_electronico'])){
    print("<p class='Error'>".$Error['C_electronico']."</p>");
}
print("<label>Telefono</label><br/>");
print("<input type='text' name='Telefono' maxlength='9' value='".$UserInfo['Telefono']."'/><br/>");
if(isset($Error['Telefono'])){
    print("<p class='Error'>".$Error['Telefono']."</p>");
}
print("<label>Localidad</label><br/>");
print("<input type='text' name='Localidad' value='".$UserInfo['Localidad']."'/><br/>");
if(isset($Error['Localidad'])){
    print("<p class='Error'>".$Error['NIF/CIF']."</p>");
}
print("<input type='submit' name='submit' value='Cambiar'/>");
print("</form>");


print("<form action='".$_SERVER['PHP_SELF']."' method='POST'>");
print("<input type='submit' name='submit' value='Cambiar Contraseña'/>");
print("</form>");

print("<form action='".$_SERVER['PHP_SELF']."' method='POST'>");
print("<input type='submit' name='submit' value='Eliminar cuenta' class='Peligro' onclick='return confirm(\"Esta accion eliminara su cuenta y toda la informacion relacionada a ella, incluyendo pedidos. ¿Desea continuar?\")'/>");
print("</form>");
if(!isset($Error) && isset($_POST['submit'])){
    print("<p class='Confirmacion'>Cambio efectuado en su cuenta</p>");
}
?>
<?php
include_once "../../Footer.php";
?>