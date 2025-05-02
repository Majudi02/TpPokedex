<?php
session_start();


if(session_status() === PHP_SESSION_ACTIVE){

    header('Location: inicio_logueado.php');
} else {
    header('Location: pagina_principal.php');
}