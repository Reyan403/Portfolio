<?php

$host = "mysql-lyceestvincent.alwaysdata.net";
$user = "116313_rghazzaou";
$pass = "Jadoremanger777.";
$dbName = "lyceestvincent_rghazzaoui";

try {
	$connexion = new \PDO("mysql:host=$host;dbname=$dbName;charset=UTF8", $user, $pass);
} catch (\Exception $exception) {
	echo 'Erreur lors de la connexion à la base de données.<br>';
	echo $exception->getMessage();
	exit;
}
?>