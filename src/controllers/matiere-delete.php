<?php

//récupération du parametre
$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

//execution de la requete
try {
    $sql = "DELETE FROM matieres WHERE matiere_id=?";
    $connexion = getPDO();
    $statement = $connexion->prepare($sql);
    $statement->execute([$id]);

} catch(PDOException $e) {
    $_SESSION["flash"]= "Impossible de supprimer cette matière";

}
//Redirection vers la page des matieres
header("location:index.php?controller=matieres");