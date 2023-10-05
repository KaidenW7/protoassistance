<?php
if (!empty($_POST["btniniciar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
       $usuario=$_POST["usuario"];
       $password=md5($_POST["password"]);
       $sql=$connexion->query("select * from usuario where n_usuario='$usuario' and clave='$password'");
       
       if ($sql->fetch_object()){
        header("location: inicio.php");
       }else{
        echo "El usuario no existe.";
       }

    }else {
        echo "Los campos están vacíos.";
    }
}
?>