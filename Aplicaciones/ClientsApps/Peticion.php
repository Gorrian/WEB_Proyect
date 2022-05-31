<?php
session_start();
if(!isset($_SESSION['Client'])){
    header("Location: /index.php",true, 303);
}

include_once "../ClientHeader.php";
include "../Con_Database/Conexion.php";
include "../Con_Database/SQL_Protection.php";

$Conexion=Con_Database(GetScheme("../Scheme.txt"));

function PrintError(int $Code, array $ErrorCodes){
    if(isset($ErrorCodes[$Code])){
        print("<p class='Error'>".$ErrorCodes[$Code]."</p>");
    }
}

$ERROR=array();

if(isset($_POST['submit'])){
    $_POST=SQLProtection($_POST);
    if(!empty($_POST['Location']) && isset($_POST['TipoServicio']) && (!empty($_POST['Email']) || !empty($_POST['Phone']))){
        $SQL="INSERT INTO pedidos (`ID.cliente`,`Fecha de peticion`,`Localizacion`)
        VALUES ('".$_SESSION['Client']."',NOW(),'".$_POST['Location']."')";
        $Conexion->query($SQL) or print("<p class='Error'>Error en la insercion de datos</p>");
        if(isset($_POST['KeepLocation'])){
            $SQL="UPDATE `clientes` SET `Localidad`='".$_POST['Location']."' WHERE `NIF/CIF`='".$_SESSION['Client']."'";
            $Conexion->query($SQL);
        }
        $SQL="SELECT MAX(`ID.pedido`) FROM pedidos";
        $IDPedido=$Conexion->query($SQL)->fetch_row()[0];
        foreach($_POST['TipoServicio'] as $Value){
            $SQL="INSERT INTO `servicios-asignados` (`ID.Servicio`, `ID.Pedido`)
            VALUES ($Value , $IDPedido)";
            $Conexion->query($SQL) or print("<p class='Error'>Error en la insercion de datos</p>");
        }
        if(!empty($_POST['Email'])){
            $SQL="UPDATE pedidos SET `C.electronico`='".$_POST['Email']."' WHERE `ID.pedido`=".$IDPedido;
            $Conexion->query($SQL) or print("<p class='Error'>Error en la insercion de datos</p>");
            if(isset($_POST['KeepEmail'])){
                $SQL="UPDATE `clientes` SET `C.electronico`='".$_POST['Email']."' WHERE `NIF/CIF`='".$_SESSION['Client']."'";
                $Conexion->query($SQL);
            }
        }
        if(!empty($_POST['Phone'])){
            $SQL="UPDATE pedidos SET `Telefono`='".$_POST['Phone']."' WHERE `ID.pedido`=".$IDPedido;
            $Conexion->query($SQL) or print("<p class='Error'>Error en la insercion de datos</p>");
            if(isset($_POST['KeepPhone'])){
                $SQL="UPDATE `clientes` SET `Telefono`='".$_POST['Phone']."' WHERE `NIF/CIF`='".$_SESSION['Client']."'";
                $Conexion->query($SQL);
            }
            
        }
    }else{
        if(empty($_POST['Location'])){
            $ERROR[0]="Es necesario que especifique la localizacion";
        }
        if(!isset($_POST['TipoServicio'])){
            $ERROR[1]="Es necesario que especifique al menos un tipo de servicio";
        }
        if(empty($_POST['Email']) && empty($_POST['Phone'])){
            $ERROR[2]="Es necesario que especifique al menos un metodo de contacto";
        }
    }
    
}


$SQL="SELECT * FROM clientes WHERE `NIF/CIF`='".$_SESSION['Client']."'";
$ClientInfo=$Conexion->query($SQL)->fetch_assoc();
print("<form action='".$_SERVER['PHP_SELF']."' method='post'>");

print("<label>Localizacion de su centro</label><br/>");
print("<input type='text' name='Location'");
if(!is_null($ClientInfo['Localidad'])){
    print("value='".$ClientInfo['Localidad']."'");
}
print("/><br/>");

print("<input type='checkbox' name='KeepLocation'");
print("/><label>Desea guardar esta informacion para posteriores peticiones</label><br/>");

PrintError(0,$ERROR);

print("<label>Tipo de servicio</label><br/>");
print("<select name='TipoServicio[]' multiple>");
$SQL="SELECT * FROM `t.servicio`";
$TipoServicios=$Conexion->query($SQL);
for($i=0;$i<$TipoServicios->num_rows;$i++){
    $ROW=$TipoServicios->fetch_assoc();
    print("<option value='".$ROW['ID']."'>".$ROW['Nom.servicio']."</option>");
}
print("</select>");

PrintError(1,$ERROR);

print("<h3>Informacion de contacto</h3>");
print("<p>Debe rellenar uno de los dos campos</p>");

PrintError(2,$ERROR);

print("<label>Correo electronico</label><br/>");
print("<input type='text' name='Email' pattern='[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'");
if(!is_null($ClientInfo['C.electronico'])){
    print(" value='".$ClientInfo['C.electronico']."'");
}
print("/><br/>");

print("<input type='checkbox' name='KeepEmail'");
print("/><label>Desea guardar esta informacion para posteriores peticiones</label><br/>");

print("<label>Numero de telefono</label><br/>");
print("<input type='text' name='Phone' maxlength='9' pattern='[0-9]{9}'");
if(!is_null($ClientInfo['Telefono'])){
    print(" value='".$ClientInfo['Telefono']."'");
}
print("/><br/>");

print("<input type='checkbox' name='KeepPhone''");
print("/><label>Desea guardar esta informacion para posteriores peticiones</label><br/>");

print("<input type='submit' name='submit'/>");

print("</form>");
if(empty($ERROR)){
    print("<p class='Confirmacion'><b>Se ha guardado vuestra peticion, nos pondremo en contacto con la informacion proporcionada.</b></p>");
}
?>