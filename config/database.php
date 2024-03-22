<?php

class Database{


    private $hostname = "localhost";
    private $database = "nomina_pro";
    private $username = "root";
    private $password = "";
    private $chasrset = "utf8";

    function conectar()
    {
        try{
        $conexion = "mysql:host=". $this->hostname . "; dbname=" . $this->database . "; charset=" . $this->chasrset ;
        $option = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($conexion, $this->username, $this->password, $option);

        return $pdo;
    }
    catch(PDOException $e)
    {
        echo 'Error de Conexion: ' . $e->getMessage();
        exit;
    }

    
    }

    
}

$link = mysqli_connect("localhost", "root", "", "nomina_pro");
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
