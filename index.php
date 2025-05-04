<?php
session_start();


if (isset($_SESSION['usuario'])) {
    header('Location: inicio_logueado.php');
    exit();

} else {
    header('Location: pagina_principal.php');
    exit();
}