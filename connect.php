<?php
    $dsn = "mysql:dbname=clocker_db;host=localhost";
    $dbuser = "root";
    $dbpassword = "";

    try{
        $pdo  = new PDO($dsn, $dbuser, $dbpassword);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
