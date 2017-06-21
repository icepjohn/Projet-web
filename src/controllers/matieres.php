<?php
//Requete pour recuperer toutes les lignes de la table matieres
$connexion=getPDO();
$sql="SELECT * FROM matieres";
$rs = $connexion->query($sql);
$listeMatieres = $rs->fetchALL(PDO::FETCH_ASSOC);


//affichage de la vue
renderView('matieres',['listeMatieres' => $listeMatieres]);


    //Redirection pour éviter de reposter les données
    header("location:index.php?controller=matieres");
