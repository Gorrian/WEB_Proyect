<?php
    include "../Con_Database/Conexion.php";
    include "../Con_Database/SQL_Protection.php";
    session_start();

    function CheckForm(array $FORM){
        if(is_numeric(substr($FORM['NIF/CIF'],0,1))){
            for($i=0;$i<9;$i++){
                if($i==0){
                    if(is_numeric(substr($FORM['NIF/CIF'],$i,1))){
                        return false;
                    }
                }else{
                    if(!is_numeric(substr($FORM['NIF/CIF'],$i,1))){
                        return false;
                    }
                }
            }
        }else{
            for($i=0;$i<9;$i++){
                if($i==9){
                    if()
                }
            }
        }
    }

    if(isset($_SESSION['Client'])){
        header("Location: /Index.php");
    }
    if(isset($_POST['submit'])){
        
    }
    print("<form action='".$_SERVER['PHP_SELF']."' method='post'>");
    print("<label>NIF/CIF</label><br/>");
    print("<input type='text' name='ID' size='9'/><br/>");
    print("<label>Nombre</label><br/>");
    print("<input type='text' name='Nombre'/><br/>");
    print("<label>Password</label><br/>");
    print("<input type='password' name='password'/><br/>");
    print("<input type='checkbox' name='Law'/>");
    print("<label>Aceptas las condiciones de uso de esta pagina</label><br/>");
    print("<input type='submit' name='submit'/>");
    print("</form>");
?>