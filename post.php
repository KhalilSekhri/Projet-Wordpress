<?php
define("DBDRIVER", "mysql");
define("DBHOST", "localhost");
define("DBNAME", "mvcdocker2");
define("DBUSER", "root");
define("DBPWD", "Chao5995139");
define('URL',"http://localhost:8080/");

try{
    $pdo = new PDO(DBDRIVER.":host=".DBHOST.";dbname=".DBNAME,DBUSER,DBPWD);
}catch(Exception $e){
    die("Erreur SQL : ".$e->getMessage());
}

$pdo->exec("INSERT INTO `sondage`(`value`) VALUES (".$_POST['option'].");");

header("Location: ".URL);