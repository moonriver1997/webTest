<?php
    define("SERVERNAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "Ekc2885-2557");
    define("DBNAME", "webTemplate");
    
    function connectionInit() {
        $connect = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
        $connect->query("SET NAMES 'utf8");
        
        if ($connect->connect_error){
            die("Connection failed: " .$connect->connect_error);
        }
        
        return $connect;
    }
?>