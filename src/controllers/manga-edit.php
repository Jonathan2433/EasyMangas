<?php
    require_once(__DIR__ . './../models/Manga.php');
    require_once(__DIR__ . './../models/Mangas.php');

    $mangaPlaceholder = new Mangas($_GET['idManga']);
    $mangaPlaceholder = $mangaPlaceholder->detailManga($_GET['idManga']);
    $mangaPlaceholder = $mangaPlaceholder->fetch();

    function editManga($manga, $mangaValues)
    {
        $mangaPlaceholder = new Mangas($_GET['idManga']);
        $mangaPlaceholder = $mangaPlaceholder->detailManga($_GET['idManga']);
        $mangaPlaceholder = $mangaPlaceholder->fetch();

        $editManga = $manga->editManga($mangaValues['id']);

        if ($_FILES['img']['name'] != '') {
            move_uploaded_file($_FILES['img']['tmp_name'], './../public/img/dist/' . $_FILES['img']['name']);
            if ($mangaPlaceholder['img'] != 'default.jpg') {
                /**
                 * unlink permet de supprimer un fichier
                 * Nous supprimons l'ancienne image si ce n'est pas default.jpg
                 */
                unlink('./../public/img/dist/' . $mangaPlaceholder['img']);
            }
        }
        if ($editManga === true) {
            @session_start();
            $_SESSION['msg'] = 'Manga edited !';
            header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
            exit;
        } else {
            @session_start();
            $_SESSION['msg'] = 'We failed to edit this manga ! Please try again, if the problem persist contact us.';
            header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
            exit;
        }
    }

    if (isset($_POST['submit'])) {
        switch ($_FILES['img']['error']) {
            case 0:
            case 4:
                // control name of img 
                if ($_FILES['img']['name'] == '') {
                    $img = $mangaPlaceholder['img'];
                } else {
                    $img = $_FILES['img']['name'];
                }
                //stock data from form
                $mangaValues = [
                    'name' => htmlentities($_POST['name'], ENT_QUOTES),
                    'author' => htmlentities($_POST['author'], ENT_QUOTES),
                    'editor' => htmlentities($_POST['editor'], ENT_QUOTES),
                    'tomes' => htmlentities($_POST['tomes'], ENT_QUOTES),
                    'resume' => htmlentities($_POST['resume'], ENT_QUOTES),
                    'img' => $img,
                    'id' => $_POST['idManga'],
                ];
                $ext = array('png', 'jpg', 'jpeg', 'gif'); 
                
                if($_FILES['img']['size'] > 1000000) {
                    @session_start();
                    $_SESSION['msg'] = 'Max size files is limited at 1Mo';
                    header('Location: manga-edit?idManga=' . $_GET['idManga'] . '');
                    exit;
                } elseif(!in_array(strtolower(pathinfo($img, PATHINFO_EXTENSION)), $ext)) { // on récupére l'extension  de fichier et on la compare au tableau créé en haut de page
                    @session_start();
                    $_SESSION['msg'] = 'This files i\'s not a picture, please select a picture like : .png, .jpg, .jpeg or .gif';
                    header('Location: manga-edit?idManga=' . $_GET['idManga'] . '');
                    exit;
                }


                
                //create new object Mangas with data from form parameters
                $manga = new Manga($mangaValues['name'], $mangaValues['author'], $mangaValues['editor'], $mangaValues['tomes'], $mangaValues['img'], $mangaValues['resume']);

                if ($mangaValues['name'] != $mangaPlaceholder['name']) {
                    $checkManga = $manga->checkManga();
                    if ($checkManga === true) {
                        editManga($manga, $mangaValues);
                    } else {
                        @session_start();
                        $_SESSION['msg'] = 'Manga already exist !';
                        header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
                        exit;
                    }
                }
                editManga($manga, $mangaValues);
                break;
                case 1:
                    @session_start();
                    $_SESSION['msg'] = 'Max size files is limited at 1Mo';
                        header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
                    exit;
                    break;
                case 2:
                    @session_start();
                    $_SESSION['msg'] = 'Max size files is limited at 1Mo';
                        header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
                    exit;
                    break;
                case 3:
                case 6:
                case 7:
                case 8:
                    @session_start();
                    $_SESSION['msg'] = "Manga edit dosn't work, please try again ! if this problem continue please contact an administrator";
                        header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
                    exit;
                    break;
                default:
                    @session_start();
                    $_SESSION['msg'] = "Manga edit dosn't work, please try again ! if this problem continue please contact an administrator";
                        header('Location: manga-edit?idManga=' . $mangaValues['id'] . '');
                    exit;
                    break;
            }
    }