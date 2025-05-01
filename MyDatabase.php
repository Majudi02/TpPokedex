<?php

class MyDatabase{

    private $conection;

    public function __construct()
    {
        $config=parse_ini_file("config.ini");

        $this->conection = new Mysqli(
            $config["host"],
            $config["user"],
            $config["pass"],
            $config["db"]
        ) ;

        if ($this->conection->connect_error) {
            die("Conexión fallida: " . $this->conection->connect_error);
        }

        $this->conection->set_charset("utf8mb4");
    }

    public function __destruct(){
        $this->conection->close();
    }


    public function query($sql){
        $datos = $this-> conection->query($sql);
        return $datos->fetch_all(MYSQLI_ASSOC);
    }

    public function getConnection(): mysqli
    {
        return $this->conection;
    }

}
