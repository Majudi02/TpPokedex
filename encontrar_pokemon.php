<?php
include_once "MyDatabase.php";
$database = new MyDatabase();

function encontrarPokemon($database){
    if (!isset($_POST["pokemonBuscado"])) {
        return null;
    }

    $pokemonBuscado = strtolower($_POST["pokemonBuscado"]);
    $listaDb = $database->query("SELECT * FROM pokemones");
    $tiposDb = $database->query("Select * from tipo");


    function buscarPokemonPorTipo($tipoBuscado, $database){

        $tiposDb = $database->query("Select * from tipo");
        $listaDb = $database->query("SELECT * FROM pokemones");
        foreach ($tiposDb as $tipo){
            if(strtolower($tipo['tipo']) === $tipoBuscado){
                foreach ($listaDb as $pokemon){
                    if ($pokemon['tipo_id'] === $tipo['id']) {
                        $resultado[]= $pokemon;
                    }
                }
            }
        }
        return $resultado;
    }

    function existeTipo($tipoBuscado, $database){

        $tiposDb = $database->query("Select * from tipo");
        foreach ($tiposDb as $tipo){

            if(strtolower($tipo['tipo']) === $tipoBuscado){
                return true;
            }
        }

    }

    foreach ($listaDb as $pokemon) {
        if (strtolower($pokemon["nombre"]) === $pokemonBuscado || strtolower($pokemon["id"]) === $pokemonBuscado) {

            foreach ($tiposDb as $tipo){
                if ($tipo['id'] == $pokemon['tipo_id']) {
                    $pokemon['tipo_id'] = $tipo['id'];
                    break;
                }
            }

            return $pokemon;
        } else if (existeTipo($pokemonBuscado, $database)) {
            return buscarPokemonPorTipo($pokemonBuscado, $database);
        }
    }


   return false;
}




