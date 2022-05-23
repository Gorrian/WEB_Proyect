<?php
include "../Con_Database/Conexion.php";
include "../Con_Database/SQL_Protection.php";
session_start();
$Conexion=Con_Database(GetScheme("../Scheme.txt"));

print("<form>");
print("<label>Localizacion de su centro</label>");
print("<input type='text' name='Location'/>");
print("<label>Tipo de servicio</label>");
print("<select name='TipoServicio'>");
$SQL="SELECT * FROM `t.servicio`";
$TipoServicios=$Conexion->query($SQL);
while($ROW=$TipoServicios->fetch_assoc()){
    print("<option value='".$ROW['ID']."'>".$ROW['Nom.servicio']."<option>");
}
print("</select>");
print("</form>");
?>