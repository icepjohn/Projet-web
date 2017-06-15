<?php

/**
@param string $view : Le nom de la vue
@param array $data : Un tableau des données passées à la vue
@return string Le code html de la vue
*/
function getTemplate(string $view, array $data = []){
    //mise en tampon du résultat de l'interprétation PHP 
    //N'envoie pas de réponse HTPP implicite 
    ob_start();

    //transformation du tableau associatif des données
    //en une suite de variables
    extract($data);

    //Inclusion de fichier de la vue dans le tampon
    require ROOT_PATH."/src/views/{$view}.php";
    //Récupération le contenu du tampon dans une variable
    $content = ob_get_clean();

    return $content;
}

/**
Affiche le résultat d'une vue décorée par un gabarit
@param string $view : Le nom de la vue
@param array $data : Un tableau associatif des données pasées à la vue
@param string $layout : Le gabarit qui décorera la vue
*/
function renderView(
    string $view, 
    array $data = [], 
    string $layout = "gabarit"){
        //Récupération du code html (interpolé) de la vue
        $viewContent = getTemplate($view, $data);

        //Ajout du rendu de la vue aux données passées au gabarit
        $data["content"] = $viewContent;

        //Application du gabarit
        $result = getTemplate($layout, $data);

        echo $result;

}