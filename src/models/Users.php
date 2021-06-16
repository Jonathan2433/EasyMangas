<?php
require_once(__DIR__ . './User.php');

class Users extends User
{
    public function __construct()
    {
    }
    public function getUsers()
    {
        try {
            $pdo = $this::getPdo();
            return $pdo->query("SELECT
            u.id,
            u.pseudo,
            u.mail,
            u.id_role,
            u.password,
            r.name
        FROM
            users u
        JOIN 
            roles r 
        ON 
            u.id_role = r.id
        ORDER BY 
            r.name 
        ASC
        ");
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function getUserFromLogin($mail, $password)
    {
        try {
            $pdo = $this::getPdo();
            $stmt = $pdo->prepare('SELECT
                    password
            FROM
                users
            WHERE
            mail = :mail
            ');
            $stmt->bindParam(':mail', $mail);

            $res = $stmt->execute();

            $passwordHach = $stmt->fetch();
            $passwordHach = $passwordHach['password'];

            if (password_verify($password, $passwordHach)) {
                $stmt = $pdo->prepare('SELECT
                    id,
                    pseudo,
                    mail,
                    id_role
                FROM
                    users 
                WHERE
                    mail = :mail 
                ');
                $stmt->bindParam(':mail', $mail);
                $res = $stmt->execute();
                if ($res) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    return false;
                }
            }
        } catch (\PDOException $th) {
            return false;
        }
    }
}
