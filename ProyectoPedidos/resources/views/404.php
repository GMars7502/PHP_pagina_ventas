<?php
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/header.php';

echo '<h1 class="title">Error 404</h1>';
echo '<p>La página solicitada no existe</p>';
echo '<a class="button btnYellow" href="javascript:history.back()">Volver atras</a>';

include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/footer.php';