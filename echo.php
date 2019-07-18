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

$sql = "SELECT count(value) as value FROM sondage GROUP by value";
$query = $pdo->query($sql);
$data = $query->fetchAll();

$sum =$data[0]['value']+$data[1]['value'];
echo "Il y a ".$sum." personnes qui participent le sondage";
echo '<br>';
echo "Il y a ".$data[0]['value']." personnes qui trouvent facile le site";
echo '<br>';
echo "Il y a ".$data[1]['value']." personnes qui trouvent difficile le site";

$p = $data[0]['value'] / ($data[0]['value'] + $data[1]['value'])*100;
$p = round($p,2);
echo '<br>';
echo $p."% de personnes qui trouve faciele le site";