<?php
include_once "Aplicaciones/ClientHeader.php";
?>
<script><?php
$ERRORCODE=[
    0=>"Acceso denegado",
    1=>"Acceso denegado, requiere que inicie sesion"
];
if(isset($_GET['ERROR']) && isset($ERRORCODE[$_GET['ERROR']])){
    print("alert(\"".$ERRORCODE[$_GET['ERROR']]."\");");
}
?></script>

<section>
    <table>
        <tr class="IndexRow">
            <td class="tdImg"><img src="/Images/Mentenimiento.jpg" class="RightImg"/></td>
            <td><p>Ofrecemos servicios de mantenimiento en el que podemos ofreceros asistencia
                en el montaje de ordenadores, instalacion del cableado y preparacion de los servidores del local.
                Para que su local este preparado para asistir o ofrecer los servicios que usted desee implementar.
            </p></td>
        </tr>
        <tr class="IndexRow">
            <td>Nuestro experto en cyberseguridad podra ofrecerle una valoracion sobre como de decente 
                son vuestros sistemas de seguridad en vuestro local para que este a regla con los estandares de seguridad
                que le dicten la ley y recomendaros implementaciones y politicas para evitar o proteger contra amenazas informaticas.
            </td>
            <td class="tdImg"><img src="/Images/CyberSecurity.jpg" class="LeftImg"/></td>
        </tr>
        <tr class="IndexRow">
            <td class="tdImg"><img src="/Images/WebDevelopment.jpg" class="RightImg"/></td>
            <td><p>Nuestro programador le ayudara a implementar un sitio web hosteado o local en su red
                con las funcionalidades que usted desee implementar en su empresa. Tambien le implementaremos la base de datos
                si el sitio web lo requiriese y acepta la implementacion de una, con los sistemas de seguridad pertinentes.
            </p></td>
        </tr>
    </table>
</section>
<?php
include_once "Aplicaciones/Footer.php";
?>