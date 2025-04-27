<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "MyDatabase.php";


$database= new MyDatabase();

$resultado = $database-> query("SELECT * FROM pokemones");


echo json_encode($resultado);





