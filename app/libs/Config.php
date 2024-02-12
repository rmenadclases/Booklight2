<?php

class Config {
    //Imagen
    public static $extensionesValidas=["jpeg","jpg","png","gif"];
    public static $dirPerfil = "../web/img/imgPerfil/";
    public static $dirLibros = "../web/img/imgLibros/";
    public static $max_file_size = "2000000";
    //Base de datos
    /* public static $hostname = "10.1.2.164"; */
    /* public static $hostname = "127.0.0.1"; */
    public static $hostname = "localhost";
    /* public static $hostname = "3.84.134.170"; */
    public static $nombre = "booklight";
    /* public static $usuario = "booklight";
    public static $clave = "ArFa.starlight01"; */
    public static $usuario = "root";
    public static $clave = "";
    //MVC
    public static $vista = __DIR__ . '/../templates/inicio.php';
    public static $menu = __DIR__ . '/../templates/menuInvitado.php';
    //variables del select del contact
    public static $motives =["Feedback","Support","Report","Other"];
}
?>
