<?php
//Requete pour recuperer toutes les lignes de la table matieres
$connexion=getPDO();
$sql="SELECT * FROM matieres";
$rs = $connexion->query($sql);
$listeMatieres = $rs->fetchALL(PDO::FETCH_ASSOC);


//affichage de la vue
renderView('matieres',['listeMatieres' => $listeMatieres]);