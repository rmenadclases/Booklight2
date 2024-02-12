<?php

class Controller
{

    /**
     * funcion cargaMenu
     *
     * Carga el menú correspondiente
     */
    private function cargaMenu()
    {
         if ($_SESSION['nivel'] == 0) {
            return 'layout.php';
        } else if ($_SESSION['nivel'] == 1) {
            return 'layoutUser.php';
        } else if ($_SESSION['nivel'] == 2) {
            return 'layoutUser.php';
        }
    }

    /**
     * funcion home
     *
     * Ruta home para usuarios invitados
     */
    public function home()
    {
        $menu = 'layout.php';
        try {
            $m = new Booklight();
            $params=array(
                'libros'=>$m->listLibrosPopulares(6),
                'comentariosInvitado' => $m-> recogeComentariosInvitado()
            );

            $params['noticias']=$m->listarNoticias();
            if ($_SESSION['nivel'] > 0) {
                header("location:index.php?ctl=inicio");
            }
            if(!$params['libros'])
                    $params['mensaje404']='error loading books';
            if(!$params['comentariosInvitado'])
                    $params['coments404']='Not comments yet';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuInvitado.php';
    }

    /**
     * funcion inicio
     *
     * Ruta inicio para usuarios con sesión iniciada
     */
    public function inicio()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> '',
                'publicaciones' =>'',
                'respuestas' => array(),
                'siguiendo' => array()
            );
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            //Publicaciones
            $params['publicaciones'] = $m->verPublicaciones($params['user'][0]['id_user']);
            if(!$params['publicaciones']){
                $params['publicaciones404'] = 'Nothing to be shown';
            }else //Respuestas
                foreach ($params['publicaciones'] as $key => $value) {
                    $params['respuestas'][$value['id_post']] = $m->verRespuestas($value['id_post'],$params['user'][0]['id_user']);
                }
            //Siguiendo
            $params['siguiendo'] = $m->verSiguiendo($params['user'][0]['id_user']);
            if(!$params['siguiendo'])
                $params['siguiendo404'] = 'Nothing to be shown';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/dashboard.php';
    }

    /**
     * funcion publicar
     *
     * Ruta publicar para añadir publicaciones al perfil del user
     */
    public function publicar()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'publicacion' => ''
            );
            $errores = array();
            if (isset($_REQUEST['btnSave'])) {
                $publicacion = recoge('publicacion');
                cTextarea($publicacion,'publicacion',$errores, 150, 1);
                if (empty($errores)) {
                        $params = array(
                            'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                            'publicacion' => $publicacion
                        );
                        if ($m->insertarPublicacion($params['user']['0']['id_user'], $publicacion)) {
                            header('Location: index.php?ctl=inicio');
                        } else {
                            $params['mensaje'] = 'Couldn\'t insert publication.';
                        }

                } else {
                    $params = array(
                        'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                        'publicacion' => $publicacion
                    );
                    $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/dashboard.php';
    }

    /**
     * funcion responder
     *
     * Ruta responder para añadir respuestas a las publicaciones o comentarios
     */
    public function responder()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'id_post' => '',
                'respuesta' => ''
            );
            $errores = array();
            if (isset($_REQUEST['bReply'])) {
                $id_post = recoge('post');
                $respuesta = recoge('respuesta');
                cTextarea($respuesta,'respuesta',$errores, 150, 1);
                if (empty($errores)) {
                        $params = array(
                            'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                            'id_post' => $id_post,
                            'respuesta' => $respuesta
                        );
                        if ($m->insertarRespuesta($id_post, $params['user']['0']['id_user'], $respuesta)) {
                            header('Location: index.php?ctl=inicio');
                        } else {
                            $params['mensaje'] = 'Couldn\'t insert reply.';
                        }
                } else {
                    $params = array(
                        'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                        'respuesta' => $respuesta
                    );
                    $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/dashboard.php';
    }

    /**
     * funcion reportar
     *
     * Ruta reportar para reportar publicaciones, respuestas o comentarios
     */
    public function reportar()
    {
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'id_user' => recoge('user'),
                'id_post' => recoge('post'),
                'id_respuesta' => recoge('respuesta'),
                'id_comentario' => recoge('comentario'),
                'isbn'=>$_GET['isbn'],
            );
            if (!empty($params['id_post']))
                if($m->reportarPublicacion($params['id_post'],$params['id_user'])) {
                    header('Location: index.php?ctl=inicio');
                } else
                    $params['mensaje'] = 'Couldn\'t report post.';
            if (!empty($params['id_respuesta']))
                if ($m->reportarRespuesta($params['id_respuesta'],$params['id_user'])) {
                    header('Location: index.php?ctl=inicio');
                } else
                    $params['mensaje'] = 'Couldn\'t report reply.';
            if (!empty($params['id_comentario']))
                if ($m->reportarComentario($params['id_comentario'],$params['id_user'])) {
                    header('Location: index.php?ctl=book&isbn='.$params['isbn']);
                } else
                    $params['mensaje'] = 'Couldn\'t report comment.';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/dashboard.php';
    }

    /**
     * funcion error
     *
     * Ruta error
     */
    public function error()
    {
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> ''
            );
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/error.php';
    }

    /**
     * funcion about
     *
     * Ruta about
     */
    public function about()
    {
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'user' => isset($_SESSION['userEmail']) ? $m->verUsuario('','',$_SESSION['userEmail']): ''
            );
            //Favorito
            if(!empty($params['user']))
                $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/about.php';
    }

    /**
     * funcion book
     *
     * Ruta book
     */
    public function book()
    {
        $menu = $this->cargaMenu();
        //Mostrar informacion del libro:

        try {
            $m = new Booklight();
            $isbn=$_GET['isbn'];
            $params=array(
                'user' => isset($_SESSION['userEmail']) ? $m->verUsuario('','',$_SESSION['userEmail']): '',
                'libro'=>$m->verLibro($isbn),
                'libro_favorito' => array()
            );
            //Favorito
            if(!empty($params['user'])){
                $params['libro_favorito'] = $m->verFavorito($params['user'][0]['id_user'], $isbn);
                $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            }
            if(!$params['libro_favorito']){
                $params['favorito404'] = 'Nothing to be shown';
            }

        //Recojo valores del libro con el mismo isbn de la API
            $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $isbn;
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (isset($data["items"]) && !empty($data["items"])) {
                $book_info = $data["items"][0]["volumeInfo"];
                $params['libro'][0]['sinopsis'] = $book_info["description"] ?? "N/A";
            }
            //Aside : Mostrar libros relacionados por:
            //Recogo libros con el mismo autor de la API
            $url = "https://www.googleapis.com/books/v1/volumes?q=authors:".urlencode($params['libro'][0]['autor']) ;
            $responseAutor = file_get_contents($url);
            $dataAutores = json_decode($responseAutor, true);
            if (isset($dataAutores["items"]) && !empty($dataAutores["items"])) {
                $done=false;
                $i=0;
                do {
                    if(isset($dataAutores["items"][$i]["volumeInfo"]["imageLinks"]['thumbnail'])){
                        $autores_info[]= $dataAutores["items"][$i]["volumeInfo"];
                        if (count($autores_info)==3)
                            $done=true;
                        }
                    $i++;
                } while (!$done);
            }
            //Recojo libros del musmo genero de la API
            $url = "https://www.googleapis.com/books/v1/volumes?q=categories:".urlencode($book_info["categories"][0]);
            $responseGenero = file_get_contents($url);
            $dataGenero = json_decode($responseGenero, true);
            if (isset($dataGenero["items"]) && !empty($dataGenero["items"])) {
                $done=false;
                $i=0;
                do {
                    if(isset($dataGenero["items"][$i]["volumeInfo"]["imageLinks"]['thumbnail'])){
                        $generos_info[]= $dataGenero["items"][$i]["volumeInfo"];
                        if (count($generos_info)==3)
                            $done=true;
                     }
                    $i++;
                } while (!$done);
            }
            //Mostrar Comentarios del libro
            $comentarios=$m->RecogerComentariosLibro($isbn);
            if(!empty($comentarios)){
                foreach ($comentarios as $value) {
                    $user=$m->verUsuario($value['id_user'],"","");

                    $params['comentarios'][]=array(
                        'idComentario'=>$value['id_comentario'],
                        'id_user'=>$user[0]['id_user'],
                        'user'=>$user[0]['usuario'],
                        'img'=>$user[0]['img_perfil'],
                        'contenido'=>$value['contenido'],
                        'fecha'=>$value['fecha'],
                    );
                }
            }else $params['404']="<p class=\"ms-5\">There are no comments for this book yet<p>";

            if(!$params['libro'])
                $params['mensaje404']='Book not found';

        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/menuBook.php';
    }

    /**
     * funcion browse
     *
     * Ruta browse
     */
    public function browse()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> '',
                'users' => '',
                'libros'=>$m->listLibrosAdmin()
            );
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            $params['users'] = $m->listarUsuarios($params['user'][0]['id_user']);

            if(empty($params['users'])){
                $params['404'] = "Users not found";
            }
            if(empty($params['libros'])){
                $params['libros404'] = "Books not found";
            }

        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/browse.php';
    }

    /**
     * funcion admin
     *
     * Ruta admin
     */
    public function admin()
    {
       $menu = $this->cargaMenu();
       try{
           $m = new Booklight();
           $params =  array(
               'user' => $m->verUsuario('','',$_SESSION['userEmail']),
               'img_perfil'=> '',
               'libros' => $m ->listLibrosAdmin(),
               'reportados' => $m ->listarReportadosAdmin(),
               'usuarios' => $m ->listarUsuariosReportadosAdmin(),
               'noticias'=>$m ->listarNoticias()
           );
           if (!$params['libros']) {
               $params['libros404']= "Books Not Found";
           }
           if (!$params['reportados']) {
               $params['reports404']= "No reports to be shown";
           }
           if (!$params['usuarios']) {
               $params['usuarios404']= "No users to be shown";
           }
           $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
       require __DIR__ . '/../../web/templates/menuAdmin.php';
    }

    /**
     * funcion user
     *
     * Ruta user
     */
    public function user()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'user2' => isset($_GET['username']) ? $m->verUsuario('',recoge('username'),'') : $m->verUsuario('','',$_SESSION['userEmail']),
                'seguido'=> '',
                'img_perfil'=> '',
                'info_cancion'=> array('cantante'=>'','cancion'=>'','audio'=>'','img_cancion'=> ''),
                'libros_fav' =>'',
                'publicaciones'  => '',
                'seguidores' => '',
                'siguiendo' => ''
            );
            $params['seguido'] = $m->verSeguimiento($params['user'][0]['id_user'],$params['user2'][0]['id_user']);
            //Imagen del layout
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            //Imagen e info cancion del user page
            $params['img_user'] = (file_exists($params['user2'][0]['img_perfil'])) ? $params['user2'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            $params['info_cancion']['cantante'] = ($params['user2'][0]['cantante']) ? $params['user2'][0]['cantante']: 'Singer not found';
            $params['info_cancion']['cancion'] = ($params['user2'][0]['cancion']) ? $params['user2'][0]['cancion']: 'Song not found';
            $params['info_cancion']['audio'] = ($params['user2'][0]['audio']) ? $params['user2'][0]['audio']: 'Audio not found';
            $params['info_cancion']['img_cancion'] = ($params['user2'][0]['imagenCancion']) ? $params['user2'][0]['imagenCancion']: '../web/img/imgMusic/default.png';
            //Libros favoritos
            $params['libros_fav'] = $m->verLibrosFavoritos($params['user2'][0]['id_user']);
            if (!$params['libros_fav']){
                $params['libros_fav404'] = 'No books to show';
            }
            //Publicaciones
            $params['publicaciones'] = $m->verPublicacionesUsuario($params['user2'][0]['id_user']);
            if(!$params['publicaciones']){
                $params['publicaciones404'] = 'Nothing to be shown';
            }
            //Seguidores
            $params['seguidores'] = $m->verSeguidores($params['user2'][0]['id_user']);
            if(!$params['seguidores']){
                $params['seguidores404'] = 'Nothing to be shown';
            }
            //Siguiendo
            $params['siguiendo'] = $m->verSiguiendo($params['user2'][0]['id_user']);
            if(!$params['siguiendo']){
                $params['siguiendo404'] = 'Nothing to be shown';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/menuUser.php';
    }

    /**
     * funcion registro
     *
     * Valida datos para registro e inserta usuario en la tabla
     */
    public function registro()
    {
        $menu = $this->cargaMenu();
        $params = array(
            'username' => '',
            'email' => '',
            'password' => '',
            'img_perfil' => '',
            'descripcion' => '',
            'newsletter'=>''
        );
        $errores = array();
        if (isset($_REQUEST['bRegistro'])) {
            //Sanitizar
            $username = recoge('username');
            $email = recoge('email');
            $password = recoge('password');
            $descripcion = recoge('about');
            $newsletter = recoge('newsletter');
            //Validar
            cTexto($username,'username',$errores);
            cEmail($email,'email',$errores);
            cPassword($password,'password',$errores,true);
            cTextarea($descripcion,'description',$errores, 150, 1);

            if (empty($errores)) {
                try {
                    $m = new Booklight();
                    $img_perfil = cFile('image', $errores, Config::$extensionesValidas, Config::$dirPerfil, Config::$max_file_size, false);
                    $img_perfil = ($img_perfil == 1) ? "../web/img/imgPerfil/default.png" : $img_perfil;
                    $params = array(
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'img_perfil' => $img_perfil,
                        'descripcion' => $descripcion
                    );
                    if (empty($errores)) {
                        if($newsletter!="")
                            $m->suscribir($email);

                        if ($m->insertarUsuario($username, $email, encriptar($password), $img_perfil, $descripcion)) {
                            $token = uniqid();
                            $params['token'] = $token;
                            if ($m->insertarToken($token,'')) {
                                //PHPMailer
                                include '../app/PHPMailer/PHPMailer.php';
                                header('Location: index.php?ctl=home');
                            }
                        } else {
                            $params['mensaje'] = 'Couldn\'t insert user.';
                        }
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }
            } else {
                $params = array(
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'descripcion' => $descripcion
                );
                $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuInvitado.php';
    }

    /**
     * funcion activar_cuenta
     *
     * Activa cuenta tras registro
     */
    public function activar_cuenta()
    {
        $menu = $this->cargaMenu();
        try {
            if (!isset($_GET['token'])) {
                $params['mensaje'] = 'Couldn\'t find token.';
            }
            $token = recoge('token');
            $m = new Booklight();
            $params['token'] = $m->verToken($token);
            if ($params['token']) {
                $validez = 3600;
                $tiempo = time() - $params['token'][0]['validez'];
                if ($tiempo < $validez) {
                    //Activar la cuenta
                    $id_user = $params['token'][0]['id_user'];
                    if ($m->activarUsuario($id_user))
                        $params['mensaje'] = 'Account activated.';
                    //Eliminar de la tabla
                    $m->eliminarToken($token);
                    header('Location: index.php?ctl=home');
                } else { //Se pasa de validez
                    //Eliminar por pasarse del tiempo
                    $m->eliminarToken($token);
                    $params['mensaje'] = 'Token validation took too long.';
                    header('Location: index.php?ctl=home');
                }
            } else {
                $params['mensaje'] = 'Couldn\'t validate token.';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuInvitado.php';
    }

    /**
     * funcion contacto
     *
     * Valida datos para enviar un mensaje al mail de la empresa
     */
    public function contacto(){
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'user' => isset($_SESSION['userEmail']) ? $m->verUsuario('','',$_SESSION['userEmail']): '',
                'img_perfil'=> '',
                'username' => '',
                'emailUser' => '',
                'motive' => '',
                'descripcion' => ''
            );
            if(!empty($params['user']))
                $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            $errores = array();
            if (isset($_REQUEST['send'])) {
                //Sanitizar
                $username = recoge('user');
                $email = recoge('email');
                $motive = recoge('motive');
                $descripcion = recoge('description');
                //Validar
                cTexto($username,'user',$errores);
                cEmail($email,'email',$errores);
                cSelect($motive, "motive", $errores, Config::$motives);
                cTextarea($descripcion,'description',$errores, 150, 1);
                if (empty($errores)) {
                    $params = array(
                        'username' => $username,
                        'emailUser'=>$email,
                        'motive' => $motive,
                        'descripcion' => $descripcion
                    );
                    //PHPMailer
                    include '../app/PHPMailer/PHPMailerContact.php';
                    header('Location: index.php?ctl=inicio');

                } else {
                    $params = array(
                        'username' => $username,
                        'emailUser' => $email,
                        'motive' => $motive,
                        'descripcion' => $descripcion
                    );
                    $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuContact.php';
    }

    /**
     * funcion inicioSesion
     *
     * Ruta inicioSesion
     */
    public function inicioSesion()
    {
        $menu = $this->cargaMenu();
        $errores = array();
        if (isset($_REQUEST['bInicioSesion'])) {
            //Sanitizar
            $email = recoge('email');
            $password = recoge('password');
            if (empty($errores)) {
                try {
                    $m = new Booklight();

                        if ($result= $m->selectInicioSesion($email)){
                            if(comprobarhash($password, $result['password']) && $result['activo'] === 1){
                                if($result['nivel']===1){
                                    session_start();
                                    $_SESSION['nivel']=1;
                                    $_SESSION['userEmail']=$email;
                                    header('Location: index.php?ctl=inicio');
                                }if($result['nivel']===2){
                                    session_start();
                                    $_SESSION['nivel']=2;
                                    $_SESSION['userEmail']=$email;
                                    header('Location: index.php?ctl=admin');
                                }
                            }else{
                                $params['mensaje404'] = 'Email or password not correct or the account is not active';
                                header('Location: index.php?ctl=home');
                            }
                        }else{
                            $params['mensaje404'] = 'No users found';
                            header('Location: index.php?ctl=home');
                        }
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }

            }else{
                $params['mensaje404'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuInvitado.php';
    }
    /**
     * funcion cierre_sesion
     *
     * Cierra la sesion
     */
    public function cierre_sesion()
    {
        $menu = $this->cargaMenu();
        session_destroy();

        header("location:index.php?ctl=home");
    }

    /**
     * funcion guardarCancion
     *
     * Ruta guardarCancion
     */
    public function guardarCancion()
    {
        $menu = $this->cargaMenu();
        $emailUser=$_SESSION['userEmail'];
        try {
            $m = new Booklight();
            $params = array(
                'info_cancion' => array(
                    'cantante'=> recoge('artista'),
                    'cancion'=> recoge('cancion'),
                    'audio'=> recoge('audio'),
                    'img_cancion' => recoge('imagen'),
                ),
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> ''
            );
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            if($m->updateCancion($emailUser,$params['info_cancion']['cantante'],$params['info_cancion']['cancion'],$params['info_cancion']['audio'],$params['info_cancion']['img_cancion'])){
                header('Location: index.php?ctl=user');
            }else{
                $params['cancion404'] = 'Song not found';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ .'/../../web/templates/menuUser.php';
    }


    /**
     * funcion editarUser
     *
     * Cambia los datos del usuario
     */
    public function editarUser()
    {
        $menu = $this->cargaMenu();
        $params = array(
            'password' => '',
            'img_perfil' => '',
            'descripcion' => ''
        );
        $errores = array();
        if (isset($_REQUEST['bEditar'])) {
            //Sanitizar
            $password = recoge('password');
            $descripcion = recoge('about');
            //Validar
            cPassword($password,'password',$errores,false);
            cTextarea($descripcion,'description',$errores, 150, 1, false);
            if (empty($errores)) {
                try {
                    $m = new Booklight();
                    $img_perfil = cFile('image', $errores, Config::$extensionesValidas, Config::$dirPerfil, Config::$max_file_size, false);
                    $params = array(
                        'password' => $password,
                        'img_perfil' => $img_perfil,
                        'descripcion' => $descripcion
                    );
                    if (empty($errores)) {
                        if ($m->editarUsuario('',$_SESSION['userEmail'], $password, $img_perfil, $descripcion)){
                            $params['mensaje'] = 'Information changed succesfully.';
                        } else {
                            $params['mensaje'] = 'Couldn\'t edit information.';
                        }
                        header('Location: index.php?ctl=user');
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }
            } else {
                $params = array(
                    'password' => $password,
                    'descripcion' => $descripcion
                );
                $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuUser.php';
    }

    /**
     * funcion anyadirNoticia
     *
     * Ruta anyadirNoticia
     */
    public function anyadirNoticia()
    {
        $menu = $this->cargaMenu();
        $errores = array();
        if (isset($_REQUEST['bAdminNoticias'])) {
            //Sanitizar
            $headerNoticia = recoge('Headline');
            $urlNoticia = recoge('url');
            $contentNoticia = recoge('content');
            $img_noticia = recoge('Document');
            if (empty($errores)) {
                try {
                    $m = new Booklight();
                    $m->aniadirNoticia($headerNoticia,$urlNoticia,$contentNoticia,$img_noticia);
                    header('Location: index.php?ctl=admin');
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }

            }else{
                $params['mensaje404'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }
    public function eliminaNoticia()
    {
        $menu = $this->cargaMenu();
        $errores = array();
        if (isset($_REQUEST['id'])) {
            //Sanitizar
            $idNoticia = recoge('id');
                try {
                   $m = new Booklight();
                    if($m->eliminarNoticia($idNoticia))
                    header('Location: index.php?ctl=admin');
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }
    /**
     * Funcion buscarLibro
     *
     * Muestra los libros que coincidan con el contenido del input
     */
    public function buscarLibro(){

        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $texto = recoge("busqueda");
            $filtro = recoge("filtro");
             // Llama al método del modelo para buscar libros

            $params =  array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> '',
                'reportados' => $m ->listarReportadosAdmin(),
                'usuarios' => $m ->listarUsuariosReportadosAdmin(),
                'libros' =>  $m->buscarLibro($texto, $filtro)
            );
            if (!$params['libros']) {
                $params['libros404']= "Books Not Found";
            }
            if (!$params['reportados']) {
                $params['reports404']= "No reports to be shown";
            }
            if (!$params['usuarios']) {
                $params['usuarios404']= "No users to be shown";
            }
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }

     /**
     * funcion anyadirComentario
     *
     * Ruta comentar  para añadir comentarios
     */
    public function anyadirComentario(){
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $errores = array();
            $isbn=$_GET['isbn'];
            $fecha=date('Y-m-d');
            if (isset($_REQUEST['btnAddComment'])) {
                $publicacion = recoge('textoComentario');
                cTextarea($publicacion,'textoComentario',$errores, 150, 1);
                if (empty($errores)) {
                    $email= $_SESSION['userEmail'];
                    $idUser= $m->verUsuario("","",$email);
                        if ($m->insertarComentario($idUser[0]['id_user'],$isbn,$publicacion,$fecha)) {
                            header('Location: index.php?ctl=book&isbn='.$isbn);
                        } else {
                            $params['mensaje'] = 'Couldn\'t insert publication.';
                        }

                } else {
                    $params = array(
                        'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                        'img_perfil'=> '',
                        'publicacion' => $publicacion
                    );
                    $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuBook.php';
    }

    /**
     * funcion anyadirLibro
     *
     * Ruta anyadirLibro
     */
    public function anyadirLibro()
    {
        $menu = $this->cargaMenu();
        $errores = array();
        if (isset($_REQUEST['btnAddBook'])) {
            //Sanitizar
            $isbn = recoge('isbn');
            $tituloLibro = recoge('titulo');
            $autor = recoge('autor');
            $editorial = recoge('editorial');
            $url_imagen = recoge('url_imagen');
            if (empty($errores)) {
                try {
                    $m = new Booklight();
                    $m->insertarLibro($isbn, $tituloLibro, $autor, $editorial, $url_imagen);
                    header('Location: index.php?ctl=admin');
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }

            }else{
                $params['mensaje404'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }

    function newsLetter(){
        $menu = $this->cargaMenu();
        $errores = array();
        if (isset($_REQUEST['bNewsLetter'])) {
            try {
               $m = new Booklight();
                $params['emails']= $m->recogeMailsNewsletter();
                if (!empty($params)) {
                    include_once '../app/PHPMailer/PHPMailerNewsletter.php';

                    header('Location: index.php?ctl=admin');
                }else{
                    $params['mensaje404'] = "There's no user subscribed to the newsletter";
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                header('Location: index.php?ctl=error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                header('Location: index.php?ctl=error');
            }
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }
    function suscribe(){
        $menu = $this->cargaMenu();
        $errores = array();
        if (isset($_REQUEST['bSubscribe'])) {
            //Sanitizar
            $mail = recoge('mail');
            cEmail( $mail, 'mail',$errores);
            if (empty($errores)) {
                try {
                   $m = new Booklight();
                    $params['emails']= $m->recogeMailsNewsletter();
                    $existe=false;
                    for($i=0; !$existe ;$i++) {
                        $value=$params['emails'][$i];
                        $existe=(in_array($mail, $value))?true:false;
                    }
                    if(!$existe)
                        $m->suscribir($mail);
                    header('Location: index.php?ctl=inicio');
                 } catch (Exception $e) {
                  error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                  header('Location: index.php?ctl=error');
                  } catch (Error $e) {
                      error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                      header('Location: index.php?ctl=error');
                  }
            }else{
                $params['mensaje404'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuInvitado.php';
    }

     /**
     * funcion eliminaLibro
     *
     * Ruta eliminaLibro
     */
    public function eliminaLibro()
    {
        $menu = $this->cargaMenu();
        $m = new Booklight();
        $errores = array();
        if (isset($_REQUEST['isbn'])) {
            //Sanitizar
            $isbn = recoge('isbn');
            if (empty($errores)) {
                try {
                    if($m->eliminarLibro($isbn))
                    header('Location: index.php?ctl=admin');
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }

            }else{
                $params['mensaje404'] = 'Some data is incorrect. Please check and try again.';
            }
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }

    /**
     * funcion seguir
     *
     * Ruta seguir para seguir usuarios
     */
    public function seguir()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'user_seguido'=> $m->verUsuario('',recoge('username'),'')
            );
            if ($m->seguir($params['user']['0']['id_user'], $params['user_seguido']['0']['id_user'])) {
                header('Location: index.php?ctl=user&username='.$params['user_seguido'][0]['usuario']);
            } else {
                $params['mensaje'] = 'Couldn\'t follow user.';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/menuUser.php';
    }

    /**
     * funcion dejarDeSeguir
     *
     * Ruta dejarDeSeguir para dejar de seguir usuarios
     */
    public function dejarDeSeguir()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'user_seguido'=> $m->verUsuario('',recoge('username'),'')
            );
            if ($m->dejarDeSeguir($params['user']['0']['id_user'], $params['user_seguido']['0']['id_user'])) {
                header('Location: index.php?ctl=user&username='.$params['user_seguido'][0]['usuario']);
            } else {
                $params['mensaje'] = 'Couldn\'t unfollow user.';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuUser.php';
    }

    /**
     * funcion banear
     *
     * Ruta banear para eliminar usuarios desde admin
     */
    public function banear()
    {
        $menu = $this->cargaMenu();
        try{
            $m = new Booklight();
            $params =  array(
                'user' => recoge('user')
            );
            if ($m->eliminarUsuario($params['user']))
                header('location:index.php?ctl=admin');
            else
                $params['mensaje'] = 'Couldn\'t delete user.';
         } catch (Exception $e) {
             error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
             header('Location: index.php?ctl=error');
         } catch (Error $e) {
             error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
             header('Location: index.php?ctl=error');
         }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
     }

     /**
      * funcion aceptarPost
      *
      * Ruta aceptarPost para quitar el reporte de posts
      */
     public function aceptarPost()
     {
         $menu = $this->cargaMenu();
         try {
            $m = new Booklight();
            $params = array(
                'id_user' => recoge('user'),
                'tipo' => recoge('tipo'),
                'post' => recoge('post'),
            );
            if($m->aceptarPost($params['tipo'], $params['post'],$params['id_user']))
                header('Location: index.php?ctl=admin');
            else
                $params['mensaje'] = 'Couldn\'t accept post.';
          } catch (Exception $e) {
              error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
              header('Location: index.php?ctl=error');
          } catch (Error $e) {
              error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
              header('Location: index.php?ctl=error');
          }
         require __DIR__ . '/../../web/templates/menuAdmin.php';
      }

      /**
       * funcion borrarPost
       *
       * Ruta borrarPost para borrar el post
       */
      public function borrarPost()
      {
          $menu = $this->cargaMenu();
          try {
             $m = new Booklight();
             $params = array(
                 'id_user' => recoge('user'),
                 'tipo' => recoge('tipo'),
                 'post' => recoge('post'),
             );
             if($m->borrarPost($params['tipo'], $params['post'],$params['id_user']))
                 header('Location: index.php?ctl=admin');
             else
                 $params['mensaje'] = 'Couldn\'t delete post.';
           } catch (Exception $e) {
               error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
               header('Location: index.php?ctl=error');
           } catch (Error $e) {
               error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
               header('Location: index.php?ctl=error');
           }
          require __DIR__ . '/../../web/templates/menuAdmin.php';
       }

    /**
     * funcion buscarUsuarios
     *
     * Ruta buscarUsuarios para buscar usuarios
     */
    public function buscarUsuarios()
    {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $params = array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> '',
                'users' => $m->buscarUsuario(recoge('textUser'),$_SESSION['userEmail']) ,
                'libros'=>$m->listLibrosAdmin()
            );
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';

        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/browse.php';
    }
    /**
     * Funcion buscarLibrosBrowse
     *
     * Muestra los libros que coincidan con el contenido del input
     */
    public function buscarLibrosBrowse(){

        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $texto = recoge("busqueda");
            $filtro = recoge("filtro");
             // Llama al método del modelo para buscar libros

            $params =  array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> '',
                'users'=>'',
                'libros' =>  $m->buscarLibro($texto, $filtro)
            );
            $params['users'] = $m->listarUsuarios($params['user'][0]['id_user']);
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
            if(empty($params['users'])){
                $params['users404'] = "Users not found";
            }
            if (!$params['libros']){
                $params['libros404']= "Books Not Found";
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/browse.php';
    }
    /**
     * Funcion buscarUsuarioAdmin
     *
     * Muestra los usuarios que coincidan con el contenido del input
     */
    public function buscarUsuarioAdmin(){

        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();
            $texto = recoge("busqueda");
            $filtro = recoge("filtro");
             // Llama al método del modelo para buscar libros
            $params =  array(
                'user' => $m->verUsuario('','',$_SESSION['userEmail']),
                'img_perfil'=> '',
                'libros' => $m ->listLibrosAdmin(),
                'usuarios' => $m ->listarUsuariosReportadosAdmin(),
                'bUsuarios' =>  $m->buscarUsuarioAdmin($texto, $filtro),
                'noticias'=>$m ->listarNoticias()
           );
            if (!$params['libros']) {
                $params['libros404']= "Books Not Found";
            }
            if (!$params['usuarios']) {
                $params['usuarios404']= "No users to be shown";
            }
            if (!$params['bUsuarios'])
                $params['bUsers404']= "Users Not Found";
            $params['img_perfil'] = (file_exists($params['user'][0]['img_perfil'])) ? $params['user'][0]['img_perfil']: '../web/img/imgPerfil/default.png';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }
     /**
     * Funcion librosPopulares
     *
     * Muestra los libros con mas likes de la BBDD
     */
    public function librosPopulares() {
        $menu = $this->cargaMenu();

        try {
            $m = new Booklight();

            $librosPopulares = $m->listLibrosPopulares(10);

            //Hay que convertir los datos a JSON
            $librosPopularesJSON = json_encode($librosPopulares);

            header('Content-type: application/json');
            echo $librosPopularesJSON;
            exit;
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuAdmin.php';
    }
    /**
     * funcion recuperar
     *
     * Valida email y envia correo para recuperar la contraseña
     */
    public function recuperar()
    {
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'email' => recoge('email'),
                'user' => ''
            );
            $params['user'] =$m->verUsuario('','',$params['email']);
            if (isset($_REQUEST['bRecover'])) {
                $token = uniqid();
                $params['token'] = $token;
                if ($m->insertarToken($token, $params['user'][0]['id_user'])) {
                    //PHPMailer
                    include '../app/PHPMailer/PHPMailerRecover.php';
                    header('Location: index.php?ctl=home');
                } else {
                    $params['mensaje'] = 'Couldn\'t recover password.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuInvitado.php';
    }
    /**
     * funcion anyadirFavorito
     *
     * Ruta anyadirFavorito, para añadir un libro a tus favoritos
     */
    public function anyadirFavorito(){
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'isbn' =>'',
                'fecha'=>'',
                'id_user' =>''
            );
            $params['isbn']=$_GET['isbn'];
            $params['fecha']=date('Y-m-d');

            $email= $_SESSION['userEmail'];
            $idUser= $m->verUsuario("","",$email);
            if (!empty($params['isbn']))
                if($m->anyadirLibroFavorito($idUser[0]['id_user'], $params['isbn'], $params['fecha'])) {
                    header('Location: index.php?ctl=book&isbn='.$params['isbn']);
                } else
                    $params['mensaje'] = 'Couldn\'t add to favorites.';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuBook.php';
    }

    /**
     * funcion cambiar_password
     *
     * Cambia la contraseña
     */
    public function cambiar_password()
    {
        $menu = $this->cargaMenu();
        $params = array(
            'token' => recoge('token'),
            'password' => ''
        );
        $errores = array();
        try {
            if (isset($_REQUEST['bEditar'])) {
                //Sanitizar
                $params['password'] = recoge('password');
                //Validar
                cPassword($params['password'],'password',$errores,false);
                if(empty($errores)){
                    $m = new Booklight();
                    $params['token_info'] = $m->verToken($params['token']);
                    if ($params['token_info']) {
                        $validez = 3600;
                        $tiempo = time() - $params['token_info'][0]['validez'];
                        if ($tiempo < $validez) {
                            //Cambiar la contraseña
                            if ($m->editarUsuario($params['token_info'][0]['id_user'],'',$params['password'],'','')){
                                //Eliminar de la tabla
                                $m->eliminarToken($params['token']);
                                header('Location: index.php?ctl=home');
                            }
                        } else { //Se pasa de validez
                            //Eliminar por pasarse del tiempo
                            $m->eliminarToken($params['token']);
                            $params['mensaje'] = 'Token validation took too long.';
                            header('Location: index.php?ctl=home');
                        }
                    } else {
                        $params['mensaje'] = 'Couldn\'t validate token.';
                    }
                } else {
                    $params['mensaje'] = 'Some data is incorrect. Please check and try again.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/cambiar_password.php';
    }

    /**
     * funcion eliminarFavorito
     *
     * Ruta eliminarFavorito, para eliminar un libro a tus favoritos
     */
    public function eliminarFavorito()
    {
        $menu = $this->cargaMenu();
        try {
            $m = new Booklight();
            $params = array(
                'isbn' =>'',
                'id_user' =>''
            );
            $params['isbn']=$_GET['isbn'];
            $email= $_SESSION['userEmail'];
            $idUser= $m->verUsuario("","",$email);
            if (!empty($params['isbn']))
                if($m->eliminarLibroFavorito($idUser[0]['id_user'], $params['isbn'])) {
                    header('Location: index.php?ctl=book&isbn='.$params['isbn']);
                } else
                    $params['mensaje'] = 'Couldn\'t add to favorites.';
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/menuBook.php';
    }
}
