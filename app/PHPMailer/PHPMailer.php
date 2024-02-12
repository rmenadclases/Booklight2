<?php
    //Carga de las clases necesarias
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'Composer/vendor/autoload.php';
    require 'Composer/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'Composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'Composer/vendor/phpmailer/phpmailer/src/SMTP.php';
    //Crear instancia
    $mail = new PHPMailer(true);
    try {
        //Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'starlight.arfa@gmail.com';
        $mail->Password = 'hcog rfxk xrqj ytrk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        //Configuración destinatarios
        $mail->setFrom('starlight.arfa@gmail.com', 'Starlight Syntax');
        $mail->addAddress($params['email']);
        //Contenido
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        $imagenPath = '..\web\img\logo\logo_l.png';
        $mail->addEmbeddedImage($imagenPath, 'imagen1');
        //Asunto
        $mail->Subject = 'Activate your account to complete your registration';
        //Conteido HTML
        $mail->Body = '
        <body style="background-color: #E5EDFF; ">
            <div style="background-color:#2d3d61; border-radius:15px 15px 0 0; display:flex;  width:100%;">
                <img src="cid:imagen1" alt="Logo" style="max-width: 30%; height: auto;  margin :10px auto 10px auto;">
            </div>
            <div style="background-color:#8092a8; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius:0 0 15px 15px; display:flex; flex-direction:column; justify-content:center;">
                <h1 style="color: #fff; padding-left:15px;">Welcome to <i>BookLight</i></h1>
                <p style="color: #fff; padding-left:15px;">Click on the link to complete your registration </p>
                <p style="color: #fff; padding-left:15px;"><a href="http://localhost/booklight/web/index.php?ctl=activar_cuenta&token=' . $params['token'] . '"  target="_blank" style="color: #29303F; ">Click here</a></p>                               
            </div>
        </body>';
        //Contenido alternativo en texto simple
        $mail->AltBody = 'Welcome to BookLight. Click the link to complete your registration.';
        //Enviar correo
        $mail->send();
    } catch (Exception $e) {
        echo "El correo no se ha enviado: {$mail->ErrorInfo}";
    }
?>