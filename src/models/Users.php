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
        DESC
        ");
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function getUserFromLogin($email, $password)
    {
        try {
            $pdo = $this::getPdo();
            $stmt = $pdo->prepare('SELECT
                id,
                pseudo,
                mail,
                id_role
            FROM
                users 
            WHERE
                mail = :mail AND password = :password
            ');
            $stmt->bindParam(':mail', $email);
            $stmt->bindParam(':password', $password);
            $res = $stmt->execute();
            if($res){
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        } catch (\PDOException $th) {
        return false;
        }
    }
}