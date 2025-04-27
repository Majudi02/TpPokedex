<?php
include 'header.php';
?>



    <main class="flex-grow-1">


        <div class="container d-flex justify-content-center mt-5">
            <form class="d-flex" style="width: 100%; max-width: 900px;">
                <div class="input-group" >
                    <input class="form-control rounded-start-pill" type="text"
                           placeholder="Ingrese el nombre, tipo o número de pokémon">
                    <button class="btn text-white rounded-end-pill" type="submit" style="background-color: #20c997;">
                        ¿Quién es este Pokémon?
                    </button>
                </div>
            </form>
        </div>

        <div class="container mt-5">
            <div class="list-group">
                <?php
                include 'MyDatabase.php';

                $db = new MyDatabase();
                $tablaPokemones = $db->query("SELECT * FROM pokemones");
                $pokemones = json_encode($tablaPokemones);

                foreach ($tablaPokemones as $pokemon) {
                    echo "<p class='list-group-item'>".$pokemon['nombre']."</p>";
                }


                ?>

            </div>
        </div>

    
    </main>


<?php
include 'footer.php';
