<?php
include 'header.php';
include 'encontrar_pokemon.php';
?>



    <main class="flex-grow-1">


    <div class="container d-flex justify-content-center mt-5">
        <form class="d-flex" style="width: 100%; max-width: 900px;" method="post" action="pagina_principal.php"">
            <div class="input-group" >
                <input class="form-control rounded-start-pill" type="text" name="nombrePokemon"
                       placeholder="Ingrese el nombre, tipo o número de pokémon">
                <button class="btn text-white rounded-end-pill" type="submit" style="background-color: #20c997;">
                    ¿Quién es este Pokémon?
                </button>
            </div>
        </form>
    </div>

        <div>
            <?php
            encontrarPokemon();
            ?>
        </div>



    </main>


<?php
include 'footer.php';
