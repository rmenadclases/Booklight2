<?php ob_start() ?>
  <!--MAIN-->
  <main id="menu-book" class="container px-5 px-sm-0">
    <div class="row justify-content-center column-gap-2 my-5">
      <div class="col-md-9 col-xl-10 row justify-content-center">
        <!--BOOK INFO-->
        <div class="book-img col-sm-4 d-flex justify-content-center">
          <img src="<?=$params['libro'][0]['url_imagen']?>" alt="Book Image" class="img-fluid rounded">
        </div>
        <div class="info col-sm-8 d-flex flex-column mt-3">
          <h1 class="title fw-bold mb-0"><?=$params['libro'][0]['titulo']?></h1>
          <span class="author fs-4"><?=$params['libro'][0]['autor']?></span>
          <div class="desc hide-text overflow-hidden"><?=$params['libro'][0]['sinopsis']?></div>
          <a href="#" class="read-more text-decoration-underline">Read more</a>
          <span class="fs-5">Genres</span>
          <ul class="genres list-group list-group-horizontal justify-content-center justify-content-md-start gap-3">
            <?php foreach ($book_info["categories"] as $value): ?>
              <li class="list-group-item p-0"><?=$value?></li>
             <?php endforeach;?>

          </ul>
          <?php
            if(!empty($params['user'])){
               if ($params['libro_favorito']) {
                echo '<a class="remove-fav btn d-flex align-items-center gap-1 mt-2 align-self-center align-self-md-start" href="index.php?ctl=eliminarFavorito&isbn='.$params['libro'][0]['isbn'].'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg>
                    Remove from favorites
                </a>';
               }else {
                  echo '<a class="add-fav btn d-flex align-items-center gap-1 mt-2 align-self-center align-self-md-start" href="index.php?ctl=anyadirFavorito&isbn='.$params['libro'][0]['isbn'].'">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                          <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                      </svg>
                      Add to favorites
                  </a>';
              }
            }
              ?>

        </div>
        <!--END BOOK INFO-->
        <!--COMMENTS-->
        <form action="index.php?ctl=anyadirComentario&isbn=<?=$params['libro'][0]['isbn']?>" method="POST">
          <div class="comments rounded d-flex flex-column row-gap-2 pt-3 pb-sm-1 my-3">
            <h5 class="ps-3">Comments</h5>
            <div class="card mx-2">
              <?php if($_SESSION['nivel'] > 0): ?>
                <div class="coment-input align-items-center">
                  <div> <img src="<?=$params['img_perfil']?>" alt="user" class=" rounded-circle"></div>
                  <div class="input-group p-2 m-2">
                    <textarea class="form-control" placeholder="Add comment" aria-label="Add comment" aria-describedby="button-comment1" maxlength="150" name="textoComentario"></textarea>
                    <input class="btn btn-outline-secondary" type="submit" id="button-comment1" name="btnAddComment" value="Comment">
                  </div>
                </div>
              <?php endif;?>
            </div>
            <?php if (!isset($params['404'])):?>
                <?php foreach ($params['comentarios'] as $comentario) :?>
                  <div class="card mx-2">
                   <div class="coment-input align-items-center">
                      <div><a href="index.php?ctl=user&username=<?=$comentario['user']?>"><img src="<?=$comentario['img']?>" alt="user" class="rounded-circle"></a></div>
                      <div class="p-2 m-2">
                      <p class="ps-3"> <span><?=$comentario['contenido']?></span><br>
                      <small class="mt-2"><?=$comentario['fecha']?></small></p></div>
                    </div>
                    <?php if($_SESSION['nivel'] > 0): ?>
                      <div class="d-flex justify-content-end gap-3 align-items-center mx-3 mb-2">
                        <a href="index.php?ctl=reportar&comentario=<?=$comentario['idComentario']?>&user=<?=$comentario['id_user']?>&isbn=<?=$_GET['isbn']?>" class="ms-2 mt-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Report comment">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#29303F" class="bi bi-flag-fill"
                            viewBox="0 0 16 16">
                            <path
                              d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                          </svg>
                        </a>
                      </div>
                    <?php endif;?>
                  </div>
                <?php endforeach; ?>
            <?php else : ?>
                <?php echo($params['404']);?>
            <?php endif ; ?>

          </div>
        </form>
        <!--END COMMENTS-->
      </div>
      <!--ASIDE-->
      <aside class="related col-md-3 col-xl-2 rounded d-none d-md-block ms-3 p-3 h-75">
        <h4>See related...</h4>
        <p class="fs-5 mb-0">From the author</p>
        <div class="card m-3 m-md-0">
          <div id="carouselRelatedBooks" class="carousel slide">
            <div class="carousel-inner">
              <div class="carousel-item active">
              <a href="https://www.google.com/search?q=<?=urlencode($params['libro'][0]['autor'])?>"><img src="<?=$autores_info[0]["imageLinks"]['thumbnail']?>" class="d-block w-100 rounded" alt="book1"></a>
              </div>
              <div class="carousel-item">
              <a href="https://www.google.com/search?q=<?=urlencode($params['libro'][1]['autor'])?>"><img src="<?=$autores_info[1]["imageLinks"]['thumbnail']?>" class="d-block w-100 rounded" alt="book2"></a>
              </div>
              <div class="carousel-item">
              <a href="https://www.google.com/search?q=<?=urlencode($params['libro'][2]['autor'])?>"><img src="<?=$autores_info[2]["imageLinks"]['thumbnail']?>" class="d-block w-100 rounded" alt="book3"></a>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRelatedBooks" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselRelatedBooks" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <p class="fs-5 mt-3 mb-0">Similar genres</p>
        <div class="card m-3 m-md-0">
          <div id="carouselRelatedGenres" class="carousel slide">
            <div class="carousel-inner">
              <div class="carousel-item active">
              <a href="https://www.google.com/search?q=<?=urlencode($generos_info[0]['authors'][0])?>"><img src="<?=$generos_info[0]["imageLinks"]['thumbnail']?>" class="d-block w-100 rounded" alt="book1"></a>
              </div>
              <div class="carousel-item">
              <a href="https://www.google.com/search?q=<?=urlencode($generos_info[1]['authors'][0])?>"><img src="<?=$generos_info[1]["imageLinks"]['thumbnail']?>" class="d-block w-100 rounded" alt="book2"></a>
              </div>
              <div class="carousel-item">
               <a href="https://www.google.com/search?q=<?=urlencode($generos_info[2]['authors'][0])?>"><img src="<?=$generos_info[2]["imageLinks"]['thumbnail']?>" class="d-block w-100 rounded" alt="book3"></a>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRelatedGenres" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselRelatedGenres" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </aside>
      <!--END ASIDE-->
    </div>
  </main>
  <!--END MAIN-->

<?php $contenido = ob_get_clean() ?>

<?php include $menu ?>