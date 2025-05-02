<?php

require_once "MyDatabase.php";


$database= new MyDatabase();


$resultado=$database->query("SELECT * FROM pokemones");

$resultado = $database-> query("SELECT * FROM pokemones");



echo json_encode($resultado);



