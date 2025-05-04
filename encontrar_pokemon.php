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
    $pokemonesBuscados = $database->query("SELECT * FROM pokemones JOIN tipo ON pokemones.tipo_id= tipo.id  WHERE tipo ='$tipo'");
    return $pokemonesBuscados;
}