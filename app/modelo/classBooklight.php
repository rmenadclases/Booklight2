<?php

class Booklight extends Modelo {

    private $conexion;
    public function __construct()
    {
        $this->conexion=parent::GetInstance();

    }

    /**
     * funcion insertarUsuario
     *
     * Inserta un usuario en la base de datos
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $img_perfil
     * @param string $descripcion
     *
     * @return int
     */
    public function insertarUsuario($username, $email, $password, $img_perfil, $descripcion) {
        $consulta = "INSERT INTO booklight.usuario (usuario, email, password, img_perfil, descripcion) VALUES (:usuario, :email, :password, :img_perfil, :descripcion)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':usuario', $username);
        $result->bindParam(':email', $email);
        $result->bindParam(':password', $password);
        $result->bindParam(':img_perfil', $img_perfil);
        $result->bindParam(':descripcion', $descripcion);
        $result->execute();
        return $result;
    }

    /**
     * funcion activarUsuario
     *
     * Actualiza el valor de la columna "activo" a 1
     *
     * @return int
     */
    public function activarUsuario($id_user) {
        $consulta = "UPDATE booklight.usuario SET activo=1 WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id_user", $id_user);
        $result->execute();

        return $result;
    }

    /**
     * funcion insertarToken
     *
     * Inserta un token en la base de datos
     * @param string $token
     * @param string $id_user
     *
     * @return int
     */
    public function insertarToken($token, $id_user) {
        if(empty($id_user))
            $id_user=$this->conexion->lastInsertId();
        $validez = time()+86400;
        $consulta = "INSERT INTO booklight.token (id_user, token, validez) VALUES (:id_user, :token, :validez)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':token', $token);
        $result->bindParam(':validez', $validez);
        $result->execute();
        return $result;
    }

    /**
     * funcion verToken
     *
     * Inserta un token en la base de datos
     * @param string $token
     *
     * @return int
     */
    public function verToken($token) {
        $consulta = "SELECT * FROM booklight.token WHERE token=:token";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':token', $token);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * funcion eliminarToken
     *
     * Elimina un token en la base de datos
     * @param string $token
     *
     * @return int
     */
    public function eliminarToken($token) {
        $consulta = "DELETE FROM booklight.token WHERE token=:token";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':token', $token);
        $result->execute();

        return $result;
    }

    /**
     * funcion verLibro
     *
     * Recoge el isbn y hace un select del libro con ese id
     * @param string $isbn
     *
     * @return int
     */
    public function verLibro($isbn) {
        $consulta = "SELECT * FROM booklight.libro WHERE isbn=:isbn";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':isbn', $isbn);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion listLibrosPopulares
     *
     * recoge x libros con mas favoritos de la base de datos
     *
     * @return array
     */
    public function listLibrosPopulares($limit) {
        $consulta = "SELECT libro.titulo, libro.autor, libro.isbn, libro.url_imagen, COUNT(favorito.isbn) AS likes
                    FROM libro
                    LEFT JOIN favorito ON favorito.isbn = libro.isbn
                    GROUP BY libro.titulo, libro.autor, libro.isbn, libro.url_imagen
                    ORDER BY likes DESC
                    LIMIT $limit;";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
    }
    /**
     * funcion RecogerComentariosLibro
     *
     * Recoge los comentarios del libro
     * @param string $isbn
     *
     * @return int
     */
    public function RecogerComentariosLibro($isbn) {
        $consulta = "SELECT * FROM booklight.comentario WHERE isbn=:isbn AND reportado=0 ORDER BY fecha DESC;";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':isbn', $isbn);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion selectInicioSesion
     *
     * Busca si el usuario existe en la base de datos.
     * @param string $email
     *
     * @return bool | array con los datos del usuario
     */
    public function selectInicioSesion($email):bool | array {
        $consulta = "SELECT email, password, activo, nivel FROM usuario WHERE email = :email";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':email', $email);
        $result->execute();

        $usuario = $result->fetch(PDO::FETCH_ASSOC);

        return $usuario;
    }

     /**
     * funcion listarNoticias
     *
     * Lista las noticias
     *
     * @return int
     */
    public function listarNoticias() {
        $consulta = "SELECT * FROM booklight.noticia ORDER BY id_noticia DESC";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * funcion verUsuario
     *
     * Devuelve el usuario buscado por la columna 'id_user', 'usuario', o 'email'
     *
     * @param string $id_user
     * @param string $user
     * @param string $email
     * @return int
     */
    public function verUsuario($id_user, $user, $email) {
        if (!empty($id_user))
            $datos = "id_user = :id_user";
        else if (!empty($user))
            $datos = "usuario = :usuario";
        else if (!empty($email))
            $datos = "email = :email";

        $consulta = "SELECT * FROM booklight.usuario WHERE $datos";
        $result = $this->conexion->prepare($consulta);

        if (!empty($id_user))
            $result->bindParam(':id_user', $id_user);
        else if (!empty($user))
            $result->bindParam(':usuario', $user);
        else if (!empty($email))
            $result->bindParam(':email', $email);

        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion verLibrosFavoritos
     *
     * Devuelve los libros favoritos de ese usuario
     *
     * @param string $user
     * @return int
     */
    public function verLibrosFavoritos($user) {
        $consulta = "SELECT * FROM booklight.favorito WHERE id_user=:user ORDER BY fecha DESC";
        $favoritos = $this->conexion->prepare($consulta);
        $favoritos->bindParam(':user', $user);
        $favoritos->execute();
        $favoritos = $favoritos->fetchAll(PDO::FETCH_ASSOC);

        $libros = array();
        foreach($favoritos as $key => $value){
            $consulta = "SELECT * FROM booklight.libro WHERE isbn=:isbn";
            $libro = $this->conexion->prepare($consulta);
            $libro->bindParam(':isbn', $value['isbn']);
            $libro->execute();

            $libros[] = $libro->fetchAll(PDO::FETCH_ASSOC)[0];
        }

        return $libros;
    }


    /**
     * funcion editarUsuario
     *
     * Edita la información del usuario en la base de datos
     * @param string $id_user
     * @param string $email
     * @param string $password
     * @param string $img_perfil
     * @param string $descripcion
     *
     * @return int
     */
    public function editarUsuario($id_user, $email, $password, $img_perfil, $descripcion) {
        $datosId = array();
        $datosUpdate = array();

        if (!empty($id_user))
            $datosId[] = "id_user = :id_user";
        if (!empty($email))
            $datosId[] = "email = :email";
        if (!empty($password))
            $datosUpdate[] = "password = :password";
        if ($img_perfil != 1 && !empty($img_perfil))
            $datosUpdate[] = "img_perfil = :img_perfil";
        if (!empty($descripcion))
            $datosUpdate[] = "descripcion = :descripcion";

        if (count($datosUpdate) > 0) {
            $idString = implode(', ', $datosId);
            $setString = implode(', ', $datosUpdate);
            $consulta = "UPDATE booklight.usuario SET $setString WHERE $idString";
            $result = $this->conexion->prepare($consulta);

            if (!empty($password))
                $result->bindParam(':password', encriptar($password));
            if ($img_perfil != 1 && !empty($img_perfil))
                $result->bindParam(':img_perfil', $img_perfil);
            if (!empty($descripcion))
                $result->bindParam(':descripcion', $descripcion);
            if (!empty($id_user))
                $result->bindParam(':id_user', $id_user);
            if (!empty($email))
                $result->bindParam(':email', $email);

            $result->execute();

            return $result;
        }
    }
    /**
     * funcion aniadirNoticia
     *
     * Añade la noticia en la base de datos
     * @param string $headerNoticia
     * @param string $urlNoticia
     * @param string $contentNoticia
     * @param string $img
     *
     */
    public function aniadirNoticia($headerNoticia,$urlNoticia,$contentNoticia,$img) {
        $consulta = "INSERT INTO booklight.noticia (titular, contenido, url, img) VALUES (:titular, :contenido, :url, :img)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':titular', $headerNoticia);
        $result->bindParam(':contenido', $contentNoticia);
        $result->bindParam(':url', $urlNoticia);
        $result->bindParam(':img', $img);
        $result->execute();
        return $result;
    }
    /**
     * funcion eliminarNoticia
     *
     * elimina la noticia de la base de datos
     * @param string $idNoticia

     *
     */
    public function eliminarNoticia($idNoticia){
        $consulta = "DELETE FROM noticia WHERE id_noticia=:new";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':new', $idNoticia);
        $result->execute();
        return $result;
    }

    /**
     * funcion listarLibrosAdmin
     *
     * Lista los libros en la pantalla del administrador
     */
    public function listLibrosAdmin() {
        $consulta = "SELECT titulo, autor, isbn, editorial, url_imagen
                    FROM libro
                    LIMIT 10;";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
    }

    /**
     * Funcion buscarLibro
     *
     * Busca los libros que coincidan con el contenido del input
     */
    public function buscarLibro($busqueda, $filtro) {
        $consulta = "SELECT * FROM libro WHERE $filtro LIKE '$busqueda%' LIMIT 10;";
        $stmt = $this->conexion->prepare($consulta);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener los resultados
        return $stmt->fetchAll();
    }

    /**
     * Funcion insertarLibro
     *
     *
     */
    public function insertarLibro($isbn, $tituloLibro, $autor, $editorial, $url_imagen) {
        $consulta = "INSERT INTO libro (isbn, titulo, autor, editorial, url_imagen) VALUES (:isbn, :titulo, :autor, :editorial, :url_imagen)";
        $stmt = $this->conexion->prepare($consulta);

        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':titulo', $tituloLibro);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':editorial', $editorial);
        $stmt->bindParam(':url_imagen', $url_imagen);

        // Ejecutar la consulta preparada
        $stmt->execute();
    }

    /**
     * funcion eliminarLibro
     *
     * elimina el libro de la base de datos
     * @param string $isbn
     *
     */
    public function eliminarLibro($isbn){
        $consulta = "DELETE FROM libro WHERE isbn = :new";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':new', $isbn);
        $result->execute();

        return $result;
    }

    /**
     * funcion insertarPublicacion
     *
     * Inserta una publicacion en la base de datos
     * @param string $id_user
     * @param string $contenido
     *
     * @return int
     */
    public function insertarPublicacion($id_user, $contenido) {
        $fecha = date("Y-m-d");

        $consulta = "INSERT INTO booklight.publicacion (id_user, contenido, fecha) VALUES (:id_user, :contenido, :fecha)";

        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':contenido', $contenido);
        $result->bindParam(':fecha', $fecha);
        $result->execute();

        return $result;
    }

    /**
     * funcion verPublicaciones
     *
     * Devuelve las publicaciones hechas por usuarios a los que sigue el user
     *
     * @param string $user
     * @return int
     */
    public function verPublicaciones($user) {
        $consulta = "SELECT p.* FROM publicacion p INNER JOIN sigue s ON p.id_user = s.id_seguido WHERE s.id_user = :user AND p.reportado = 0 ORDER BY fecha DESC";
        $publicaciones = $this->conexion->prepare($consulta);
        $publicaciones->bindParam(':user', $user);
        $publicaciones->execute();
        $result = $publicaciones->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $value) {
            $result[$key]['user_info'] = $this->verUsuario($value['id_user'], '', '');
        }
        return $result;
    }

    /**
     * funcion verPublicacionesUsuario
     *
     * Devuelve las publicaciones del user
     *
     * @param string $user
     * @return int
     */
    public function verPublicacionesUsuario($user) {
        $consulta = "SELECT * FROM booklight.publicacion WHERE id_user=:user AND reportado = 0 ORDER BY fecha DESC";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion verSeguidores
     *
     * Devuelve los usuarios que siguen al user
     *
     * @param string $user
     * @return int
     */
    public function verSeguidores($user) {
        $consulta = "SELECT u.* FROM usuario u INNER JOIN sigue s ON u.id_user = s.id_user WHERE s.id_seguido = :id_seguido ORDER BY usuario";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_seguido', $user);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion verSiguiendo
     *
     * Devuelve los usuarios que el user sigue
     *
     * @param string $user
     * @return int
     */
    public function verSiguiendo($user) {
        $consulta = "SELECT u.* FROM usuario u INNER JOIN sigue s ON u.id_user = s.id_seguido WHERE s.id_user = :id_user ORDER BY usuario";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $user);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion updateCancion
     *
     * Cambia la información de la canción del usuario
     *
     * @param string $emailUser
     * @param string $artista
     * @param string $cancion
     * @param string $audio
     * @param string $img
     * @return int
     */
    public function updateCancion($emailUser,$artista,$cancion,$audio,$img){
        $consulta = "UPDATE usuario SET imagenCancion=:imagenCancion,cantante=:cantante,cancion=:cancion,audio=:audio WHERE email=:email";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':imagenCancion', $img);
        $result->bindParam(':cantante', $artista);
        $result->bindParam(':cancion', $cancion);
        $result->bindParam(':audio', $audio);
        $result->bindParam(':email', $emailUser);
        $result->execute();

        return $result;
    }

    /**
     * funcion insertarComentario
     *
     * Inserta el comentario en la BD
     *
     * @param string $id_user
     * @param string $isbn
     * @param string $contenido
     * @param Date $fecha
     *
     * @return array
     */
    public function  insertarComentario($id_user,$isbn,$contenido,$fecha){
        $consulta = "INSERT INTO comentario (id_user,isbn, contenido, fecha) VALUES (:id_user,:isbn, :contenido, :fecha)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':isbn', $isbn);
        $result->bindParam(':contenido', $contenido);
        $result->bindParam(':fecha', $fecha);
        $result->execute();

        return $result;
    }

    /**
     * funcion seguir
     *
     * Inserta una fila a la tabla sigue de la base de datos
     * @param string $id_user
     * @param string $id_seguido
     *
     * @return int
     */
    public function seguir($id_user, $id_seguido) {
        $fecha = date("Y-m-d");

        $consulta = "INSERT INTO booklight.sigue (id_user, id_seguido, fecha) VALUES (:id_user, :id_seguido, :fecha)";

        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':id_seguido', $id_seguido);
        $result->bindParam(':fecha', $fecha);
        $result->execute();

        return $result;
    }

    /**
     * funcion dejarDeSeguir
     *
     * Elimina la fila de la tabla sigue de la base de datos
     * @param string $id_user
     * @param string $id_seguido
     *
     * @return int
     */
    public function dejarDeSeguir($id_user, $id_seguido) {
        $consulta = "DELETE FROM booklight.sigue WHERE id_user=:id_user AND id_seguido=:id_seguido";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':id_seguido', $id_seguido);
        $result->execute();

        return $result;
    }

    /**
     * funcion verSeguimiento
     *
     * Comprueba que un user sigue a otro
     * @param string $id_user
     * @param string $id_seguido
     *
     * @return int
     */
    public function verSeguimiento($id_user, $id_seguido) {
        $consulta = "SELECT * FROM booklight.sigue WHERE id_user=:user AND id_seguido=:id_seguido";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':user', $id_user);
        $result->bindParam(':id_seguido', $id_seguido);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion listarUsuarios
     *
     * Lista los usuarios
     * @param string $id_user
     *
     * @return int
     */
    public function listarUsuarios($id_user) {
        $sql = "SELECT usuario.*
        FROM usuario
        WHERE usuario.id_user != :id_user and nivel!=2";
        $result = $this->conexion->prepare($sql);
        $result->bindParam(':id_user', $id_user);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion insertarRespuesta
     *
     * Inserta una respuesta en la base de datos
     * @param string $id_post
     * @param string $id_user
     * @param string $respuesta
     *
     * @return int
     */
    public function insertarRespuesta($id_post, $id_user, $respuesta) {
        $fecha = date("Y-m-d");

        $consulta = "INSERT INTO booklight.respuesta (id_publicacion, id_user, contenido, fecha) VALUES (:id_post, :id_user, :contenido, :fecha)";

        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_post', $id_post);
        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':contenido', $respuesta);
        $result->bindParam(':fecha', $fecha);
        $result->execute();

        return $result;
    }

    /**
     * funcion verRespuestas
     *
     * Devuelve las respuestas a las publicaciones o comentarios
     *
     * @param string $post
     * @param string $user
     *
     * @return int
     */
    public function verRespuestas($post, $user) {
        $consulta = "SELECT * FROM booklight.respuesta WHERE id_publicacion =:post AND id_user=:user AND reportado = 0 ORDER BY fecha DESC";
        $publicaciones = $this->conexion->prepare($consulta);
        $publicaciones->bindParam(':post', $post);
        $publicaciones->bindParam(':user', $user);
        $publicaciones->execute();
        $result = $publicaciones->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $value) {
            $result[$key]['user_info'] = $this->verUsuario($value['id_user'], '', '');
        }
        return $result;
    }

    /**
     * funcion reportarPublicacion
     *
     * Actualiza el valor de la columna "reportado" a 1 de la tabla publicacion
     *
     * @param string $id_post
     * @param string $id_user
     *
     * @return int
     */
    public function reportarPublicacion($id_post, $id_user) {
        $consulta = "UPDATE booklight.publicacion SET reportado=1 WHERE id_post = :id_post";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id_post", $id_post);
        $result->execute();

        $this->reportarUsuario($id_user);

        return $result;
    }

    /**
     * funcion reportarComentario
     *
     * Actualiza el valor de la columna "reportado" a 1 de la tabla comentario
     *
     * @param string $id_comentario
     * @param string $id_user
     *
     * @return int
     */
    public function reportarComentario($id_comentario, $id_user) {
        $consulta = "UPDATE booklight.comentario SET reportado=1 WHERE id_comentario = :id_comentario";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id_comentario", $id_comentario);
        $result->execute();

        $this->reportarUsuario($id_user);

        return $result;
    }

    /**
     * funcion reportarRespuesta
     *
     * Actualiza el valor de la columna "reportado" a 1 de la tabla respuesta
     *
     * @param string $id_resp
     * @param string $id_user
     *
     * @return int
     */
    public function reportarRespuesta($id_resp, $id_user) {
        $consulta = "UPDATE booklight.respuesta SET reportado=1 WHERE id_respuesta = :id_resp";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id_resp", $id_resp);
        $result->execute();

        $this->reportarUsuario($id_user);

        return $result;
    }

    /**
     * funcion reportarUsuario
     *
     * Añade un reporte a la columna 'reportes' de la tabla usuario
     *
     * @param string $id_user
     *
     * @return int
     */
    public function reportarUsuario($id_user) {
        $consulta = "UPDATE booklight.usuario SET reportes=reportes+1 WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id_user", $id_user);
        $result->execute();

        return $result;
    }

    /**
     * funcion recogeMailsNewsletter
     *
     * recoge los mails de la tabla newsletter
     * @param string $idNoticia
     *
     */
     function recogeMailsNewsletter(){
        $consulta = "SELECT * FROM booklight.newsletter";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
     }
    /**
     * funcion suscribir
     *
     * recoge el mails y lo añade a la tabla newsletter
     * @param string $idNoticia
     *
     */
     function suscribir($mail){
        $consulta = "INSERT INTO booklight.newsletter (email) VALUES (:email)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':email', $mail);
        $result->execute();
        return $result;
     }

    /**
     * funcion listarReportadosAdmin
     *
     * Lista todos los posts reportados en la pantalla del administrador
     */
    public function listarReportadosAdmin() {
        $consulta = "SELECT 'respuesta' AS tipo, id_respuesta AS id,id_user, contenido, fecha FROM booklight.respuesta WHERE reportado = 1 UNION ALL SELECT 'comentario' AS tipo, id_comentario AS id,id_user, contenido, fecha FROM booklight.comentario WHERE reportado = 1 UNION ALL SELECT 'publicacion' AS tipo, id_post AS id,id_user, contenido, fecha FROM booklight.publicacion WHERE reportado = 1";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion listarUsuariosReportadosAdmin
     *
     * Lista todos los usuarios con 5 reports en la pantalla del administrador
     */
    public function listarUsuariosReportadosAdmin() {
        $consulta = "SELECT * FROM booklight.usuario WHERE reportes >= 5";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion eliminarUsuario
     *
     * Elimina un usuario en la base de datos
     * @param string $user
     *
     * @return int
     */
    public function eliminarUsuario($user) {
        $consulta = "DELETE FROM booklight.usuario WHERE id_user=:user";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->execute();

        return $result;
    }

    /**
     * funcion aceptarPost
     *
     * Actualiza el valor de la columna "reportado" a 0 de la tablas publicacion/respuesta/comentario
     *
     * @param string $tipo
     * @param string $id_post
     * @param string $id_user
     *
     * @return int
     */
    public function aceptarPost($tipo ,$id_post, $id_user) {
        switch ($tipo) {
            case 'publicacion':
                $id = "id_post";
                break;
            case 'respuesta':
                $id = "id_respuesta";
                break;
            case 'comentario':
                $id = "id_comentario";
                break;
        }
        $consulta = "UPDATE $tipo SET reportado=0 WHERE $id = :id";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id", $id_post);
        $result->execute();

        $this->aceptarUsuario($id_user);

        return $result;
    }

    /**
     * funcion aceptarUsuario
     *
     * Quita un reporte a la columna 'reportes' de la tabla usuario
     *
     * @param string $id_user
     *
     * @return int
     */
    public function aceptarUsuario($id_user) {
        $consulta = "UPDATE booklight.usuario SET reportes=reportes-1 WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id_user", $id_user);
        $result->execute();

        return $result;
    }

    /**
     * funcion borrarPost
     *
     * Borra la publicacion/respuesta/comentario
     *
     * @param string $tipo
     * @param string $id_post
     * @param string $id_user
     *
     * @return int
     */
    public function borrarPost($tipo ,$id_post, $id_user) {
        switch ($tipo) {
            case 'publicacion':
                $id = "id_post";
                break;
            case 'respuesta':
                $id = "id_respuesta";
                break;
            case 'comentario':
                $id = "id_comentario";
                break;
        }
        $consulta = "DELETE FROM $tipo WHERE $id = :id";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(":id", $id_post);
        $result->execute();

        $this->reportarUsuario($id_user);

        return $result;
    }
    /**
     * funcion buscarUsuario
     *
     * Buscar el usuario en la base de datos
     *
     * @param string $userAbuscar
     * @param string $userActual
     *
     * @return int
     */
    public function buscarUsuario($userAbuscar,$userActual) {
        $consulta = "SELECT * FROM usuario WHERE usuario LIKE :usuario AND email != :email";
        $result = $this->conexion->prepare($consulta);
        $userAbuscar = '%' . $userAbuscar . '%';

        $result->bindParam(':usuario', $userAbuscar);
        $result->bindParam(':email', $userActual);

        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Funcion buscarUsuarioAdmin
     *
     * Busca los usuarios que coincidan con el contenido del input en la zona admin
     *
     * @param string $busqueda
     * @param string $filtro
     *
     * @return int
     */
    public function buscarUsuarioAdmin($busqueda, $filtro) {
        $consulta = "SELECT 'respuesta' AS tipo, id_respuesta AS id, id_user, contenido, fecha FROM booklight.respuesta WHERE $filtro LIKE '$busqueda%' AND reportado = 1
        UNION ALL
        SELECT 'comentario' AS tipo, id_comentario AS id, id_user, contenido, fecha FROM booklight.comentario WHERE $filtro LIKE '$busqueda%' AND reportado = 1
        UNION ALL
        SELECT 'publicacion' AS tipo, id_post AS id, id_user, contenido, fecha FROM booklight.publicacion WHERE $filtro LIKE '$busqueda%' AND reportado = 1";
        $stmt = $this->conexion->prepare($consulta);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcion recogePublicaciones
     *
     * Recoge publicaciones de la base de datos
     * @param string $token
     *
     * @return int
     */
    public function recogeComentariosInvitado() {
        $consulta = "SELECT libro.url_imagen AS imagen_libro,
        comentario.contenido AS comentario_libro,
        usuario.usuario AS nombre_usuario,
        comentario.fecha AS fecha_publicacion
        FROM comentario
        JOIN usuario ON comentario.id_user = usuario.id_user
        JOIN libro ON comentario.isbn = libro.isbn
        GROUP BY libro.isbn
        LIMIT 3;";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * funcion anyadirLibroFavorito
     *
     * Añade el libro con el id_user que ha dado el like a la tabla favorito
     *
     * @param $isbn
     * @param $id_user
     * @param $fecha
     *
     */
    public function anyadirLibroFavorito($id_user, $isbn, $fecha) {
        $consulta = "INSERT INTO favorito (id_user, isbn, fecha) VALUES (:id_user, :isbn, :fecha)";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':isbn', $isbn);
        $result->bindParam(':fecha', $fecha);

        // Ejecutar la consulta y verificar si la inserción fue exitosa
        $success = $result->execute();

        return $success;
    }

     /**
     * funcion eliminarLibroFavorito
     *
     * Elimina el libro con el id_user que ha dado el like a la tabla favorito
     *
     * @param $isbn
     * @param $id_user
     *
     */
    public function eliminarLibroFavorito($id_user, $isbn) {
        $consulta = "DELETE FROM favorito WHERE id_user = :id_user AND isbn = :isbn";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_user', $id_user);
        $result->bindParam(':isbn', $isbn);

        $success = $result->execute();

        return $success;
    }

    /**
     * funcion verFavorito
     *
     * Devuelve los libros que el user tiene guardados en favoritos
     *
     * @param string $user
     * @param string $isbn
     * @return int
     */
    public function verFavorito($user,$isbn) {
        $consulta = "SELECT u.* FROM usuario u INNER JOIN favorito f ON u.id_user = f.id_user INNER JOIN libro l ON l.isbn = f.isbn WHERE f.id_user = :id_user AND l.isbn = :isbn ORDER BY u.usuario";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id_user', $user);
        $result->bindParam(':isbn', $isbn);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>