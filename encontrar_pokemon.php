<?php
include_once "MyDatabase.php";

function encontrarPokemon(){
    if (!isset($_POST["nombrePokemon"])) {
        return;
    }
    $pokemonBuscado = strtolower($_POST["nombrePokemon"]);

    $database = new MyDatabase();
    $listaDb = $database->query("SELECT * FROM pokemones");
    $tiposDb = $database->query("Select * from tipo");

    foreach ($listaDb as $pokemon) {
        if (strtolower($pokemon["nombre"]) === $pokemonBuscado) {
            echo "<h1>Nombre: {$pokemon['nombre']}</h1>";
            echo "<h1>Descripcion: {$pokemon['descripcion']}</h1>";

            foreach ($tiposDb as $tipo){
                if ($tipo['id'] == $pokemon['tipo_id']) {
                    echo "<h1>Tipo: {$tipo['tipo']}</h1>";
                    break;
                }
            }
            return;
        }
    }
    echo "<p>Pokémon no encontrado</p>";
    echo  json_encode($listaDb);
}
?>
