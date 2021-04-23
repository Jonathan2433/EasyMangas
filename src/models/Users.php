<?php
require_once(__DIR__ . './Connect.php');

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

    public function checkUser()
    {
        try {
            $pdo = $this::getPdo();
            $mail = $pdo->query("SELECT 
                mail 
            FROM
                users
            WHERE 
                mail = '$this->_mail'
            ");
            $pseudo = $pdo->query("SELECT 
                pseudo
            FROM 
                users
            WHERE
                mail = '$this->_pseudo'
            ");
            if ($mail->rowCount() >= 1) {
                return $msg = 'mail already register';
            } else if ($pseudo->rowCount() >= 1 ) { 
                return $msg = 'pseudo already register';
            } else {
                return true;
            }
        } catch (\PDOException $th) {
            return false;
        }
    }

    public function createUser()
    {
        try {
            $pdo = $this::getPdo();
            $stmt = $pdo->prepare(
                "INSERT INTO 
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
    }
    
}
