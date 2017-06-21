<?php
$connexion = getPDO();
//Recuperation du parametre Id
$id = filter_input (INPUT_GET, 'id',FILTER_VALIDATE_INT);

//Si id n'est pas null alors requete pour recuperer le libelle de la matiere
$matiere = "";
$pageTitle = "Nouvelle matière";
if($id !=null){
    $sql = "SELECT matiere FROM matieres WHERE matiere_id=?";
    $stm = $connexion->prepare($sql);
    $stm->execute([$id]);
    $rs = $stm->fetch(PDO::FETCH_ASSOC);
    $matiere = $rs["matiere"];
    $pageTitle = "Modification d'une matière";
}

//Traitement du formulaire
$isSubmitted = filter_has_var (INPUT_POST, 'submit');
if($isSubmitted){
    //Recuperation des données
    $matiere = filter_input(INPUT_POST,'matiere', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);

    //Validation des données saisies
    $valid = !(empty($matiere));

    //Valider que l'insertion ou la mise a jour ne genere pas de doublon
    $sql = "SELECT matiere FROM matieres WHERE matiere=:matiere";
    $stm = $connexion->prepare($sql);
    $stm->execute(["matiere"=>$matiere]);
    $nbMatieres=count($stm->fetchAll(PDO::FETCH_ASSOC));

    $valid = $valid & ($nbMatieres == 0);

    //test de la validation du TOKEN
    $token = filter_input(INPUT_POST,'token',FILTER_DEFAULT);
    $valid = $valid & ($token == $_SESSION["token"]);

    //En fonction de la valuer de $id on fait in insert ou un update
    try {
        if($valid){
            //Parametre commun au deux requetes
        $params =[];
        $params["matiere"] = $matiere;

        //Definition de la requete a executer et ajour du parametre id
        //Dans le cas d'une mise a jour
        if($id == null){
            $sql = "INSERT INTO matieres (matiere) VALUES (:matiere)";
            $_SESSION["flash"] = 'Votre nouvelle matière est enregistrée dans la base';
        }else{
        $sql = "UPDATE matieres SET matiere =:matiere WHERE matiere_id=:id";
        $params["id"]=$id;
         $_SESSION["flash"] = 'Votre modification est enregistrée dans la base';
        }

        //Preparation et execution de la requete
        $stm = $connexion->prepare($sql);
        $stm->execute($params);

        //redirection vers la listes des matieres
        header("location:index.php?controller=matieres");
        }else{

            $_SESSION["flash"]="Votre saisie est incorecte";
        }
                 
    }catch(PDOException $e){
        $_SESSION["flash"] = "Impossible d'éxecuter la requête";

    }
}

//Generation d'un TOKEN de protection contre les attaques CSRF
//CSRF Cross Site Request Forgery
$token = uniqid();
$_SESSION["token"] =$token;

    renderView("matieres-formulaire",[
        "pageTitle"=> $pageTitle, 
        "matiere"=>$matiere,
        "id"=>$id,
        "token"=>$token
    ]);