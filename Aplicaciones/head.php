<?php
function GetFileName(string $FileLocation){
    $File="";
    for($i=0;$i<strlen($FileLocation);$i++){
        $Word=substr($FileLocation,$i,1);
        if($Word=="/"){
            $File="";
        }else{
            $File.=$Word;
        }
    }
    $Tmp="";
    $Name="";
    $Disabled=FALSE;
    for($i=0;$i<strlen($File);$i++){
        $Word=substr($File,$i,1);
        if($Word=="."){
            $Disabled=TRUE;
            $Name.=$Tmp;
            $Tmp="";
        }
        if(!$Disabled){
            $Name.=$Word;
        }else{
            $Tmp.=$Word;
        }
    }
    return $Name;
}
?>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php print(GetFileName($_SERVER['PHP_SELF']))?></title>
    <link rel="stylesheet" href="/CSS/CSS.css"/>
    <meta name="description" content="Bienvenidos a pequeños informaticos donde os podemos proporcionar auditorias, montaros vuestro sitio web o tareas de instalacion informatica"/>
    <link rel="icon" type="image/x-icon" href="/Images/Logo_proyect.ico">
