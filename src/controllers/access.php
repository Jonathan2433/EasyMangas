<?php
/**
 * Le but de cette page est de vérifier si un utilisateur est connecté pour les pages
 * qui ont en besoin.
 * Si une page demande une connection et que l'utilisateur ne l'est pas, alors redirection
 * vers login.phtml
 *  
 * Récupération du fichier php en cours
 * pour cela nous utiliserons la variable $_SERVER qui contient toutes les informations serveur
 * A l'index PHP_SELF, nous aurons l'url sans le host et sans les paramètres $_GET
 */
if (isset($_SERVER['REDIRECT_URL'])) {
    $phpSelf = $_SERVER['REDIRECT_URL'];
} else {
    $phpSelf = $_SERVER['REQUEST_URI'];
}

var_dump($phpSelf);
//phpself = /easymanga/index
/**
 * Afin de récupérer le nom du fichier nous utilisons basename pour remonter la composante 
 * finale du chemin
 * 
 * $currentPage devrait avoir pour valeur le nom de mon ficher php
 */
$currentPage = basename($phpSelf);
//currentPage = index
/** 
 * Déclarer un tableau qui va contenir l'ensemble des pages demandant une connexion
 * sans faire de distinction entre les php / php
 */
$tabPageAdmin = [
    'manga-administration' => 50,
    'manga-edit' => 50,
    'new-manga' => 50,
    'gestion-user' => 100,
    'user-administration' => 100,
    'user-edit' => 100,
    'subscribe' => 0,
    'library-user' => 10
];
/**
 * chercher l'index du nom de la page dans notre tableau
 * Si non présent alors false est retourné.
 */
$res = isset($tabPageAdmin[$currentPage]);
/**
 * Si array_serach retourne autre chose que false (c-a-d un index) 
 * Et que ma $_SESSION n'a pas d'index 'utilisteur'
 * Alors ce voudrait dire que je veux acceder à une page demandant une connexion sans être
 * connecté.
 * 
 * Dans ce cas là, je redirige vers login.php
 */
if ($res === true && (!isset($_SESSION['user']) || $_SESSION['user']['poid'] < $tabPageAdmin[$currentPage])) {
    $msg = "You don't have permissions to acces at this page please Log admin user !";
    header('Location: login?msg=' . $msg);
    exit;
}
