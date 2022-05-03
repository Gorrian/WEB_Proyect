<head>
    <meta charset="UTF-16"/>
</head>

<?php

use function PHPSTORM_META\sql_injection_subst;

    require "../Con_Database/Conexion.php";
    require "../Con_Database/SQL_Protection.php";
    session_start();
    
    function IsChecked (int $Value){
        if($Value==1){
            return "checked";
        }
        return "";
    }
    function FormConv($Index, $Value, $ID, mysqli $Conexion, ?int $counter){
        switch ($Index){
            case ("DNI");
                $Return="<input type='Hidden' name='$Index"."[]' value='$Value' />
                        $ID";
            break;
            case "Telefono";
            case "C. electronico";
            case "Nombre completo";
                $Return="<input type='text' name='$Index"."[]' value='$Value'/>";
            break;
            case "Departamento";
                $Return="<select name='$Index"."[]'>";
                $SQL="Select Nombre from departamento";
                $Departamentos=$Conexion->query($SQL);
                for($i=0;$i<$Departamentos->num_rows;$i++){
                    $Nombre=$Departamentos->fetch_row()[0];
                    $Return.="<option value='$Nombre'";
                    if($Nombre==$Value){
                        $Return.=" selected";
                    }
                    $Return.=">$Nombre</option>";
                }
                $Return.="</option>";
                break;
            case "Localidad";
                $Return ="<select name='$Index"."[]'>";
                $SQL="SELECT provincia FROM `provincias`";
                $Departamentos=$Conexion->query($SQL);
                for($i=0;$i<$Departamentos->num_rows;$i++){
                    $Nombre=$Departamentos->fetch_row()[0];
                    $Return.="<option value='$Nombre'";
                    if($Nombre==$Value){
                        $Return.=" selected";
                    }
                    $Return.=">$Nombre</option>";
                }
                $Return.="</option>";
                break;
            case "Contrasena";
                $Return="<input type='Password' name='$Index'.'[]'/>";
            break;
            case "Change password";
            case "Disabled";
            case  "Admin";
                $Return="<input type='checkbox' name='$Index"."[$counter]' ".IsChecked(intval($Value))." onclick='return false;'/>";
            break;
            default:
                $Return="Error";
        }
        return $Return;
    }
    function IndexConv($Index){
        switch($Index){
            case "";
        }

    }


    if(isset($_SESSION['DNI'])){
        $Conexion=Con_Database(GetScheme("../Scheme.txt"));
        $SQL="SELECT Admin from Trabajadores WHERE DNI='".$_SESSION['DNI']."' AND Admin=1";
        if($Conexion->connect_errno){
            die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
        }else{
            
            if(isset($_POST['submit'])){
                print("<pre>");
                print_r($_POST);
                print("</pre>");

                $_POST=SQLProtection($_POST);
                $UpdateFormat="UPDATE FROM trabajadores";
                foreach($_POST as $Index->Value){
                    $UpdateComplete=$UpdateFormat;
                    if($Index!='submit'){
                        /*for($i=0;$i<max(array_keys($Value));$i++){
                            while(!isset($Value[$i])){
                                $i++;
                            }

                        }*/
                    }
                }

            }

            if($Conexion->query($SQL)->num_rows==1){
                $SQL="SELECT * FROM ADMIN_PANEL";
                $Trabajadores=$Conexion->query($SQL);
                $HEAD=true;
                $HTML='<table border="1">';
                $i=0;
                while($ROW=$Trabajadores->fetch_assoc()){
                    $HTML.='<tr>';
                    if($HEAD){
                        $HTML.="<tr>";
                        foreach($ROW as $Index=>$Value){
                            $HTML.="<th>$Index</th>";
                        }
                        $HTML.="</tr>";
                    }
                    foreach($ROW as $Index=>$Value){
                        
                        $HTML.="<td>".FormConv($Index, $Value,$ROW['DNI'], $Conexion, $i)."</td>";
                    }
                    $HEAD=false;
                    $HTML.='</tr>';
                    $i++;
                }
                $HTML.='</table>';
                $HTML.='<input type=submit name="submit" value="submit"/>';

                //Aqui se imprime el formulario
                print("<form action='".$_SERVER['PHP_SELF']."' method='post'>");
                print($HTML);
                print("</form>");

            }else{
                header("Location: /Index.php");
            }
        }
        
    }else{
        header("Location: /Index.php");
    }
?>
