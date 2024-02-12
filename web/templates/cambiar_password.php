<?php ob_start() ?>
    <main class="container mb-5 py-5 w-25" id="mainRecover">
        <form class="column mx-4 needs-validation rounded-3 m-5" method="post" action="index.php?ctl=cambiar_password&token=<?=$params['token']?>" novalidate>
            <h5 class="pt-3 ps-3 fw-bold">Recover your password</h5>
            <div class="p-3">
                <label for="editPassword" class="form-label">Password</label>
                <div class="has-validation">
                    <input type="password" class="form-control" id="editPassword" name="password"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.]){8,}$" required>
                    <div class="invalid-feedback">
                    Please provide a password at least 8 characters long, with a minimum of one letter, number and
                    symbol (?!*%#).
                </div>
                <hr>
                <div class="col-12 d-flex justify-content-between mt-3">
                    <button class="btn" type="reset">Reset</button>
                    <input class="btn" type="submit" value="Save Changes" name="bEditar">
                </div>
            </div>
        </form>
    </main>
<?php $contenido = ob_get_clean() ?>

<?php include $menu ?>