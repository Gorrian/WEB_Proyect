<head>
    <script>
     
    </script>
</head>

<?php
require "../../Con_Database/Conexion.php";
require "../../Con_Database/SQL_Protection.php";
session_start();

$Pattern=False;
$The3Booleans=array("Change_password","Disabled","Admin");
$The3Labels=array("Cambiar contraseña tras primer inicio de sesion en la web", "La cuenta estara desactivada del sitio web", "El usuario sera administrador");

if(isset($_SESSION['DNI'])){
    $Conexion=Con_Database(GetScheme("../../Scheme.txt"));
    if($Conexion->connect_errno){
        die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
    }else{
        if(isset($_POST['submit'])){
            $_POST=SQLProtection($_POST);
            if($_POST['FirstPassword']==$_POST['ConfirmPassword']){
                $SQL="INSERT INTO TRABAJADORES (DNI, `Nombre completo`, `ID departamento`, `Telefono`, `C. electronico`, Localidad, `Password`)
                 VALUES ('".$_POST['DNI']."','".$_POST['NombreCompleto']."', '".$_POST['Departamento']."','".$_POST['Telefono']."','".$_POST['CorreoElectronico']."', '".$_POST['Localidad']."', PASSWORD('".$_POST['FirstPassword']."'))";
                 $Ejecutado=$Conexion->query($SQL);
                 if($Ejecutado){
                     print("<p class='Confirmacion'><b>Se ha guardado el trabajador en la base de datos</b></p>");
                 }
                 
            }else{
                $Pattern=TRUE;
            }
        }
        $SQL="SELECT * FROM `trabajadores` WHERE DNI='".$_SESSION['DNI']."' AND (`ID departamento`=1 or `ID departamento`=3 or Admin=1)";
        if($Conexion->query($SQL)->num_rows==1){
            print_r("");
            print("<form method='post' action='".$_SERVER['PHP_SELF']."'>");
            print<<<HERE
                <label>DNI Trabajador</label><br/>
                <input type="text" name="DNI" pattern="[0-9]{8}[A-Za-z]{1}" required/><br/>
                <label>Nombre Completo</label><br/>
                <input type="text" name="NombreCompleto" required/><br/>
                <label>Departamento</label><br/>
                <select name="Departamento">        
            HERE;
            $SQL="SELECT * FROM `departamento`";
            $Departamentos=$Conexion->query($SQL);
            while($ROW=$Departamentos->fetch_row()){
                print("<option value='".$ROW[0]."'>".$ROW[1]."</option>");
            }
            print<<<HERE
                </select><br/>
                <label>Telefono</label><br/>
                <input type="text" name="Telefono" pattern="\+[0-9]{1,3}[0-9]{9}" required/><br/>
                <label>Correo electronico</label><br/>
                <input type="text" name="CorreoElectronico" required/><br/>
                <label>Localidad</label><br/>
                <select name="Localidad">
            HERE;
            $SQL="SELECT provincia FROM `provincias`;";
            $Provincias=$Conexion->query($SQL);
            while($ROW=$Provincias->fetch_row()[0]){
                print("<option value='$ROW'>$ROW</option>");
            }
            print<<<HERE
                <select/><br/>
                <label>Contraseña</label><br/>
                <input type="password" name="FirstPassword" required/><br/>
            HERE;
            if($Pattern){
                print("<p class='Error'>La contraseña no concuerda con la repetida</p>");
            }
            print<<<HERE
                <label>Repetir contraseña</label><br/>
                <input type="password" name="ConfirmPassword" required/><br/>
            HERE;
            if($Pattern){
                print("<p class='Error'>La contraseña no concuerda con la repetida</p>");
            }
            $SQL="SELECT * FROM `trabajadores` WHERE DNI='".$_SESSION['DNI']."' AND Admin=1";
            if($Conexion->query($SQL)->num_rows==1){
                try{
                    foreach($The3Booleans as $Index=>$Value){
                        $SQL='select column_default
                        from information_schema.columns
                        where  column_default is not null
                              and TABLE_NAME="trabajadores" and COLUMN_NAME="'.$Value.'"';
                        $TheLabel=$The3Labels[$Index];
                        print<<<HERE
                        <input type="checkbox" name="$Value" value="1" 
                        HERE;
                        if($Conexion->query($SQL)->fetch_row()[0]==1){
                            print("checked");
                        }
                        print("/>");
                        print<<<HERE
                        <label>$TheLabel</label><br/>
                        HERE;
                    }
                }catch(Exception $e){
                    print<<<HERE
                        <input type="checkbox" name="Change_password" value="1" checked/>
                        <label>Cambiar contraseña tras primer inicio de sesion en la web</label><br/>
                        <input type="checkbox" name="Disabled" value="1" checked/>
                        <label>La cuenta estara desactivada del sitio web</label><br/>
                        <input type="checkbox" name="Admin" value="1" checked/>
                        <label>El usuario sera administrador</label><br/>
                    HERE;
                }
            }
            print<<<HERE
                <input type="submit" name="submit" value="Enviar"/>
                <input type="reset"/>
            HERE;
            print("</form>");
        }else{
            header("Location: /Index.php");
        }
    }
}else{
    header("Location: /Index.php");
}
?>