<?php

require_once __DIR__ . '/../app/libs/Config.php';
require_once __DIR__ . '/../app/libs/bSeguridad.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/modelo/classModelo.php';
require_once __DIR__ . '/../app/modelo/classBooklight.php';
require_once __DIR__ . '/../app/controlador/Controller.php';
require_once __DIR__ . '/../app/controlador/ControllerJS.php';

// Inicia la sesion
session_start();

// Añade nivel 0 a usuarios invitados
if (!isset($_SESSION['nivel'])) {
    $_SESSION['nivel'] = 0;
}

/**
 * Enrutamiento
 * Le añadimos el nivel mínimo que tiene que tener el usuario para ejecutar la acción
 **/
$map = array(
    'home' => array('controller' => 'Controller', 'action' => 'home', 'nivel' => 0),
    'inicio' => array('controller' => 'Controller', 'action' => 'inicio', 'nivel' => 1),
    'error' => array('controller' => 'Controller', 'action' => 'error', 'nivel' => 0),
    'registro' => array('controller' => 'Controller', 'action' => 'registro', 'nivel' => 0),
    'inicioSesion' => array('controller' => 'Controller', 'action' => 'inicioSesion', 'nivel' => 0),
    'activar_cuenta' => array('controller' => 'Controller', 'action' => 'activar_cuenta', 'nivel' => 0),
    'about'=> array('controller' => 'Controller', 'action' => 'about', 'nivel' => 0),
    'user'=> array('controller' => 'Controller', 'action' => 'user', 'nivel' => 1),
    'cierre_sesion'=> array('controller' => 'Controller', 'action' => 'cierre_sesion', 'nivel' => 1),
    'browse'=> array('controller' => 'Controller', 'action' => 'browse', 'nivel' => 1),
    'contacto' => array('controller' => 'Controller', 'action' => 'contacto', 'nivel' => 0),
    'admin' => array('controller' => 'Controller', 'action' => 'admin', 'nivel' => 2),
    'guardarCancion' => array('controller' => 'Controller', 'action' => 'guardarCancion', 'nivel' => 1),
    'editarUser' => array('controller' => 'Controller', 'action' => 'editarUser', 'nivel' => 1),
    'anyadirNoticia' => array('controller' => 'Controller', 'action' => 'anyadirNoticia', 'nivel' => 2),
    'eliminaNoticia' => array('controller' => 'Controller', 'action' => 'eliminaNoticia', 'nivel' => 2),
    'newsLetter' => array('controller' => 'Controller', 'action' => 'newsLetter', 'nivel' => 2),
    'suscribe' => array('controller' => 'Controller', 'action' => 'suscribe', 'nivel' => 0),
    'publicar' => array('controller' => 'Controller', 'action' => 'publicar', 'nivel' => 1),
    'book'=> array('controller' => 'Controller', 'action' => 'book', 'nivel' => 0),
    'anyadirComentario'=> array('controller' => 'Controller', 'action' => 'anyadirComentario', 'nivel' => 1),
    'responder' => array('controller' => 'Controller', 'action' => 'responder', 'nivel' => 1),
    'reportar' => array('controller' => 'Controller', 'action' => 'reportar', 'nivel' => 1),
    'seguir' => array('controller' => 'Controller', 'action' => 'seguir', 'nivel' => 1),
    'dejarDeSeguir' => array('controller' => 'Controller', 'action' => 'dejarDeSeguir', 'nivel' => 1),
    'buscarUsuarios' => array('controller' => 'Controller', 'action' => 'buscarUsuarios', 'nivel' => 1),
    'buscarLibrosBrowse' => array('controller' => 'Controller', 'action' => 'buscarLibrosBrowse', 'nivel' => 1),
    'buscarLibro' => array('controller' => 'Controller', 'action' => 'buscarLibro', 'nivel' => 2),
    'anyadirLibro' => array('controller' => 'Controller', 'action' => 'anyadirLibro', 'nivel' => 2),
    'eliminaLibro' => array('controller' => 'Controller', 'action' => 'eliminaLibro', 'nivel' => 2),
    'banear' => array('controller' => 'Controller', 'action' => 'banear', 'nivel' => 2),
    'aceptarPost' => array('controller' => 'Controller', 'action' => 'aceptarPost', 'nivel' => 2),
    'borrarPost' => array('controller' => 'Controller', 'action' => 'borrarPost', 'nivel' => 2),
    'buscarUsuarioAdmin' => array('controller' => 'Controller', 'action' => 'buscarUsuarioAdmin', 'nivel' => 2),
    'librosPopulares' => array('controller' => 'Controller', 'action' => 'librosPopulares', 'nivel' => 2),
    'recuperar' => array('controller' => 'Controller', 'action' => 'recuperar', 'nivel' => 0),
    'cambiar_password' => array('controller' => 'Controller', 'action' => 'cambiar_password', 'nivel' => 0),
    'anyadirFavorito' => array('controller' => 'Controller', 'action' => 'anyadirFavorito', 'nivel' => 1),
    'eliminarFavorito' => array('controller' => 'Controller', 'action' => 'eliminarFavorito', 'nivel' => 1),

    //CONTROLLER JS ACTIONS
    'existeUsuario' => array('controller' => 'ControllerJS', 'action' => 'existeUsuario', 'nivel' => 0),
    'existeEmail' => array('controller' => 'ControllerJS', 'action' => 'existeEmail', 'nivel' => 0)
);

// Parseo de la ruta
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        $ruta = $_GET['ctl'];
    } else {
        //Si el valor puesto en ctl en la URL no existe en el array de mapeo se envía a la ruta error
        $ruta='error';
        exit;
    }
} else {
    $ruta = 'home';
}
$controlador = $map[$ruta];

/*
Comprobamos si el metodo correspondiente a la acción relacionada con el valor de ctl existe
*/
if (method_exists($controlador['controller'], $controlador['action'])) {
    if ($controlador['nivel'] <= $_SESSION['nivel']) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    }else{
        call_user_func(array(
            new $controlador['controller'],
            'home'
        ));
    }
} else {
    call_user_func(array(
        new $controlador['controller'],
        'error'
    ));
}

