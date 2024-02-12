<?php ob_start() ?>
<script src="../js/mostrarMusica.js"></script>
    <main id="browseMain" class="container mb-3">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mt-3">
                <h5>Books</h5>
                <div class="libros card card-body">
                <form method="POST" action="index.php?ctl=buscarLibrosBrowse" novalidate>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Recipient's book" aria-label="Recipient's book" aria-describedby="basic-addon2" name="busqueda">
                        <div class="input-group-append">
                            <select class="btn btn-secondary" type="button" name="filtro">
                                <option value="titulo">Titulo</option>
                                <option value="autor">Autor</option>
                            </select>
                            <input class="btn btn-dark" type="submit" value="Search">
                        </div>
                    </div>
                </form>
                    <section class="contenido rounded">
                            <div class="tab-pane fade show active rounded" id="tab1">
                                <div class="cards d-flex flex-wrap justify-content-around ">
                                <?php if (!isset($params['libros404'])):?>
                                        <?php foreach ($params['libros'] as $libro) :?>
                                            <div class="card border-0 mt-3 mb-3 h-50 w-25">
                                                <img src="<?php echo $libro['url_imagen']?>" class="bd-placeholder-img" alt="book">
                                                <div class="content d-flex flex-column align-items-center justify-content-center w-100 h-100">
                                                    <p class=" mx-1 text-center text-white"><?php echo $libro['titulo']?></p>
                                                    <p class=" text-center text-white"><?php echo $libro['autor']?></p>
                                                    <a class="link" href="index.php?ctl=book&isbn=<?php echo $libro['isbn']?>">See more</a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <span class="text-white p-4"><?php echo($params['libros404']);?></span>
                                    <?php endif ; ?>
                                </div>
                            </div>
                    </section>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-4 mt-3 mb-5">
                <h5>Users</h5>
                <div class="card cardUsuarios">
                    <div class="input-group-prepend mt-3 ms-3">
                    <form method="POST" action="index.php?ctl=buscarUsuarios"novalidate>
                        <div class="input-group ">
                                <input type="text" class="form-control flex-fill" placeholder="Recipient's username" aria-describedby="basic-addon2" name="textUser">
                                <div class="input-group-append">
                                <input class="btn btn-dark me-3" type="submit" value="Search">
                            </div>
                        </div>
                    </form>
                    </div>
                    <section class="contenidoUsuarios">
                        <div class="card-body">
                        <?php if (!isset($params['users404'])&& !empty($params['users'])):?>
    	                            <?php foreach ($params['users'] as $usuario) :?>
                                        <a href="index.php?ctl=user&username=<?=$usuario['usuario']?>" class="row text-decoration-none mb-2">
                                            <div class="comments rounded">
                                                <div class="card usuario">
                                                    <div class="card-body d-flex align-items-center justify-content-start w-50">
                                                        <img src="<?php echo $usuario['img_perfil']?>" alt="book" id="url_imagen" class="m-0 img-fluid w-25">
                                                        <span class="ps-3"><strong><?php echo $usuario['usuario']?> </strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else : ?>
	                                <?php echo '<div class="text-white text-center ">User not found</div>'; ?>
                                <?php endif ; ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <?php $contenido = ob_get_clean() ?>

<?php include $menu ?>