<?php
require("../..Con_Database/Conexion.php");
require("../..Con_Database/SQL_Protection.php");

session_start();



if(isset($_SESSION['ChangePassword'])){
    $ERROR=[
        1=>"La nueva contraseña no puede ser similar a la vieja",
        2=>"Tiene que volver a poner su nueva contraseña exactamente igual
            en el cuadro de Confirmar contraseña",
        //No viene mal prevenir incluso si es imposible reproducir este error
        3=>"No ha introducido una contraseña"
    ];
    if(isset($_GET['ERROR'])){
        print("<h4 class=ERROR>".$ERROR[$_GET['ERROR']]."</h4>");
    }
    $ID_Trabajador=$_SESSION['ChangeDNI'];
    print <<<HERE
    <form action="ConfirmarCambio.php" method="post">
        <h3>Debe cambiar su contraseña</h3>
        <label>DNI Trabajador: </label><br/>
        <input type="text" name="User" value="$ID_Trabajador" readonly/><br/>
        <label>*Nueva contraseña: </label><br/>
        <input type="password" name="Password" required/><br/>
        <label>*Confirmar contraseña</label><br/>
        <input type="password" name="Confirmar" required/><br/>
        <input type="submit" name="Cambiar" value="Cambiar contraseña"/>
        <input type="reset" name="reset"/>
    </form>
    HERE;
}else{
    header("Location: Login.php");
}
?>