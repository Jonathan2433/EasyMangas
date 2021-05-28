<?php

require_once(__ROOT__ . '/src/models/User.php');
require_once(__ROOT__ . '/src/views/subscribe.phtml');


class Controller {
    public static function display($get)
    {
        if (! isset($get['r'])) {
            $action = "index";
        } else {
            $action = $get['r'];
        }
        switch ($action) {
            case "index" : 
                header('Location: src/views/index.phtml');
                exit;
            default:
            header('HTTP/1.0 404 Not Found');
            break;
        }
    }
    // protected static function subscribe() {
    //     // //on utilise le model Voiture
    //     // $mesVoitures = Voiture::listerVoitures();
    //     // //on passe la main à la view
    //     // ViewListeVoiture::afficheHtml($mesVoitures);
    // }
}

