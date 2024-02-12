<?php ob_start() ?>
<!--MAIN-->
<main id="adminTab" class="m-4 p-2 p-sm-3 ">
    <div class="mt-4 rounded-4  mx-3">
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active text-white fs-4" id="tab1-tab" data-bs-toggle="tab" href="#tab1">Books</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white fs-4" id="tab2-tab" data-bs-toggle="tab" href="#tab2">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white fs-4" id="tab3-tab" data-bs-toggle="tab" href="#tab3">News</a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- Tab 1 - books -->
            <div class="tab-pane show active fade rounded" id="tab1">
                <div class="row">
                    <div class="admin d-flex flex-column col-12 col-xl-6 me-5 rounded">
                        <form class="input-group mb-3 mt-3" action="index.php?ctl=buscarLibro" method="POST">
                            <input type="text" class="form-control" placeholder="Recipient's book"
                                aria-label="Recipient's book" aria-describedby="basic-addon2" name="busqueda">
                            <div class="input-group-append">
                                <select class="btn btn-secondary" type="button" name="filtro">
                                    <option value="isbn">ISBN</option>
                                    <option value="titulo">Title</option>
                                    <option value="autor">Author</option>
                                </select>
                                <input class="btn" type="submit" value="Search" />
                            </div>
                        </form>
                        <input class="btn" type="" value="Add" data-bs-toggle="modal" data-bs-target="#addBookModal" />
                        <div class="info">
                            <?php if (!isset($params['libros404'])): ?>
                                <?php foreach ($params['libros'] as $libro): ?>
                                    <div class="card m-3 g-0">
                                        <img src="<?php echo $libro['url_imagen'] ?>" alt="book" id="url_libro">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title justify-content-center align-items-center flex-wrap">
                                                    <strong>Title: </strong>
                                                    <?php echo $libro['titulo'] ?>
                                                </h5>
                                                <a class="link delete-book-btn"
                                                    href="index.php?ctl=eliminaLibro&isbn=<?= $libro['isbn'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <p class="card-text justify-content-center align-items-center" id="isbn">
                                                <strong>ISBN: </strong>
                                                <?php echo $libro['isbn'] ?>
                                            </p>
                                            <p class="card-text justify-content-center align-items-center" id="autor">
                                                <strong>Author: </strong>
                                                <?php echo $libro['autor'] ?>
                                            </p>
                                            <p class="card-text justify-content-center align-items-center" id="editorial">
                                                <strong>Publisher: </strong>
                                                <?php echo $libro['editorial'] ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php echo ($params['libros404']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- ADD BOOKS MODAL -->
                    <div class="modal fade" id="addBookModal" aria-hidden="true" aria-labelledby="addBookModalLabel"
                        tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 fw-bold" id="addBookModalLabel">Add Book</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add book form -->
                                    <form id="modalform" class="row g-3 needs-validation"
                                        action="index.php?ctl=anyadirLibro" method="POST" novalidate>
                                        <div class="col-md-12">
                                            <label for="isbn" class="form-label">ISBN</label>
                                            <input type="number" name="isbn" class="form-control" id="isbn"
                                                placeholder="ISBN" required>
                                            <div class="invalid-feedback">
                                                Please provide a isbn.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" name="titulo" class="form-control" id="titulo"
                                                placeholder="Title" required>
                                            <div class="invalid-feedback">
                                                Please provide a title.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="author" class="form-label">Author</label>
                                            <input type="text" name="autor" class="form-control" id="autor"
                                                placeholder="Author" required>
                                            <div class="invalid-feedback">
                                                Please provide an author.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="publisher" class="form-label">Publisher</label>
                                            <input type="text" name="editorial" class="form-control" id="editorial"
                                                placeholder="Publisher" required>
                                            <div class="invalid-feedback">
                                                Please provide a publisher.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="image_url" class="form-label">Image URL</label>
                                            <input type="url" name="url_imagen" class="form-control" id="url_imagen"
                                                placeholder="Image URL" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid image URL.
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex gap-2 justify-content-between">
                                            <button class=" btn btn-lg rounded-3" type="reset">Reset</button>
                                            <button class="btn btn-lg rounded-3" type="submit" name="btnAddBook">Add
                                                Book</button>
                                        </div>
                                    </form>
                                    <!-- End add book form -->
                                </div>
                                <div class="modal-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END ADD BOOKS MODAL -->
                    <!--Sidebar-->
                    <div class="col-12 col-xl-5 col-gap-5 tamanioGrafica">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                            <!-- Content for the second column (e.g., chart) -->
                            <div class="d-flex justify-content-end my-4">
                                <canvas id="myChart" width="343" height="221" class="my-4 w-100"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--Sidebar Ends-->
                </div>
            </div>
            <!-- Tab 2 - users -->
            <div class="tab-pane fade rounded" id="tab2">
                <div class="row justify-content-between">
                    <div class="admin d-flex flex-column col-12 col-lg-7 me-5 rounded comentarios">
                        <form class="input-group mb-3 mt-3" action="index.php?ctl=buscarUsuarioAdmin" method="POST">
                            <input type="text" class="form-control" placeholder="Recipient's user"
                                aria-label="Recipient's user" aria-describedby="basic-addon2" name="busqueda">
                            <div class="input-group-append">
                                <select class="btn btn-secondary" type="button" name="filtro">
                                    <option value="id_user">Id</option>
                                    <option value="usuario">Nombre</option>
                                    <option value="email">Email</option>
                                </select>
                                <input class="btn" type="submit" value="Search" id="bSearchUser" />
                            </div>
                        </form>
                        <div class="info">
                            <?php if (!empty($params['bUsuarios'])): ?>
                                <?php foreach ($params['bUsuarios'] as $usuario): ?>
                                    <div class="card m-3">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title"><strong>User id:
                                                        <?= $usuario['id_user'] ?>
                                                    </strong></h5>
                                                <p class="card-text mb-0">Post id:
                                                    <?= $usuario['id'] ?>
                                                </p>
                                                <p class="card-text mb-0">Content:
                                                    <?= $usuario['contenido'] ?>
                                                </p>
                                                <p class="card-text">Date:
                                                    <?= $usuario['fecha'] ?>
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a class="link me-3"
                                                    href="index.php?ctl=aceptarPost&post=<?= $usuario['id'] ?>&tipo=<?= $usuario['tipo'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 0A8 8 0 1 0 8 16A8 8 0 0 0 8 0zM6.354 11.354a.5.5 0 0 1-.708 0L3.354 8.354a.5.5 0 0 1 .708-.708L6 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6z" />
                                                    </svg>
                                                </a>
                                                <a class="link"
                                                    href="index.php?ctl=borrarPost&post=<?= $usuario['id'] ?>&tipo=<?= $usuario['tipo'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php elseif (isset($params['bUsers404'])): ?>
                                <?php echo ($params['bUsers404']); ?>
                            <?php elseif (!empty($params['reportados'])): ?>
                                <?php foreach ($params['reportados'] as $reportado): ?>
                                    <div class="card m-3">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title"><strong>User id:
                                                        <?= $reportado['id_user'] ?>
                                                    </strong></h5>
                                                <p class="card-text mb-0">Post id:
                                                    <?= $reportado['id'] ?>
                                                </p>
                                                <p class="card-text mb-0">Content:
                                                    <?= $reportado['contenido'] ?>
                                                </p>
                                                <p class="card-text">Date:
                                                    <?= $reportado['fecha'] ?>
                                                </p>
                                                <p class="card-text">DB table:
                                                    <?= $reportado['tipo'] ?>
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a class="link me-3"
                                                    href="index.php?ctl=aceptarPost&post=<?= $reportado['id'] ?>&tipo=<?= $reportado['tipo'] ?>&user=<?= $reportado['id_user'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 0A8 8 0 1 0 8 16A8 8 0 0 0 8 0zM6.354 11.354a.5.5 0 0 1-.708 0L3.354 8.354a.5.5 0 0 1 .708-.708L6 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6z" />
                                                    </svg>
                                                </a>
                                                <a class="link"
                                                    href="index.php?ctl=borrarPost&post=<?= $reportado['id'] ?>&tipo=<?= $reportado['tipo'] ?>&user=<?= $reportado['id_user'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php echo ('<p class="text-white">' . $params['reports404'] . '</p>'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!--Sidebar-->
                    <aside class="info rounded comentarios col-12 col-lg-4 mt-4 mt-lg-0">
                        <p class="fs-5 mt-2 fw-bold text-white">Reported users</p>
                        <?php if (!isset($params['usuarios404'])): ?>
                            <?php foreach ($params['usuarios'] as $usuario): ?>
                                <div class="card m-3">
                                    <div class="card-body d-flex align-items-center">
                                        <a href="index.php?ctl=user&username=<?= $usuario['usuario'] ?>" class="w-25">
                                            <img src="<?= $usuario['img_perfil'] ?>" alt="user"
                                                class="img-fluid rounded-circle w-50">
                                        </a>
                                        <div>
                                            <strong>User id:
                                                <?= $usuario['id_user'] ?>
                                            </strong>
                                            <p class="m-0">Reports:
                                                <?= $usuario['reportes'] ?>
                                            </p>
                                        </div>
                                        <a class="link ms-auto" href="index.php?ctl=banear&user=<?= $usuario['id_user'] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                                class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="mt-2 text-white">
                                <?php echo ($params['usuarios404']); ?>
                            </p>
                        <?php endif; ?>
                    </aside>
                </div>
                <!--Sidebar Ends-->
            </div>
            <!-- Tab 3 - news -->
            <div class="tab-pane fade rounded" id="tab3">
                <div class="row">
                    <div class="info d-flex flex-column col-12 col-lg-7 me-5 rounded">
                        <?php if (!isset($params['404'])): ?>
                            <?php foreach ($params['noticias'] as $noticia): ?>
                                <div class="card m-3 g-0">
                                    <img src="<?php echo $noticia['img'] ?>" alt="book" id="imagen">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title justify-content-center align-items-center flex-wrap fw-bold">
                                                <?php echo $noticia['titular'] ?>
                                            </h5>
                                            <a class="link delete-button"
                                                href="index.php?ctl=eliminaNoticia&id=<?= $noticia['id_noticia'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                                                </svg>
                                            </a>
                                        </div>
                                        <p class="card-text justify-content-center align-items-center" id="isbn">
                                            <?php echo $noticia['contenido'] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php echo ($params['404']); ?>
                        <?php endif; ?>
                    </div>
                    <!--Sidebar-->
                    <aside class="col-12 col-lg-4">
                        <form class="column mx-4 needs-validation rounded-2" action="index.php?ctl=anyadirNoticia"
                            method="POST" novalidate>
                            <div class="p-3">
                                <div class="my-2 row">
                                    <div>
                                        <label for="Headline" class="form-label text-white fw-bold fs-5">Headline
                                            *</label>
                                        <input type="text" name="Headline" class="form-control mb-3"
                                            aria-label="Headline" placeholder="Headline" required>
                                        <p class="invalid-feedback">
                                            Please input a valid headline.
                                        </p>
                                    </div>
                                </div>
                                <div class="my-2 row">
                                    <div>
                                        <label for="url" class="form-label text-white fw-bold fs-5">Link *</label>
                                        <input type="text" name="url" class="form-control mb-3" aria-label="Headline"
                                            placeholder="Link" required>
                                        <p class="invalid-feedback">
                                            Use a format that matches the one requested (https://*).
                                        </p>
                                    </div>
                                </div>
                                <div id="newsImage" class="my-2">
                                    <label for="Document" class="text-white fw-bold fs-5">New's
                                        Image</label>
                                    <input type="url" name="Document" aria-label="Supporting Documents"
                                        class="form-control mb-3" id="Document" placeholder="Image URL" required>
                                    <p class="invalid-feedback">
                                        Please input a valid url.
                                    </p>
                                </div>
                                <div class="my-2">
                                    <label for="content" class="form-label text-white fw-bold fs-5">Content
                                        *</label>
                                    <textarea name="content" class="form-control" maxlength="150" aria-label="Content"
                                        required></textarea>
                                    <p class="invalid-feedback">
                                        Please complete this section.
                                    </p>
                                </div>
                                <hr>
                                <div class="row my-2 justify-content-around">
                                    <button type="reset" class="btn col-md-4 my-2"
                                        aria-label="Reset button">RESET</button>
                                    <input type="submit" class="btn col-md-7 my-2" aria-label="Submit button"
                                        value="SEND" name="bAdminNoticias">
                                </div>
                            </div>
                        </form>
                        <form id="newsLetter" action="index.php?ctl=newsLetter" method="POST"
                            class="my-3 d-flex justify-content-center">
                            <input type="submit" class="btn" value="Send NewsLetter" name="bNewsLetter">
                        </form>
                    </aside>
                    <!--Sidebar Ends-->
                </div>
            </div>
        </div>
    </div>
</main>
<!--END MAIN-->
<script src="./js/admin.js"></script>

<?php $contenido = ob_get_clean() ?>

<?php include $menu ?>