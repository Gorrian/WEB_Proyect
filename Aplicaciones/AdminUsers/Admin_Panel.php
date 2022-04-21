<?php
    session_start();
    
    if(isset($_SESSION['DNI'])){
        
    }else{
        header("Location: /Index.php");
    }
?>
