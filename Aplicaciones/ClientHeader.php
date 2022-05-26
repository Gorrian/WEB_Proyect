<?php 
include_once "head.php";
print("</head>");
?>
<body>
 <header>
 <img id="PageIcon" src="\Images\WebIcon.ico" width="60" height="50">
    <nav>
        <ul id="menu">
            <li>
              <a href="/index.php">Inicio</a>
            </li>
            <li>
              <a href="/Aplicaciones/ClientsApps/Peticion.php">Hacer una petición</a>
            </li>
            <li>
              <a href="/Aplicaciones/WorkersSpace/Login/Login.php">Espacio de trabajadores</a>
            </li>
        </ul>
    </nav>
    <div id="lorgin">
        <iframe src="\Aplicaciones\ClientsApps\Login.php" scrolling="no" ></iframe>
        
    </div>
    <p><a href='/Aplicaciones/ClientsApps/Registrarse.php' class="RegisterButton">Registrarse</a></p>
 </header>
 
</body>