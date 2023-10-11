<!DOCTYPE html>

<?php
session_start(); 
require "modelo/head.php"; ?>

<body>
    <div class="first">
        <div class="imagen">
            <img id="backphoto" src="Archivos_Media/versión 3.jpg">
        </div>
        <div class="second">
            <section class="containerMenu">
                <h1>e-Assistance</h1>
                <h4>PLANILLA DE ASISTENCIA WEB</h4>
                    <?php 
                        include "modelo/conexion.php";
                        //include "controlador/login.php";
                    ?>  
                    <form id="log_in" method="POST" action="controlador/login.php">   
                        <input type="text" placeholder="USUARIO" maxlength="30" id="username" name="email">
                        <input type="password" placeholder="CONTRASEÑA" maxlength="20" id="password" name="password">
                        <input type="submit" id="log-in_button" name="btniniciar" value="INICIAR SESIÓN">
                        <h6 id=pw_link><a href="#" class="links">¿Olvidó su contraseña?</a></h6>
                        <h6 id=pw_link><a href="registro.php" class="links">Registrarse</a></h6>
                    </form>
                <div id="box_row">
                    <div id="box_aligned">
                        <div id="fb"><i class="fa-brands fa-facebook-f"></i></div>
                        <div id="ig"><i class="fa-brands fa-instagram"></i></div>
                        <div id="wpp"><i class="fa-brands fa-whatsapp"></i></div>
                    </div>
                    <div id="division_line"></div>
                    <div id="box_aligned2"><h5 id="SM_name"><sup id="service_mark">SM</sup>e-Assistance 2023</h5></div>
                </div>
            </section>    
        </div>
    </div>
</body>
</html>