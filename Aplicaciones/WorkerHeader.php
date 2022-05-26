<!DOCTYPE html>
<html>
<?php
include_once "head.php";
print("</head>");
require_once "Con_Database/Conexion.php";
session_start();


$Conexion=Con_Database(GetScheme("../../Scheme.txt"));
if($Conexion->connect_errno){
    die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
}
?>

    <body>
        <header>
        <img id="PageIcon" src="\Images\WebIcon.ico" width="60" height="50">
        <nav>
            <ul id="menu">
                <li>
                    <a href="/index.php">Volver al inicio</a>
                </li>
                <?php
                    $SQL="SELECT ADMIN FROM TRABAJADORES WHERE DNI='".$_SESSION['DNI']."' AND ADMIN=1";
                    if($Conexion->query($SQL)->num_rows!=0){
                        print <<<HERE
                            <li>
                            <a href="\Aplicaciones\WorkersSpace\AdminUsers\Admin_Panel.php">Administrar usuarios</a>
                            </li>
                        HERE;
                    }
                ?>
                <li>
                    <a href='/Aplicaciones/WorkersSpace/AdminUsers/Add_Worker.php'>Añadir trabajador</a>
                </li>
                
            </ul>
        </nav>
        </header>
    </body>
</html>