<?php ob_start();
    if (isset($params['mensaje'])) {
?>
    <span class="mt-5">
    <?php
        echo $params['mensaje'];
        echo "</span>";
        }
    ?>

    <div class="container text-center p-4 vh-100">
            <h3>ERROR</h3>
    </div>

<?php $contenido = ob_get_clean() ?>

<?php include $menu ?>