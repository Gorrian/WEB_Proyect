<?php
session_start();
if(isset($_SESSION['Client'])){
    header("Location: /index.php?ERROR=1");
}

@include_once "../ClientHeader.php";

?>