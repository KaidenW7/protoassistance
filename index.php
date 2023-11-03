<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Es e-Assistance, una solución eficiente y moderna para la gestión de asistencia de tu institución educativa. Nuestra plataforma web te brinda una planilla de asistencia fácil de usar que simplifica el seguimiento y registro de la asistencia de tus estudiantes.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Assistance</title>
    <!--...Favicon Image...-->
    <link rel="shortcut icon" href="Archivos_Media/img_web1.png" type="imagen/png">
    <!--...CSS Archive Link...-->
    <link href="Styles/style1.css" rel="stylesheet" type="text/css">
    <!--...Google Fonts...-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Rubik&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@200&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <!--...CDN CLoudflare FontAwesome...-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer" 
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css"
        integrity="sha512-9YHSK59/rjvhtDcY/b+4rdnl0V4LPDWdkKceBl8ZLF5TB6745ml1AfluEU6dFWqwDw9lPvnauxFgpKvJqp7jiQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!--...sweetalert...-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="first">
        <div class="imagen">
            <img id="backphoto" src="Archivos_Media/versión 3.jpg">
        </div>
        <div class="second">
            <section class="containerMenu">
                <h1>e-Assistance</h1>
                <h4>PLANILLA DE ASISTENCIA WEB</h4>

                    <form id="log_in" method="POST" action="controlador/login.php">   
                        <input type="text" placeholder="USUARIO" maxlength="30" id="username" name="email">
                        <input type="password" placeholder="CONTRASEÑA" maxlength="20" id="password" name="password">
                        <input type="submit" id="log-in_button" name="btniniciar" value="INICIAR SESIÓN">
                        <h6 id=pw_link><a href="#" class="links">¿Olvidó su contraseña?</a></h6>
                        <h6 id=pw_link><a href="vista/registro.php" class="links">Registrarse</a></h6>
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