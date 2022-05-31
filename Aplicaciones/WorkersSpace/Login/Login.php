<?php
    session_start();
     
    if(isset($_POST['Login']) && isset($_SESSION['DNI'])){
        header("Location:../AdminUsers/Add_Worker.php");
    }
    include_once("../../ClientHeader.php");
    require("../../Con_Database/Conexion.php");
    require("../../Con_Database/SQL_Protection.php");

    if(isset($_SESSION['DNI']) && !isset($_POST['Close'])){
        print("<p><a href='../AdminUsers/Add_Worker.php' class='SpaceBetween'>Ir al espacio de trabajadores</a></p>");
    }
   
   
    if(isset($_POST['Login'])){
        $_POST=SQLProtection($_POST);
        //$Conexion=$_SESSION['Conexion'];
        $Conexion=Con_Database(GetScheme("../..Scheme.txt"));
        if($Conexion->connect_errno){
            die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
        }else{
            $SQL="SELECT DNI, Password, Change_password from trabajadores
            WHERE DNI='".$_POST['User']."' AND `Password`=PASSWORD('".$_POST['Password']."') and Disabled!=1;";
            $Login=$Conexion->query($SQL);
            if($Login->num_rows==1){
                if($Login->fetch_assoc()['Change_password']==1){
                    $_SESSION['ChangeDNI']=$_POST['User'];
                    $_SESSION['ChangePassword']=$_POST['Password'];
                    header("Location: ChangePassword.php");
                }else{
                    $SQL="SELECT `Nombre completo` FROM trabajadores WHERE DNI='".$_POST['User']."'";
                    $_SESSION['Nombre_Usuario']=$Conexion->query($SQL)->fetch_row()[0];
                    $_SESSION['DNI']=$_POST['User'];
                }
            }else{
                print("<p class='Error'>Login incorrecto</p>");
            }
        }
    }elseif(isset($_POST['Close'])){
        unset($_SESSION['DNI']);
        unset($_SESSION['Nombre_Usuario']);
    }
 
    print('<form action="'.$_SERVER['PHP_SELF'].'" method="post">');
    if(isset($_SESSION['DNI'])){
        $NombreUsuario=$_SESSION['Nombre_Usuario'];
        print <<<HERE
        <br/><label>$NombreUsuario</label><br/>
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
<?php
include_once "../../Footer.php";
?>