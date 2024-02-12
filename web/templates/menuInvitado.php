<?php ob_start() ?>
    <!--MAIN-->
    <main id="menuInvitado" class="m-4 p-2 p-sm-3 ">
        <div class="mContent d-flex">
            <div class="mt-4 rounded-4  col-md-9 mx-3">
                <ul class="nav nav-tabs" id="myTabs">
                    <li class="nav-item">
                        <a class="nav-link active text-white fs-4" id="tab1-tab" data-bs-toggle="tab"
                            href="#tab1">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fs-4" id="tab2-tab" data-bs-toggle="tab"
                            href="#tab2">Music</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fs-4" id="tab3-tab" data-bs-toggle="tab"
                            href="#tab3">Posts</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Tab 1 - favorite books -->
                    <div class="tab-pane fade show active rounded" id="tab1">
                        <div class="cards d-flex flex-wrap justify-content-around ">
                          <?php if (!isset($params['404'])):?>
                                <?php foreach ($params['libros'] as $libro) :?>
                                    <div class="card border-0 mt-3 mb-3 h-50 w-25">
                                        <img src="<?php echo $libro['url_imagen']?>" class="bd-placeholder-img card-img-top" alt="book">
                                        <div class="content d-flex flex-column align-items-center justify-content-center w-100 h-100">
                                            <p class="fs-5 text-white mx-4"><?php echo $libro['titulo']?></p>
                                            <p class=" text-white"><?php echo $libro['autor']?></p>
                                            <a class="link" href="index.php?ctl=book&isbn=<?php echo $libro['isbn']?>">See more</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                               <?php echo($params['404']);?>
                            <?php endif ; ?>
                        </div>
                    </div>
                    <!-- Tab 2 - music -->
                    <div class="tab-pane fade rounded" id="tab2">
                        <div class="cards d-flex flex-wrap justify-content-around " id="mostrarCanciones">                                                                                                                       
                        </div>
                    </div>
                    <!-- Tab 3 - comments -->
                    <div class="tab-pane fade rounded" id="tab3">
                        <div class="d-flex flex-column">
                            <?php if (!isset($params['coments404'])):?>
                                <?php foreach ($params['comentariosInvitado'] as $comentario) :?>
                                    <div class="card my-3 g-0" >
                                        <img src="<?=$comentario['imagen_libro']?>" alt="book">
                                        <div class="card-body">
                                            <h5 class="card-title">Comments</h5>
                                            <p class="card-text">
                                                <span class="fw-bold">@<?=$comentario['nombre_usuario']?> </span><?=$comentario['comentario_libro']?>
                                                <br><small class="text-body-secondary"><?=$comentario['fecha_publicacion']?></small>
                                            </p>
                                            <a class="link-light" href="#" data-bs-target="#signUpModal" data-bs-toggle="modal">Sign up to read more</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <span class="text-white p-4"><?php echo($params['coments404']);?></span>
                            <?php endif ; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--Sidebar-->
            <aside class="d-none d-md-block mt-5 mx-3 col-2">
                <div class="carousel rounded-4 p-2 text-white">
                    <!--Carousel-->
                    <h4 class="fw-bold mb-2">News</h4>
                    <div id="carouselNews" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php
                                if(isset($params['noticias']))
                                    foreach ($params['noticias'] as $key => $value) {
                                        if($key == 0)
                                            echo '<button type="button" data-bs-target="#carouselNews" data-bs-slide-to="'.$key.'" class="active"
                                        aria-current="true" aria-label="Slide 1"></button>';
                                        else
                                            echo '<button type="button" data-bs-target="#carouselNews" data-bs-slide-to="'.$key.'"
                                        aria-label="Slide 2"></button>';
                                    }
                            ?>
                        </div>
                        <div class="carousel-inner">
                            <?php
                                if(isset($params['noticias404']))
                                    echo '<p>'.$params['noticias404'].'</p>';
                                if(isset($params['noticias'])){
                                    foreach ($params['noticias'] as $key => $value) {
                                        if($key == 0){
                                            echo '<div class="carousel-item active">';
                                        }else{
                                            echo '<div class="carousel-item">';
                                        }
                                        echo '<img src="'.$value['img'].'" class="d-block img-fluid rounded-3 mx-auto" alt="book">
                                                    <h4 class="fw-bold mt-3">'.$value['titular'].'</h4>
                                                    <p id="new">'.$value['contenido'].'</p>
                                                    <a id="redirect" href="'.$value['url'].'" class="link">Read more</a>
                                            </div>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <!--Carousel Ends-->
                </div>
            </aside>
            <!--Sidebar Ends-->
        </div>
    </main>
    <!--END MAIN-->
<?php $contenido = ob_get_clean() ?>
<script src="./js/mostrarMusica.js"></script>

<?php include $menu ?>