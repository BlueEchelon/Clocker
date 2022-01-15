<?php
    $dsn = "mysql:dbname=id17710422_clocker;host=localhost";
    $dbuser = "id17710422_clock";
    $dbpassword = "b8PGP&fbvO}TXLlS";

    try{
        $pdo  = new PDO($dsn, $dbuser, $dbpassword);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}