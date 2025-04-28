<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "MyDatabase.php";


$database= new MyDatabase();

<<<<<<< HEAD
$resultado=$database->query("SELECT * FROM pokemones");
=======
$resultado = $database-> query("SELECT * FROM pokemones");
>>>>>>> 0677cdabc2b5f11c28613d2967cf608918746239


echo json_encode($resultado);



