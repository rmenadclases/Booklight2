<?php

class ControllerJS
{
    /**
     * funcion existeUsuario
     *
     * Verifica que el usuario exista en la base de datos al intentar registrarse
     */
    public function existeUsuario()
    {
        try {
            $m = new Booklight();
            $params = array(
                'user' => recoge('user'),
                'userBD' => $m->verUsuario('',recoge('user'),'')
            );
            if($params['userBD']){
                $exists = ($params['user'] === $params['userBD'][0]['usuario']);
            }else
                $exists = false;
            header('Content-Type: application/json');
            echo json_encode(array('exists' => $exists));
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }
    /**
     * funcion existeEmail
     *
     * Verifica que el email exista en la base de datos al intentar registrarse
     */
    public function existeEmail()
    {
        try {
            $m = new Booklight();
            $params = array(
                'email' => recoge('email'),
                'emailBD' => $m->verUsuario('','',recoge('email'))
            );
            if($params['emailBD']){
                $exists = ($params['email'] === $params['emailBD'][0]['email']);
            }else
                $exists = false;
            header('Content-Type: application/json');
            echo json_encode(array('exists' => $exists));
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }
}
?>
