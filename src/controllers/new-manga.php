<?php
require_once(__DIR__ . './../models/Manga.php');


if (isset($_POST['submit'])) {
    switch ($_FILES['img']['error']) {
        case 0:
        case 4:
            if ($_FILES['img']['name'] == '') {
                $img = 'default.jpg';
            } else {

                
                $img = $_FILES['img']['name'];
            }
            $ext = array('png', 'jpg', 'jpeg', 'gif');
            if ($_FILES['img']['size'] > 1000000) {
                @session_start();
                $_SESSION['msg'] = 'Max size files is limited at 1Mo';
                header('Location: new-manga');
                exit;
            } elseif (!in_array(strtolower(pathinfo($img, PATHINFO_EXTENSION)), $ext)) { // on récupére l'extension de fichier et on la compare au tableau créé en haut de page
                @session_start();
                $_SESSION['msg'] = 'This files i\'s not a picture, please select a picture like : .png, .jpg, .jpeg or .gif';
                header('Location: new-manga');
                exit;
            }

            //stock data from form
            $mangaValues = [
                'name' => htmlentities($_POST['name'], ENT_QUOTES),
                'author' => htmlentities($_POST['author'], ENT_QUOTES),
                'editor' => htmlentities($_POST['editor'], ENT_QUOTES),
                'tomes' => htmlentities($_POST['tomes'], ENT_QUOTES),
                'resume' => htmlentities($_POST['resume'], ENT_QUOTES),
                'img' => $img
            ];
            //create new object Manga with data from form parameters
            $manga = new Manga($mangaValues['name'], $mangaValues['author'], $mangaValues['editor'], $mangaValues['tomes'], $mangaValues['img'], $mangaValues['resume']);
            //function to check if Manga or exist in bdd
            $checkManga = $manga->checkManga();

            // create manga only if checkmanga dosnt return result from bdd
            if ($checkManga === true) {
                // move the img file in good folder
                if ($_FILES['img']['name'] != '') {
                    move_uploaded_file($_FILES['img']['tmp_name'], './../public/img/dist/' . $mangaValues['img']);
                }
                // create manga in bdd
                $createManga = $manga->createManga();
                if ($createManga === true) {
                    @session_start();
                    $_SESSION['msg'] = 'Manga added !';
                    header('Location: manga-administration');
                    exit;
                } else {
                    @session_start();
                    $_SESSION['msg'] = 'We fail to add this manga ! Please try again, if the problem persist contact us.';
                    header('Location: new-manga
                    ');
                    exit;
                }
            } else {
                @session_start();
                $_SESSION['msg'] = 'Manga already exist !';
                header('Location: new-manga');
                exit;
            }
            break;
        case 1:
            @session_start();
            $_SESSION['msg'] = 'Max size files is limited at 1Mo';
            header('Location: new-manga');
            exit;
            break;
        case 2:
            @session_start();
            $_SESSION['msg'] = 'Max size files is limited at 1Mo';
            header('Location: new-manga');
            exit;
            break;
        case 3:
        case 6:
        case 7:
        case 8:
            @session_start();
            $_SESSION['msg'] = "Manga add dosn't work, please try again ! if this problem continue please contact an administrator";
            header('Location: new-manga');
            exit;
            break;
        default:
            @session_start();
            $_SESSION['msg'] = "Manga add dosn't work, please try again ! if this problem continue please contact an administrator";
            header('Location: new-manga');
            exit;
            break;
    }
}
