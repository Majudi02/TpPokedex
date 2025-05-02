<?php

function encontrarPokemon($database){
    if (!isset($_POST["pokemonBuscado"])) return null;
    $textoABuscar = strtolower($_POST["pokemonBuscado"]);

    if (is_numeric($textoABuscar)) {
        return buscarPokemonPorNumero($database, $textoABuscar);
    }
    if ($textoABuscar == "agua" || $textoABuscar == "electrico" || $textoABuscar == "planta" || $textoABuscar == "fuego") {
        return buscarPokemonPorTipo($database, $textoABuscar);
    }

    return buscarPokemonPorNombre($database, $textoABuscar);
}

function buscarPokemonPorNumero($database, $numeroABuscar)
{
    $resultadoPokemonDb = $database->query("SELECT * FROM pokemones WHERE id = '$numeroABuscar'");
    if (empty($resultadoPokemonDb)) {
        return false;
    } else {
        return $resultadoPokemonDb;
    }
}
function buscarPokemonPorTipo($database, $tipo){
    $resultadoTipoDb = $database->query("SELECT * FROM tipo WHERE tipo ='$tipo'");
    if (empty($resultadoTipoDb)) return false;

    $tipoId = $resultadoTipoDb[0]["id"];

    $pokemonesBuscados = $database->query("SELECT * FROM pokemones WHERE tipo_id ='$tipoId'");

    return $pokemonesBuscados;
}
function buscarPokemonPorNombre($database, $nombrePokemon)
{
    $resultadoPokemonDb = $database->query("SELECT * FROM pokemones WHERE nombre = '$nombrePokemon'");

    if (empty($resultadoPokemonDb)) {
        return false;
    } else {
        return $resultadoPokemonDb;
    }
}