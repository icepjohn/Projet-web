<?php
//Démarrage de la session
session_start();

//Définition du dossier racine du projet
//(ici le dossier proje-web)
define("ROOT_PATH", dirname(__DIR__));

//inclusion du fichier d'autochargement de composer
require ROOT_PATH.'/vendor/autoload.php';

//Inclusion des dépendances du projet
require ROOT_PATH.'/src/framework/mvc.php';
require ROOT_PATH.'/src/config/config.php';

//Enregistrement des fonctions d'autochargement des classes
//spl_autoload_register("autoLoader");

//Instanciation de klogger
$logger = new Katzgrau\KLogger\Logger(ROOT_PATH."/logs");

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

//gestion de l'utilisateur avec la POO
$user=getUser();
$role=$user->getRole();


//var_dump($user);

//Si on tente d'accèder à une page sécurisée sans s'être identifié au
//préalable alors la route est modifiée pour afficher le formulaire de login
if (array_key_exists($controllerName, $securedRoutes)
    && $role != $securedRoutes[$controllerName]
) {
    $_SESSION["flash"] = "Vous n'avez pas les droits pour accéder à cette page, veuillez vous identifier";
    header("location:index.php?controller=login");
    exit;
}

//Définition du chemin du contrôleur
$controllerPath = ROOT_PATH.'/src/controllers/'. $controllerName.'.php';

//Test de l'existence du contrôleur
if(! file_exists($controllerPath)){
    //Envoie vers le fichier erreur
    $controllerPath = ROOT_PATH.'/src/controllers/erreur.php';
}

$logger->info("lancement de l'application");

//Exécution du contrôleur
require $controllerPath;