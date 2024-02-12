<?php ob_start() ?>
<!--MAIN-->
<main class="container mb-3" id="contactMain">
    <div class="row gap-md-5">
        <div class="mt-4 col-md-7">
            <form class="column mx-4 needs-validation rounded-3" method="post" action="index.php?ctl=contacto" novalidate>
                <div class="p-3">
                    <div class="my-2">
                        <label for="fullName" class="form-label fw-bold fs-5">User Name *</label>
                        <input type="text" name="user" id="userName" class="form-control" aria-label="Full Name"
                            pattern="[A-Za-z\s]+" required="">
                        <div class="invalid-feedback fs-5">
                            Use a format that matches the one requested. ( a-zA-Z )
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="email" class="fw-bold form-label fs-5">E-mail *</label>
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text text-white" id="basic-addon1">@</span>
                            <input type="email" name="email" id="email" class="form-control" aria-label="Email" required="">
                            <div class="invalid-feedback fs-5">
                                Use a format that matches the one requested. ( asd@ad.asd )
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-12 col-md-12">
                            <label for="Motive" class="fw-bold form-label fs-5">Motive *</label>
                            <select name="motive" id="Motive" name="motive" class="form-select" aria-label="Motive" required>
                                <option value="Feedback">Feedback</option>
                                <option value="Support">Support</option>
                                <option value="Report">Report</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="description" class="form-label fw-bold fs-5">Motive Description *</label>
                        <textarea id="description" name="description" class="form-control" aria-label="Motive Description" maxlength="150"
                            required></textarea>
                        <div class="invalid-feedback fs-5">
                            You must fill out this section.
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-row flex-wrap">
                        <input type="reset" class="btn col-12 col-md-5 mx-auto my-2" value="RESET">
                        <input type="submit" class="btn col-12 col-md-5 mx-auto my-2" value="SEND" name="send">
                    </div>
                </div>
            </form>
        </div>
        <div class="info col-md-4 mt-4">
            <div class="column p-4 p-md-0">
                <div class="card mt-3 mb-3">
                    <h5 class="card-header text-white">Follow Us</h5>
                    <div class="c-body">
                        <p class="mx-4 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                class="bi bi-instagram" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                            </svg>
                            <span class="text-white mx-3 fw-semibold">@Book_light</span>
                        </p>
                        <p class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                class="bi bi-twitter-x" viewBox="0 0 16 16">
                                <path
                                    d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                            </svg>
                            <span class="text-white mx-3 fw-semibold">@Book_light</span>
                        </p>
                        <p class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                class="bi bi-facebook" viewBox="0 0 16 16">
                                <path
                                    d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                            </svg>
                            <span class="text-white mx-3 fw-semibold">@Book_light</span>
                        </p>
                    </div>
                </div>
                <div class="card my-3">
                    <h5 class="card-header text-white">Call Us</h5>
                    <div class="c-body">
                        <p class="mx-3 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                            <span class="mx-3 text-white fw-semibold">961 15 16 17</span>
                        </p>
                        <p class="mx-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                class="bi bi-phone" viewBox="0 0 16 16">
                                <path
                                    d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                            </svg>
                            <span class="mx-3 text-white fw-semibold">619 15 16 17</span>
                        </p>
                    </div>
                </div>
                <div class="card my-3">
                    <h5 class="card-header text-white">Contact Us</h5>
                    <div class="c-body">
                        <p class="ms-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                class="bi bi-envelope me-2" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                            </svg>
                            <span class="text-white fw-semibold">arfa.starlight@gmail.com</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--END MAIN-->
<?php $contenido = ob_get_clean() ?>

<?php include $menu ?>