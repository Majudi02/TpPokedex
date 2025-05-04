<?php

function encontrarPokemon($database){
    if (!isset($_POST["pokemonBuscado"])) return null;
    $textoABuscar = strtolower($_POST["pokemonBuscado"]);

    if ($textoABuscar == "agua" || $textoABuscar == "electrico" || $textoABuscar == "planta" || $textoABuscar == "fuego") {
        return buscarPokemonPorTipo($database, $textoABuscar);
    }

    $resultadoPokemonDb = $database->query("SELECT * FROM pokemones WHERE nombre='$textoABuscar'OR id = '$textoABuscar'");

    if(empty($resultadoPokemonDb)) return false;

    return $resultadoPokemonDb;
}

function buscarPokemonPorTipo($database, $tipo){
    return $database->query("
        SELECT 
            pokemones.id,
            pokemones.nombre,
            pokemones.imagen AS imagen,
            pokemones.id_unico,
            pokemones.tipo_id
        FROM pokemones 
        JOIN tipo ON pokemones.tipo_id = tipo.id 
        WHERE tipo.tipo = '$tipo'
    ");
}