<?php 
require_once(__DIR__ . './../models/User.php');


if (isset($_POST['submit'])) {
    $uppercase = preg_match('@[A-Z]@', $_POST['password']);
    $lowercase = preg_match('@[a-z]@', $_POST['password']);
    $number    = preg_match('@[0-9]@', $_POST['password']);
    //CHECK IF PASSWORD IS STRONG
    if (!$uppercase || !$lowercase || !$number || strlen($_POST['password']) < 8) {
        $msg = 'Password to easy, please use a minimum of : 1 Uppercase character, 1 Lowercase character, 1 number and a password length of 8 minimum!';
        echo $msg;
        //////////////add reroot and msg///////////////////
        // header('Location: ./../../../subscribe.php?msg=' . $msg);
        // exit;
    } else {
        //check if MAIL is valid
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            //stock data from form
            $idUser = htmlentities($_POST['idUser'], ENT_QUOTES);
            $pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
            $mail = htmlentities($_POST['mail'], ENT_QUOTES);
            $password = htmlentities($_POST['password'], ENT_QUOTES);
            $role = $_POST['role'];
            //create new object Users with data from form parameters
            $user = new User($pseudo, $mail, $password, $role);
            $checkUser = $user ->checkUser($mail, $pseudo);

            // create user only if check user dosnt return result from bdd
            if ($checkUser === true) {
                $editUser = $user->editUser($idUser);
                if ($editUser === true) {
                    echo('user edited !');
                } else {
                    echo('something wrong happend ! please contact an admin.');
                }
            }  else {
                echo $checkUser;
            }
        } else {
            echo ('mail not valid');
        }
    }
}
