<head>
    <meta charset="UTF-16"/>
</head>

<?php
    require "../Con_Database/Conexion.php";
    session_start();
    
    function IsChecked (int $Value){
        if($Value==1){
            return "checked";
        }
        return "";
    }
    function FormConv($Index, $Value, $ID){
        switch ($Index){
            case "DNI":
            case "Contrasena":
                $Return="<input type='Submit' name='$Index' value='$Value'/>
                        <input type='Hidden' name='ID' value='$ID'/>";
            case  "Change_password" || "Disabled" || "Admin":
                $Return="<input type='checkbox' name='$Index' ".IsChecked($Value)."/>";
        }
    }


    if(isset($_SESSION['DNI'])){
        $Conexion=Con_Database(GetScheme("../Scheme.txt"));
        $SQL="SELECT Admin from Trabajadores WHERE DNI='".$_SESSION['DNI']."' AND Admin=1";
        if($Conexion->connect_errno){
            die("Error de Conexion (".$Conexion->connect_errno.") ". $Conexion->connect_error);
        }else{
            if($Conexion->query($SQL)->num_rows==1){
                $SQL="SELECT * FROM ADMIN_PANEL";
                $Trabajadores=$Conexion->query($SQL);
                $HEAD=true;
                $HTML='<table border="1">';
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
                        
                        
                        $HTML.="<td>$Value</td>";
                    }
                    $HEAD=false;
                    $HTML.='</tr>';
                }
                $HTML.='</table>';
                print($HTML);
            }else{
                header("Location: /Index.php");
            }
        }
        
    }else{
        header("Location: /Index.php");
    }
?>
