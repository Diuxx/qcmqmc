<?php
	// connection à la base de données
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=qcmqmc', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_FOUND_ROWS => true));
	} catch(Exception $e) {
		// echo 'Echec de la connection à la base de données';
		echo 'Erreur : ' . $e->getMessage() . '<br/>';
		exit();
	}
?>