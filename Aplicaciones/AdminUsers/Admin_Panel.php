<?php
    require "../Con_Database/Conexion.php";
    session_start();
    
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
                $HTML=<<<HERE
                <table border="1">
                HERE;
                while($ROW=$Trabajadores->fetch_assoc()){
                    $HTML+=<<<HERE
                        <tr>
                    HERE;
                    foreach($ROW as $Index->$Value){
                        if($HEAD){
                            $HTML+=<<<HERE
                                <th>$Index</th>
                            HERE;
                        }
                        $HTML+=<<<HERE
                            <td>$Value</td>
                        HERE;
                    }
                    $HEAD=false;
                    $HTML+=<<<HERE
                        </tr>
                    HERE;
                }
            }else{
                header("Location: /Index.php");
            }
        }
        
    }else{
        header("Location: /Index.php");
    }
?>
