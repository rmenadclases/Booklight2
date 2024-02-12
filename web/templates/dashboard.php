<?php ob_start() ?>
<main class="container" id="menuDashboard">
    <div
      class="row mt-3 justify-content-xs-evenly justify-content-sm-evenly justify-content-md-evenly justify-content-lg-evenly justify-content-xl-evenly justify-content-xxl-evenly">
      <div class=" col-12 col-sm-12 col-lg-5 contenedorCards p-3 mb-3">
        <?php
          if(isset($params['publicaciones404']))
            echo "<span class=\"text-white\">".$params['publicaciones404']."</span>";
          if(isset($params['publicaciones']))
            foreach ($params['publicaciones'] as $publicacion) {
              echo
                '<div class="card mb-3 rounded ">
                  <div class="card-body">
                    <div class="d-flex">
                      <a href="index.php?ctl=user&username='.$publicacion['user_info'][0]['usuario'].'">
                        <img src="'.$publicacion['user_info'][0]['img_perfil'].'" alt="user" class="img-fluid rounded-circle img-perfil">
                      </a>
                      <p class="ps-3 align-self-center">'.$publicacion['contenido'].'</p>
                    </div>';
                    if(!empty($params['respuestas']))
                      foreach ($params['respuestas'][$publicacion['id_post']] as $respuesta) {
                        echo '<div class="d-flex flex-column respuesta rounded ms-5 mt-2">
                                <div class="d-flex mt-3 ps-2">
                                  <a href="index.php?ctl=user&username='.$respuesta['user_info'][0]['usuario'].'">
                                    <img src="'.$respuesta['user_info'][0]['img_perfil'].'" alt="user" class="img-fluid rounded-circle w-50">
                                  </a>
                                  <p class="align-self-center">'.$respuesta['contenido'].'</p>
                                </div>
                                <a href="index.php?ctl=reportar&respuesta='.$respuesta['id_respuesta'].'&user='.$respuesta['id_user'].'" class="ms-2 mt-1 align-self-end pb-2 pe-2" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Report comment">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#29303F" class="bi bi-flag-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                      d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                                  </svg>
                                </a>
                              </div>';
                      }
                echo '<div class="d-flex justify-content-end me-3 mt-3">
                        <button class="reply-btn btn btn-outline-secondary" type="button" id="button-reply1">Reply</button>
                        <form method="POST" action="index.php?ctl=responder&post='.$publicacion['id_post'].'" class="reply-input d-none w-100 d-flex justify-content-end">
                            <textarea class="form-control" placeholder="Reply" aria-label="Reply"
                              aria-describedby="button-submit-reply1" cols="1" rows="1" name="respuesta"></textarea>
                            <input class="btn btn-outline-secondary ms-2" type="submit" name="bReply" value="Reply">
                        </form>
                        <a href="index.php?ctl=reportar&post='.$publicacion['id_post'].'&user='.$publicacion['id_user'].'" class="ms-2 mt-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Report comment">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#29303F" class="bi bi-flag-fill"
                            viewBox="0 0 16 16">
                            <path
                              d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>';
            }
        ?>
      </div>
      <div
        class="col-12  col-lg-5 mt-3 mt-lg-0 mt-sm-0 mt-md-0 order-first order-sm-first order-md-first order-lg-last order-xl-last order-xxl-last pe-sm-2">
        <div class="row ">
          <div class="col-12 col-xs-3 mb-3 contenedorCardPublish pt-2">
            <div class="card mt-2 mb-2 rounded contenedorCardOpciones">
              <div class="card-body">
                <form method="POST" action="index.php?ctl=publicar" >
                  <div class="d-flex justify-content-between">
                    <textarea class=" ms-sm-3 align-self-center me-3 rounded" name="publicacion" required></textarea>
                    <img src="<?=$params['img_perfil']?>" alt="user" class="img-fluid rounded-circle img-perfil">
                  </div>
                  <div class="d-flex justify-content-end">
                    <input type="reset" value="reset" name="btnReset" class="me-2 mt-2 btn">
                    <input type="submit" value="save" name="btnSave" class="btn mt-2">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row ">
          <div class="col-12 mb-3 contenedorCardPublish">
            <div class="card mt-2 mb-2 rounded">
              <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators mt-5">
                  <?php
                    if(isset($params['siguiendo']))
                      foreach ($params['siguiendo'] as $key => $value) {
                        if($key == 0)
                          echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'.$key.'" class="active"
                        aria-current="true" aria-label="Slide 1"></button>';
                        else
                          echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'.$key.'"
                          aria-label="Slide 2"></button>';
                      }
                  ?>
                </div>
                <div class="carousel-inner">
                  <?php
                    if(isset($params['siguiendo404']))
                      echo $params['siguiendo404'];
                    if(isset($params['siguiendo']))
                      foreach ($params['siguiendo'] as $key => $value) {
                        if($key == 0)
                          echo '<div class="carousel-item active">';
                        else
                          echo '<div class="carousel-item">';
                        echo
                        '<div class="card-body">
                            <div class="d-flex">
                              <a href="index.php?ctl=user&username='.$value['usuario'].'">
                                <img src="'.$value['img_perfil'].'" alt="user" class="img-fluid rounded-circle">
                              </a>
                              <p class="ps-3 ps-4 ms-sm-3 align-self-center">Is listening to...';
                        if(empty($value['audio'])){
                          echo 'nothing!</p></div>';
                        }else{
                          echo '</p></div><div class="d-flex justify-content-center mt-3 ">
                              <img src="'.$value['imagenCancion'].'" alt="" class="imagenCancion mt-1 me-3">
                              <div class="d-flex flex-column justify-content-center align-items-start ms-2 contenedorCardMusica">
                                <p>'.$value['cancion'].'</p>
                                <p>'.$value['cantante'].'</p>
                                <audio controls class="rounded" id="musicAudio">
                                  <source src="'.$value['audio'].'" type="audio/mp3" class="rounded">
                                  Your browser does not support the audio element.
                                </audio>
                              </div>
                            </div>
                          </div>
                        </div>';
                        }
                      }
                  ?>
                </div>
              </div>
      </div>
    </div>
  </main>

  <?php $contenido = ob_get_clean() ?>

<?php include $menu ?>