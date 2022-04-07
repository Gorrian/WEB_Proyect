<?php
session_start();
if(isset($_SESSION['ChangePassword'])){
    $ID_Trabajador=$_SESSION['ChangeDNI'];
    print <<<HERE
    <form>
        <h2>Debe cambiar su contraseña</h2>
        <label>DNI Trabajador: </label><br/>
        <input type="text" name="User" value="$ID_Trabajador" readonly/><br/>
        <label>Contraseña: </label><br/>
        <input type="password" name="Password" required/><br/>
        <input type="submit" name="Cambiar" value="Cambiar contraseña"/>
    </form>
    HERE;
    session_unset();
}else{
    header("Location: Login.php");
}
?>