<?php

//récupération du parametre
$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

//execution de la requete
$sql = "DELETE FROM matieres WHERE matiere_id=?";
$connexion = getPDO();
$statement = $connexion->prepare($sql);
$statement->execute([$id]);

//Redirection vers la page des matieres
header("location:index.php?controller=matieres");