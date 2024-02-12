<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booklight</title>
  <!--FAVICON-->
  <link rel="icon" type="image/jpg" href="../web/img/logo/favicon.png">
  <!--STYLES-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../web/css/style.css">
  <!--FONT-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
  <!--GRAPHS-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <!--SIGN IN MODAL-->
  <div class="modal fade" id="signInModal" aria-hidden="true" aria-labelledby="signInModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold" id="signInModalLabel">Sign In</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!--Sign in form-->
          <form class="row g-3 needs-validation px-3" action="index.php?ctl=inicioSesion" method="POST" novalidate>
              <label for="validationCustomSignInEmail" class="form-label d-none"></label>
              <input type="email" name="email" class="form-control" id="validationCustomSignInEmail" placeholder="Email" required>
              <div class="invalid-feedback">
                Please input a valid email.
              </div>
              <label for="validationCustomSignInPass" class="form-label d-none"></label>
              <input type="password" name="password" class="form-control" id="validationCustomSignInPass" placeholder="Password"
                required>
              <div class="invalid-feedback">
                Please input a valid password.
              </div>
            <input value="Sign In" name="bInicioSesion" class="w-100 mb-2 btn btn-lg rounded-3" type="submit">
          </form>
          <a href="#" class="d-flex justify-content-end" id="recover">Forgot your password?</a>
          <form class="row g-3 needs-validation px-3 d-none mt-2" id="recover-form" action="index.php?ctl=recuperar" method="POST" novalidate>
            <input type="email" name="email" class="form-control" id="validationCustomRecoverPassword" placeholder="Email" aria-label="Email" aria-describedby="bRecover" required>
            <div class="invalid-feedback">
              Please input a valid email.
            </div>
            <div class="invalid-recovery d-none text-danger">
              Couldn't find email.
            </div>
            <input value="Recover" name="bRecover" class="w-100 mb-2 btn btn-lg rounded-3" type="submit">
          </form>
          <!--End sign in form-->
        </div>
        <div class="modal-footer">
          <small>Don't have an account?</small>
          <button class="btn fw-bold" data-bs-target="#signUpModal" data-bs-toggle="modal">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
  <!--END SIGN IN MODAL-->
  <!--SIGN UP MODAL-->
  <div class="modal fade" id="signUpModal" aria-hidden="true" aria-labelledby="signUpModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold" id="signUpModalLabel">Sign Up</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!--Sign up form-->
          <form id="signupForm" class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data" action="index.php?ctl=registro">
            <div class="col-md-6">
              <label for="validationCustomUsername" class="form-label">User name *</label>
              <input type="text" class="form-control" id="validationCustomUsername" name="username" required>
              <div class="invalid-username d-none text-danger">
                Username already exists!
              </div>
            </div>
            <div class="col-md-6">
              <label for="validationCustomEmail" class="form-label">Email *</label>
              <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="email" class="form-control" id="validationCustomEmail" name="email" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                  Please provide a valid email.
                </div>
              </div>
              <div class="invalid-email d-none text-danger">
                Email already exists!
              </div>
            </div>
            <div class="col-md-6">
              <label for="validationCustomPassword" class="form-label">Password *</label>
              <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend2">*</span>
                <input type="password" class="form-control" id="validationCustomPassword" name="password"
                  aria-describedby="inputGroupPrepend2"
                  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.]){8,}$" required>
                <div class="invalid-feedback">
                  Please provide a password at least 8 characters long, with a minimum of one letter, number and
                  symbol (?!*%#).
                </div>
              </div>
            </div>
            <div id="Supporting-file" class="mb-md-0 col-md-6">
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
              <label for="image" class="d-none d-sm-block mb-2">Profile image</label>
              <input type="file" id="image" name="image" aria-label="Profile image"
                class="form-control d-none d-sm-block mb-3">
            </div>
            <div class="form-group mt-0">
              <label for="About" class=" form-label">About me *</label>
              <textarea class="form-control" id="About" name="about" aria-label="About" maxlength="150" required></textarea>
              <div class="invalid-feedback">
                Use a format that matches the one requested. (All types of characters, maximum 150)
              </div>
            </div>
            <div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="newsletter" name="newsletter">
                <label class="form-check-label" for="invalidCheck">
                  Suscribe to our newsletter
                </label>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn" type="reset">Reset</button>
              <input type="submit" id="bRegistro" name="bRegistro" value="Create an account" class="btn">
            </div>
          </form>
          <!--End sign up form-->
        </div>
        <div class="modal-footer">
          <small>Have an account?</small>
          <button class="btn" data-bs-target="#signInModal" data-bs-toggle="modal">Sign In</button>
        </div>
      </div>
    </div>
  </div>
  <!--END SIGN UP MODAL-->
  <header>
    <nav class="navbar navbar-expand-sm ">
      <div class="container-fluid">
        <a class="" href="index.php?ctl=inicio">
          <img id="logo-l" class="p-2 img-fluid d-none d-sm-inline " src="../web/img/logo/logo_l.png" alt="Logo">
          <img id="logo-s" class="p-2 img-fluid d-sm-none " src="../web/img/logo/logo_s.png" alt="Logo">
        </a>
        <div class="collapse navbar-collapse pt-3 ms-md-5" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto ">
            <li class="nav-item">
              <a class="nav-link active text-white " aria-current="page" href="index.php?ctl=inicio">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white " href="index.php?ctl=browse">Browse</a>
            </li>
          </ul>
          <div class="me-4 mb-2 ">
            <form class="d-flex">
              <a id="profile-icon" href="#" class="text-decoration-none " data-bs-toggle="modal" data-bs-target="#signInModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-person-fill"
                  viewBox="0 0 16 16">
                  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                </svg>
              </a>
            </form>
          </div>
        </div>
        <!--Offcanvas burger nav-->
        <div class="d-inline d-sm-none">
          <div class="d-flex">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-list"
              viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
          </button>
          </div>
          <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <!--Offcanvas header-->
            <div class="offcanvas-header flex-column">
              <button type="button" class="btn-close btn-close-white align-self-end py-2" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
              <a class="blog-header-logo text-body-emphasis text-decoration-none" href="index.php?ctl=inicio"><img
                  src="../web/img/logo/logo_l.png" alt="Logo" id="logo-nav" class="img-fluid offcanvas-title"></a>
            </div>
            <!--End offcanvas header-->
            <!--Offcanvas body-->
            <div class="offcanvas-body py-0">
              <ul class="navbar-nav justify-content-evenly flex-grow-1 text-center fs-5 fw-semibold h-100">
                <li class="nav-item m-0">
                  <a class="nav-link fs-3" href="index.php?ctl=inicio">Home</a>
                </li>
                <li class="nav-item m-0">
                  <a class="nav-link fs-3" href="index.php?ctl=browse">Browse</a>
                </li>
                <li class="nav-item m-0">
                  <a class="nav-link fs-3" href="index.php?ctl=contacto">Contact</a>
                </li>
                <li class="nav-item m-0">
                  <a class="nav-link fs-3" href="index.php?ctl=about">About</a>
                </li>
              </ul>
            </div>
            <!--End offcanvas body-->
            <!--Offcanvas footer-->
            <div class="offcanvas-footer d-flex justify-content-around py-4 text-white fw-semibold fs-5 text-center">
              <button class="nav-link link-light" data-bs-target="#signInModal" data-bs-toggle="modal">Sign In</button>
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-person-fill"
                viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
              </svg>
              <button class="nav-link link-light" data-bs-target="#signUpModal" data-bs-toggle="modal">Sign Up</button>
            </div>
            <!--End offcanvas footer-->
          </div>
          <!--End offcanvas burger nav-->
        </div>
      </div>
    </nav>
  </header>

  <!--MAIN-->
  <div id="contenido">
    <?php echo $contenido ?>
  </div>
  <!--END MAIN-->

  <!--FOOTER-->
  <footer class="py-3 text-white">
    <div class="py-3 container">
      <div class="row">
        <h5 class="d-none d-sm-block order-2 order-sm-1 col-6 col-sm-3 col-md-4 text-center"><a href="index.php?ctl=about" class="nav-link px-2 link-light">About</a></h5>
        <h5 class="d-none d-sm-block order-2 order-sm-1 col-6 col-sm-3 col-md-4 text-center"><a href="index.php?ctl=contacto" class="nav-link px-2 link-light">Contact</a></h5>
        <!--NEWSLETTER FORM-->
        <form class="order-1 col-sm-6 col-md-4" action="index.php?ctl=suscribe" method="POST">
          <h5>Subscribe to our newsletter</h5>
          <label for="newsletter" class="visually-hidden">Email</label>
          <div class="input-group mb-3">
            <input id="newsletter" type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="button-newsletter" name="mail">
            <input type="submit" class="btn" id="button-newsletter" value="Subscribe" name="bSubscribe">
          </div>
        </form>
        <!--END NEWSLETTER FORM-->
      </div>
      <hr class="border-white">
      <div class="row">
        <!--SOCIAL MEDIA LINKS-->
        <ul class="nav col-12 justify-content-center list-unstyled d-flex align-items-center">
          <li class="ms-3">
            <a class="text-body-secondary" href="https://www.facebook.com">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
              </svg>
            </a>
          </li>
          <li class="ms-3">
            <a class="text-body-secondary" href="https://www.instagram.com">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
              </svg>
            </a>
          </li>
          <li class="ms-3">
            <a class="text-body-secondary" href="https://www.twitter.com">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
              </svg>
            </a>
          </li>
        </ul>
        <!--END SOCIAL MEDIA LINKS-->
        <p class="col-12 text-white small text-center mt-3 mb-0">&copy; 2024 Starlight Syntax - All rights reserved.</p>
      </div>
    </div>
  </footer>
  <!--END FOOTER-->
</body>
<!--BOOTSTRAP JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="../web/js/layout.js"></script>
<script src="../web/js/<?php echo strip_tags($_GET['ctl'])?>.js"></script>
</html>