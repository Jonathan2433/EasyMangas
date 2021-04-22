<?php
require_once(__DIR__ . './../models/Connect.php');

class Users extends Connect
{
    protected $pseudo;
    protected $mail;
    protected $password;

    public function __construct($pseudo, $mail, $password)
    {
        $this->_pseudo = $pseudo;
        $this->_mail = $mail;
        $this->_password = $password;
    }

    // public function checkUser()
    // {
    //     try {
    //         $pdo = $this::getPdo();
    //         $mail = $pdo->query("SELECT 
    //             mail 
    //         FROM
    //             users
    //         WHERE 
    //             mail = '$this->_mail'
    //         ");
    //         $pseudo = $pdo->query("SELECT 
    //             pseudo
    //         FROM 
    //             users
    //         WHERE
    //             mail = '$this->_pseudo'
    //         ");

    //         if ($mail->rowCount() >= 1) {
    //             return $msg = 'mail already register';
    //         } else if ($pseudo->rowCount() >= 1 ) { 
    //             return $msg = 'pseudo already register';
    //         } else {
    //             return true;
    //         }
    //     } catch (\PDOException $th) {
    //         return false;
    //     }
    // }
    public function createUser()
    {
        function checkUser($mail, $pseudo)
        {
            if ($mail->rowCount() >= 1) {
                //check if mail already exist in bdd
                return $msg = 'mail already register';
            } else if ($pseudo->rowCount() >= 1) {
                //check if pseudo already exist in bdd
                return $msg = 'pseudo already register';
            } else {
                //if user dn't exist in bdd we return bool true
                return true;
            }
        }
        //request for check email and pseudo in bdd
        try {
            $pdo = $this->getPdo();
            $mail = $pdo->query("SELECT 
                    mail 
                FROM
                    users
                WHERE 
                    mail = 'parent::_mail'
                ");
                $pseudo = $pdo->query("SELECT 
                    pseudo
                FROM 
                    users
                WHERE
                    mail = 'parent::_pseudo'
                ");
        } catch (\PDOException $th) {
            return false;
        }
        //we check them
        $userCheck = checkUser($mail, $pseudo);
        //if pseudo or email dsn't exist we lunch the request to create
        if ($userCheck === true) {
            try {
                $pdo = $this::getPdo();
                $stmt = $pdo->prepare("INSERT INTO 
                    `users`
                        (`pseudo`,`mail`, `password`) 
                    VALUES 
                        (:pseudo, :mail, :password)"
                    );
                $stmt->bindParam(':pseudo', $this->_pseudo);
                $stmt->bindParam(':mail', $this->_mail);
                $stmt->bindParam(':password', $this->_password);
                return $stmt->execute();
            } catch (\PDOException $th) {
                return false;
            }
        } else {
            //if user exist we return $usercheck whos content the message problem
            return $userCheck;
        }
    }
}
