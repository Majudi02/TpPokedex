<?php

function encontrarPokemon($database){
    if (!isset($_POST["pokemonBuscado"])) return null;
    $textoABuscar = strtolower($_POST["pokemonBuscado"]);
    $resultadoPokemonDb = $database->query("SELECT * FROM pokemones WHERE nombre LIKE'%$textoABuscar%'OR id LIKE '%$textoABuscar%'");

    $listaDePokemonesDb = buscarPokemonPorTipo($database, $textoABuscar);
    if (!empty($listaDePokemonesDb)) return $listaDePokemonesDb;

    return !empty($resultadoPokemonDb) ? $resultadoPokemonDb : false;
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
        WHERE tipo.tipo LIKE '%$tipo%'
        ");
}