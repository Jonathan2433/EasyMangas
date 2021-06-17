<?php
require_once(__DIR__ . './../models/User.php');
require_once(__DIR__ . './../models/Users.php');


if (isset($_POST['submit'])) {
    $uppercase = preg_match('@[A-Z]@', $_POST['password']);
    $lowercase = preg_match('@[a-z]@', $_POST['password']);
    $number    = preg_match('@[0-9]@', $_POST['password']);
    //CHECK IF PASSWORD IS STRONG
    if (!$uppercase || !$lowercase || !$number || strlen($_POST['password']) < 8) {
        $msg = 'Password to easy, please use a minimum of : 1 Uppercase character, 1 Lowercase character, 1 number and a password length of 8 minimum !';
        echo $msg;
        //////////////add reroot and msg///////////////////
        header('Location: subscribe?msg=' . $msg);
        exit;
    } else {
        //check if MAIL is valid
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            //stock data from form
            $pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
            $mail = htmlentities($_POST['mail'], ENT_QUOTES);
            $password = htmlentities($_POST['password'], ENT_QUOTES);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $role = $_POST['role'];
            //create new object Users with data from form parameters
            $user = new User($pseudo, $mail, $password, $role);
            //function to check if email or pseudo dosn't exist in bdd
            $checkUser = $user ->checkUser($mail, $pseudo);

            // create user only if check user dosnt return result from bdd
            if ($checkUser === true) {
                $createUser = $user->createUser();
                if ($createUser === true) {
                    $users = new Users();
                    $users = $users->getUserFromLogin(htmlentities($_POST['mail'], ENT_QUOTES), htmlentities($_POST['password'], ENT_QUOTES));
                    if ($users == false) {
                        @session_start();
                        $_SESSION['msg'] = 'Login failed, please check your connection settings !';
                        header('Location: login');
                        exit;
                    } else {
                        @session_start();
                        $_SESSION['user'] = $users;
                        header('Location: index');
                        exit;
                    }
                } else {
                    @session_start();
                    $_SESSION['msg'] = 'Subscribe failed ! Please try again, if the problem persist, contact us.';
                    header('Location: subscribe');
                    exit;
                }
            }  else {
                @session_start();
                $_SESSION['msg'] = 'Subscribe failed, mail already exist !';
                header('Location: subscribe');
                exit;        
            }
        } else {
            @session_start();
            $_SESSION['msg'] = 'Subscribe failed, this email is not valid !';
            header('Location: subscribe');
            exit;        
    }
    }
}
