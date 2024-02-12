<?php ob_start() ?>
  <!--MAIN-->
  <main id="menu-user">
    <!--EDIT USER MODAL-->
    <div class="modal fade" id="editModal" aria-hidden="true" aria-labelledby="editModalLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">Edit User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data" action="index.php?ctl=editarUser" >
              <div class="col-md-6">
                <label for="editUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="editUsername" name="username" value="<?=$params['user2'][0]['usuario']?>" disabled>
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
              <div class="col-md-6">
                <label for="editEmail" class="form-label">Email</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="editPrepend">@</span>
                  <input type="text" class="form-control" id="editEmail" name="Email" value="<?=$params['user2'][0]['email']?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <label for="editPassword" class="form-label">Password</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="editPrepend2">*</span>
                  <input type="password" class="form-control" id="editPassword" name="password"
                    aria-describedby="inputGroupPrepend2"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.]){8,}$">
                  <div class="invalid-feedback">
                    Please provide a password at least 8 characters long, with a minimum of one letter, number and
                    symbol (?!*%#).
                  </div>
                </div>
              </div>
              <div id="edit-img" class="mb-md-0 col-md-6">
                <label for="image" class="input-group-text btn fw-bold fs-5 text-wrap col-12 d-sm-none">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                    <path
                      d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                    <path
                      d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                  </svg>
                  Profile image
                </label>
                <label for="editimage" class="d-none d-sm-block mb-2">Profile image</label>
                <input type="file" id="editimage" name="image" aria-label="Profile image"
                  class="form-control d-none d-sm-block mb-3">
              </div>
              <div class="form-group mt-0">
                <label for="editAbout" class=" form-label">About me</label>
                <textarea class="form-control" id="editAbout" name="about" aria-label="About" maxlength="150"></textarea>
                <div class="invalid-feedback">
                  Use a format that matches the one requested. (All types of characters, maximum 150)
                </div>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn" type="reset">Reset</button>
                <input class="btn" type="submit" value="Save Changes" name="bEditar">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <p class="invisible">Booklight</p>
          </div>
        </div>
      </div>
    </div>
    <!--END EDIT USER MODAL-->
    <!--FOLLOWERS MODAL-->
    <div class="modal fade" id="followersModal" aria-hidden="true" aria-labelledby="followingModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bold">Followers</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body follows rounded row-gap-2 pb-3">
            <?php
              if(isset($params['seguidores404']))
                echo $params['seguidores404'];
              if(isset($params['seguidores'])){
                foreach ($params['seguidores'] as $key => $value) {
                  echo '
                    <div class="user rounded d-flex align-items-center ps-3 justify-content-center">
                      <img class="rounded-circle my-3 me-2 w-25" src="'.$value['img_perfil'].'" alt="User Pic">
                        <h5 class="user-name m-0 ps-3 align-self-center">'.$value['usuario'].'</h5>
                    </div>';
                }
              }
            ?>
          </div>
          <div class="modal-footer">
            <button class="btn fw-bold" data-bs-target="#followingModal" data-bs-toggle="modal">See following</button>
          </div>
        </div>
      </div>
    </div>
    <!--END FOLLOWERS MODAL-->
    <!--FOLLOWING MODAL-->
    <div class="modal fade" id="followingModal" aria-hidden="true" aria-labelledby="followingModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 fw-bold">Following</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body follows rounded row-gap-2 pb-3">
            <?php
                if(isset($params['siguiendo404']))
                  echo $params['siguiendo404'];
                if(isset($params['siguiendo'])){
                  foreach ($params['siguiendo'] as $key => $value) {
                    echo '
                      <div class="user rounded d-flex align-items-center ps-3 justify-content-center">
                        <img class="rounded-circle my-3 me-2 w-25" src="'.$value['img_perfil'].'" alt="User Pic">
                          <h5 class="user-name m-0 ps-3 align-self-center">'.$value['usuario'].'</h5>
                      </div>';
                  }
                }
              ?>
          </div>
          <div class="modal-footer">
            <button class="btn fw-bold" data-bs-target="#followersModal" data-bs-toggle="modal">See followers</button>
          </div>
        </div>
      </div>
    </div>
    <!--END FOLLOWING MODAL-->
    <div class="row mx-2 mx-md-0 my-5 column-gap-2 justify-content-center">
      <!--USER-->
      <div class="rounded col-md-6 col-lg-7 user d-flex flex-column flex-sm-row align-items-center flex-md-column flex-lg-row py-3">
          <img class="user-img rounded-circle mt-3 my-md-0 mx-4" src="<?=$params['img_user']?>" alt="User Pic">
          <div class="user-info mt-3 m-md-0 d-flex flex-column align-items-center w-100">
              <h1 id="user-name" class="m-0"><?=$params['user2'][0]['usuario']?></h1>
              <div class="d-flex column-gap-2">
                <a href="#" class="m-0 p-0 text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#followersModal"><span id="followers"><?=empty($params['seguidores'])? 0 : count($params['seguidores'])?></span> followers</a>
                <a href="#" class="m-0 p-0 text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#followingModal"><span id="following"><?=empty($params['siguiendo'])? 0 : count($params['siguiendo'])?></span> following</a>
              </div>
              <h5 class="m-0 my-1">About me</h5>
              <p class="user-aboutme text-center text-break w-75"><?=$params['user2'][0]['descripcion']?></p>
              <?php
                if($params['user2'][0]['email'] == $_SESSION['userEmail'])
                  echo '<button class="btn w-100" type="button" id="button-editProfile" data-bs-target="#editModal" data-bs-toggle="modal">Edit profile</button>';
                else if (empty($params['seguido']))
                  echo '<a class="btn w-100" href="index.php?ctl=seguir&username='.$params['user2'][0]['usuario'].'">Follow</a>';
                else
                  echo '<a class="btn w-100" href="index.php?ctl=dejarDeSeguir&username='.$params['user2'][0]['usuario'].'">Unfollow</a>';
              ?>
          </div>
      </div>
      <!--END USER-->
      <!--SONG-->
      <div class="song col-md-5 col-lg-4 rounded mt-3 mt-md-0 d-flex flex-column justify-content-center">
        <div class="d-flex flex-column align-items-center flex-sm-row flex-md-column flex-lg-row mt-sm-3">
          <div class="text-center my-3 mt-sm-0 d-flex justify-content-center flex-md-column align-items-center flex-lg-row">
            <img src="<?=$params['info_cancion']['img_cancion']?>" alt="Song image" class="song-img pb-sm-3 me-3 pb-md-0 me-md-0 me-md-3">
            <div class="song-info mt-1">
              <h1 class="song-title fs-1"><?=$params['info_cancion']['cancion']?></h1>
              <p class="artist fs-5"><?=$params['info_cancion']['cantante']?></p>
              <audio controls class="mb-3 rounded d-none d-sm-block d-md-none d-lg-block">
                  <source src="<?=$params['info_cancion']['audio']?>" type="audio/mp3" class="song-audio">
                  Audio not supported.
              </audio>
            </div>
          </div>
          <audio controls class="mb-3 rounded d-sm-none d-md-block d-lg-none">
              <source src="tu_archivo_de_audio.mp3" type="audio/mp3" class="song-audio">
              Audio not supported.
          </audio>
        </div>
        <?php
          if($params['user2'][0]['email'] == $_SESSION['userEmail'])
            echo '<button class="songSearch-btn btn" type="button" id="button-songSearchShow">Change song</button>
            <form method="GET" action="index.php?ctl=buscarCancion" class="songSearch-input input-group d-none mb-3 mb-md-0 mb-md-3">
              <input type="text" class="form-control" placeholder="Search a song" aria-label="Search a song" aria-describedby="button-songSearch" name="cancion">
              <button class="songSearchClose-btn btn" type="button" id="button-close">X</button>
              <button class="songSearchClose-btn btn" type="button" id="button-songSearch" name="bBuscarCancion">Search</button>
              <span id="error"></span>
            </form>';
        ?>
      </div>
      <!--END SONG-->
      <!--POSTS-->
      <div class="posts col-md-7 col-lg-8 rounded d-flex flex-column row-gap-2 pt-3 pb-sm-1 mt-3">
        <h5 class="ps-2">Posts</h5>
        <?php
          if(isset($params['publicaciones404']))
            echo $params['publicaciones404'];
          if(isset($params['publicaciones'])){
            foreach ($params['publicaciones'] as $key => $value) {
              echo '
              <div class="card mb-2">
                <div class="card-body d-flex align-items-center pb-0">
                  <img src="'.$params['img_user'].'" alt="user" class="img-fluid rounded-circle">
                  <span class="ps-3">'.$value['contenido'].'</span>
                </div>
                <small class="pb-3 pe-3 align-self-end">'.$value['fecha'].'</small>
              </div>';
            }
          }
        ?>
      </div>
      <!--END POSTS-->
      <!--FAVORITE BOOKS-->
      <div class="fav-books col-md-4 col-lg-3 rounded pt-3 mt-3 align-self-center">
        <h5 class="ps-2 mb-3">Favorite books</h5>
        <div class="fav-book-list d-flex column-gap-2 row-gap-2 flex-wrap pb-3 align-self-center justify-content-around">
          <?php
              if(isset($params['libros_fav404']))
                  echo '<p>'.$params['libros_fav404'].'</p>';
              if(isset($params['libros_fav'])){
                  foreach ($params['libros_fav'] as $key => $value) {
                      echo
                        '<div class="card border-0">
                          <img src="'.$value['url_imagen'].'" class="rounded" alt="book">
                          <div class="content d-flex flex-column align-items-center justify-content-center w-100 h-100 rounded">
                              <p class="text-white text-center">'.$value['titulo'].'</p>
                              <p class="text-white text-center">'.$value['autor'].'</p>
                              <a class="link" href="index.php?ctl=book&isbn='.$value['isbn'].'">See more</a>
                          </div>
                        </div>';
                  }
              }
          ?>
        </div>
      </div>
      <!--END FAVORITE BOOKS-->
    </div>
  </main>
  <!--END MAIN-->

<?php $contenido = ob_get_clean() ?>

<?php include $menu ?>