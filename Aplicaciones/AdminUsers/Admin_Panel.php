<head>
    <meta charset="UTF-16"/>
    <script>
        function ischecked(ID){
            var Input = document.getElementById(ID+'Return').getAttribute('Value');
            var Image = document.getElementById(ID+'Image');
            if(Input==0){
                Image.setAttribute('hidden',null);
            }else{
                Image.removeAttribute('hidden');
            }
        }
    </script>
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
                $SQL="Select Nombre, ID_departamento from departamento";
                $Departamentos=$Conexion->query($SQL);
                for($i=0;$i<$Departamentos->num_rows;$i++){
                    $Nombre=$Departamentos->fetch_row();
                    
                    $Return.="<option value='".$Nombre[1]."'";
                    if($Nombre[0]==$Value){
                        $Return.=" selected";
                    }
                    $Return.=">".$Nombre[0]."</option>";
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
                $Return="<div id='Checkbox'>
                <input type='hidden' id='".$counter.$Index."Return' value='$Value'/>
                <img id='".$counter.$Index."Image' src='../Images/CheckedImage' onload='ischecked(\"".$counter.$Index."\")'/>
                </div>";
                //$Return="<input type='checkbox' name='$Index"."[$counter]' value='1' ".IsChecked(intval($Value))."/>";
            break;
            default:
                $Return="Error";
        }
        return $Return;
    }
    function IndexConv($Index){
        switch($Index){
            case "Departamento";
                $Return="ID departamento";
            break;
            case "Nombre_completo";
                $Return="Nombre completo";
            break;
            case "C__electronico";
                $Return="C. electronico";
            break;
            default;
                $Return=$Index;
        }
        return $Return;

    }


    if(isset($_SESSION['DNI'])){
        $Conexion=Con_Database(GetScheme("../Scheme.txt"));
        
        if($Conexion->connect_errno){
            die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
        }else{        
            $SQL="SELECT Admin from Trabajadores WHERE DNI='".$_SESSION['DNI']."' AND Admin=1";
            if($Conexion->query($SQL)->num_rows==1){
                if(isset($_POST['submit'])){
                    $_POST=SQLProtection($_POST);
                    foreach($_POST as $Index=>$Value){
                        $Ahead[]=$Value;
                    }
                    for($i=0;$i<count($_POST['DNI']);$i++){
                        $UpdateFormat="UPDATE trabajadores SET";
                        $i2=1;
                       foreach($_POST as $Index=>$Value){
                            if(isset($Value[$i]) && $Index!="submit"){
                                $UpdateFormat.=" `".IndexConv($Index)."`= '".$Value[$i]."'";
                            }
                            if($Index=="submit"){
                                $UpdateFormat.=" WHERE DNI='".$_POST['DNI'][$i]."'";
                            }else if(is_array($Ahead[$i2]) && isset($Ahead[$i2][$i])){
                                $UpdateFormat.=",";
                            }
                            $i2++;
                       }
                       $Conexion->query($UpdateFormat);
                        
                    }
    
                }
                if(isset($_GET['Filtrar'])){
                    $_GET=SQLProtection($_GET);
                    $WhereSQL="WHERE `".$_GET['TipoFiltro']."` LIKE '%".$_GET['Filtro']."%'";
                    print($WhereSQL);
                }else{
                    $WhereSQL="";
                }
                

                $SQL="SELECT * FROM ADMIN_PANEL $WhereSQL";
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

                $Filtro=("<form action='".$_SERVER['PHP_SELF']."' method='get'>");
                    $Filtro.="<select name='TipoFiltro'>";
                    $SQL = "SELECT * FROM ADMIN_PANEL LIMIT 1";
                    $Header=$Conexion->query($SQL)->fetch_assoc();
                    foreach ($Header as $Head=>$Value){
                        $Filtro.="<option value='$Head'";
                        if(isset($_GET['TipoFiltro'])){
                            if($Head==$_GET['TipoFiltro']){
                                $Filtro.="selected";
                            }
                        }
                        $Filtro.=">$Head</option>";
                    }
                    $Filtro.="</select>";
                    $Filtro.="<input type='text' name='Filtro' placeholder='Filtro'";
                    if(isset($_GET['Filtro'])){
                        $Filtro.=" value='".$_GET['Filtro']."'";
                    }
                    $Filtro.="/>";
                    $Filtro.="<input type='submit' name='Filtrar'/>";
                $Filtro.=("</form>");

                //Aqui el del filtro
                print($Filtro);
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
