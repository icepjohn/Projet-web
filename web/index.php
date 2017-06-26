<?php
//Démarrage de la session
session_start();

//Récupération du contrôleur
//avec gestion de la page de défaut
if(isset($_GET["controller"])){
    $controllerName = $_GET["controller"];
} else {
    $controllerName = "accueil";
}


//Sécurisation l'accès à l'administration
session_regenerate_id(true);

$securedRoutes = [
    'accueil-admin' => 'ADMIN',
    'accueil-formateur' => 'FORMATEUR',
    'accueil-stagiaire' => 'STAGIAIRE'


];
$role = isset($_SESSION["role"])?$_SESSION["role"]:"";

//Si on tente d'accèder à une page sécurisée sans s'être identifié au
//préalable alors la route est modifiée pour afficher le formulaire de login
if (array_key_exists($controllerName, $securedRoutes)
    && $role != $securedRoutes[$controllerName]
) {
    $_SESSION["flash"] = "Vous n'avez pas les droits pour accéder à cette page, veuillez vous identifier";
    header("location:index.php?controller=login");
    exit;
}


//Définition du dossier racine du projet 
//(ici le dossier proje-web)
define("ROOT_PATH", dirname(__DIR__));

//Inclusion des dépendances du projet
require ROOT_PATH.'/src/framework/mvc.php';
require ROOT_PATH.'/src/config/config.php';

//Définition du chemin du contrôleur
$controllerPath = ROOT_PATH.'/src/controllers/'. $controllerName.'.php';

//Test de l'existence du contrôleur
if(! file_exists($controllerPath)){
    //Envoie vers le fichier erreur
    $controllerPath = ROOT_PATH.'/src/controllers/erreur.php';
}

//Exécution du contrôleur
require $controllerPath;