<?php

include_once "MyDatabase.php";


$database= new MyDatabase();

$resultado=$database->query("SELECT * FROM pokemon");

echo json_encode($resultado);



