<?php

//Recuperation d'une connexion a la base de données
$connexion = getPDO();

$sql="SELECT * FROM personnes";
$resultat = $connexion->query($sql);

var_dump($resultat);

//var_dump($resultat->fetch(PDO::FETCH_ASSOC));
//var_dump($resultat->fetch(PDO::FETCH_ASSOC));

//Recuperation ligna par ligne
while( ($ligne = $resultat->fetch(PDO::FETCH_ASSOC))!== false){

    echo $ligne["prenom"]."".$ligne["nom"]."<br>";
}

//recuparation global
$resultat = $connexion->query($sql);
$donnees = $resultat->fetchall(PDO::FETCH_ASSOC);

$nbPersonnes = count($donnees);

//Supprimer les inscriptions de la personne dont l'id est 1
$sql = "DELETE FROM inscription_formation WHERE personne_id = 1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime inscriptions supprimées</p>";

//Supprimer les notes de la personne dont l'id est 1
$sql = "DELETE FROM notes WHERE personne_id = 1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime notes supprimées</p>";

//Supprimer les ventes de la personne dont l'id est 1
$sql = "DELETE FROM ventes WHERE vendeur_id = 1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime ventes supprimées</p>";

//Supprimer la personne dont l'ID est 1
$sql = "DELETE FROM personnes WHERE personne_id=1";

//Execution de la requete
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime personnes supprimées</p>";

//execution d'une procedure stockée
$sql = "CALL proc_insert_personne_pdo('Tesla','Nikola','1623-12-01')";
$connexion->exec($sql);

//Recuperation de l'identifiant de la personne crée
$id = $connexion->lastInsertId();
//Requete pour verifier l'insertion des données
$sql = "SELECT*FROM personnes WHERE personne_id=@id";
$resultat = $connexion->query($sql);
var_dump($resultat->fetch(PDO::FETCH_ASSOC));