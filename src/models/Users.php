<?php
require_once(__DIR__ . './User.php');

class Users extends User
{
    public function __construct()
    {
    }
    function getUsers()
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
}
