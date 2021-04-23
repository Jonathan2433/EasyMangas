<?php
require_once(__DIR__ . './Connect.php');

class User extends Connect
{
    protected $pseudo;
    protected $mail;
    protected $password;

    public function __construct($pseudo, $mail, $password, $role)
    {
        $this->_pseudo = $pseudo;
        $this->_mail = $mail;
        $this->_password = $password;
        $this->_role = $role;
    }
    protected function setPseudo($pseudo)
    {
        $this->_pseudo = $pseudo;
    }
    protected function setMail($mail)
    {
        $this->_mail = $mail;
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
            } else if ($pseudo->rowCount() >= 1) {
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
                    users
                (pseudo,mail, password, id_role) 
                    VALUES 
                (:pseudo, :mail, :password, :id_role)"
            );
            $stmt->bindParam(':pseudo', $this->_pseudo);
            $stmt->bindParam(':mail', $this->_mail);
            $stmt->bindParam(':password', $this->_password);
            $stmt->bindParam(':id_role', $this->_role);
            return $stmt->execute();
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function deleteUser($idUser)
    {
        $pdo = $this::getPdo();

        $stmt = $pdo->prepare("DELETE  
            FROM 
                `users` 
            WHERE
                `id` = :id 
            LIMIT 1
        ");
        $stmt->bindParam(':id', $idUser);
        return $stmt->execute();
    }
    public function detailUser($idUser)
    {
        $pdo = $this::getPdo();
        return $pdo->query("SELECT
            u.pseudo,
            u.mail,
            u.password,
            r.name
        FROM
            users u
        JOIN roles r ON
            u.id_role = r.id
        WHERE
            u.id = $idUser
        ");
    }
}
