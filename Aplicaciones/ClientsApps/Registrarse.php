<?php
    include "../Con_Database/Conexion.php";
    include "../Con_Database/SQL_Protection.php";
    session_start();
    $Conexion=Con_Database(GetScheme("../Scheme.txt"));

    //Code of errors depending if the user answered wrong on something.
    $ERROR=[
        0=>"El CIF tiene que empezar con una letra",
        1=>"No puedes poner una letra en el codigo de numeros del CIF",
        2=>"No puedes poner un numero al final del NIF",
        3=>"No puedes poner una letra en el codigo de numeros del NIF",
        4=>"Las dos contraseñas deben concordar",
        5=>"Debe aceptar las condiciones de uso"
    ];

    //This function will check everything has been inserted correctly on the form
    function CheckForm(array $FORM){
        if(!is_numeric(substr($FORM['ID'],0,1))){
            for($i=0;$i<9;$i++){
                if($i==0){
                    if(is_numeric(substr($FORM['ID'],$i,1))){
                        return 0;
                    }
                }else{
                    if(!is_numeric(substr($FORM['ID'],$i,1))){
                        return 1;
                    }
                }
            }
        }else{
            for($i=0;$i<9;$i++){
                if($i==8){
                    if(is_numeric(substr($FORM['ID'],$i,1))){
                        return 2;
                    }
                }else{
                    if(!is_numeric(substr($FORM['ID'],$i,1))){
                        return 3;
                    }
                }
            }
        }
        if($FORM['password']!=$FORM['REPPassword']){
            return 4;
        }
        if(!isset($FORM['Law'])){
            return 5;
        }
        return true;
    }
   
   
    if(isset($_POST['submit'])){
        $Code=CheckForm($_POST);
        if(is_bool($Code)){
            $_POST=SQLProtection($_POST);
            $SQL="INSERT INTO clientes (`NIF/CIF`,`Nombre`,`Password`)
            VALUES ('".$_POST['ID']."', '".$_POST['Nombre']."',PASSWORD('".$_POST['password']."'))";
            $Conexion->query($SQL);
            if($Conexion->errno==1062){
                print("<p class='Error'>Usuario con NIF/CIF ".$_POST['ID']." ya existe</p>");
            }else{
                $SQL="SELECT * FROM clientes WHERE `NIF/CIF`='".$_POST['ID']."'";
                print("<p></p>");
                if($Conexion->query($SQL)->num_rows==1){
                    $_SESSION['Client']=$_POST['ID'];
                }
                
            }
        }
    }
    if(isset($_SESSION['Client'])){
        header("Location: /Index.php");
    }
    print("<form action='".$_SERVER['PHP_SELF']."' method='post'>");
    print("<label>NIF/CIF</label><br/>");
    if(isset($Code)){
        if(($Code>=0 || $Code<=3) && is_int($Code)){
            print("<p class='Error'>".$ERROR[$Code]."</p>");
        }

    }
    print("<input type='text' name='ID' size='9'/><br/>");
    print("<label>Nombre</label><br/>");
    print("<input type='text' name='Nombre'/><br/>");
    print("<label>Contraseña</label><br/>");
    if(isset($Code)){
        if($Code==4 && is_int($Code)){
            print("<p class='Error'>".$ERROR[$Code]."</p>");
        }
    }
    print("<input type='password' name='password'/><br/>");
    print("<label>Repetir contraseña</label><br/>");
    if(isset($Code)){
        if($Code==4 && is_int($Code)){
            print("<p class='Error'>".$ERROR[$Code]."</p>");
        }
    }
    print("<input type='password' name='REPPassword'/><br/>");
    if(isset($Code)){
        if($Code==5 && is_int($Code)){
            print("<p class='Error'>".$ERROR[$Code]."</p>");
        }
    }
    print("<input type='checkbox' name='Law'/>");
    print("<label>Aceptas las condiciones de uso de esta pagina</label><br/>");
    print("<input type='submit' name='submit'/>");
    print("</form>");
?>