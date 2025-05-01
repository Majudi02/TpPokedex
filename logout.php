<?php
session_start();
session_unset();
session_destroy();
header('Location: pagina_principal.php');
exit();
?>
