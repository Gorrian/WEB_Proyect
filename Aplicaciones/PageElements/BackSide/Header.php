<!DOCTYPE html>
<?php
require "../../Con_Database/Conexion.php";
session_start();

$Conexion=Con_Database(GetScheme("../../Scheme.txt"));
if($Conexion->connect_errno){
    die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
}
?>
<html>
    <head>

    </head>
    <body>
        <nav>
            <ul>
                <?php
                    $SQL="SELECT ADMIN FROM TRABAJADORES WHERE DNI='".$_SESSION['DNI']."' AND ADMIN=1";
                    if($Conexion->query($SQL)->num_rows!=0){
                        print <<<HERE
                            <li>
                            <a href=\"\">Administrar usuarios</a>
                            </li>
                        HERE;
                    }
                ?>
            </ul>
        </nav>
    </body>
</html>