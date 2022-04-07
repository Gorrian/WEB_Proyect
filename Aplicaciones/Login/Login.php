<?php
    require("../Con_Database/Conexion.php");
    require("../Con_Database/SQL_Protection.php");

    session_start();


    if(isset($_POST['Login'])){
        $_POST=SQLProtection($_POST);
        $Conexion=Con_Database("db_proyect");
        if($Conection->connect_errno){
            die("Error de Conexion (".$Conection->connect_errno.") ". $Conection->connect_error);
        }else{
            $SQL="SELECT DNI, Password, Change_password, from trabajadores
            WHERE DNI='".$_POST['User']."' AND Password=PASSWORD('".$_POST['Password']."');";
            $Login=$Conexion->query($SQL);
            if($Login->num_rows==1){

            }else{

            }
        }
    }



    print('<form>');
    if(isset($_SESSION['ID_USUARIO'])){
        $NombreUsuario=$_SESSION['Nombre_Usuario'];
        print <<<HERE
        <label>$NombreUsuario</label><br/>
        <input type="submit" name="Close" value="Cerrar session"/>
        HERE;
    }else{
        print <<<HERE
            <label>*DNI Trabajador:</label><br/>
            <input type="text" name="User" required/><br/>
            <label>*Contraseña:</label><br/>
            <input type="password" name="Password" required/><br/>
            <input type="submit" name="Login" value="Iniciar session"/>
            <input type="reset" name="Reset" value="Eliminar"/>
        HERE;
    }
    print('</form>');
?>