<head>
    <script>
     
    </script>
</head>

<?php
require "../../Con_Database/Conexion.php";
require "../../Con_Database/SQL_Protection.php";
session_start();



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
                 $Conexion->query($SQL);
            }else{
                print("<h3 class='Error'>La contraseña establecida y la repetida no concuerdan</h3>");
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
                <input type="text" name="Telefono" required/><br/>
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
                <label>Repetir contraseña</label><br/>
                <input type="password" name="ConfirmPassword" required/><br/>
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