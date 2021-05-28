<?php

require_once(__DIR__ . './Connect.php');

class Library extends Connect
{
    public function __construct()
    {
    }
    public function getLibrary()
    {
        try {
            $pdo = $this::getPdo();
            return $pdo->query("SELECT
                    u.pseudo,
                    l.name
                FROM
                    library_users lu
                JOIN 
                    users u ON lu.id_users = u.id
                JOIN 
                    library l ON lu.id_mangas = l.id
            ");
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function addReading($userId, $mangaId)
    {
        try {
            $pdo = $this::getPdo();
            return $pdo->query("INSERT 
                    INTO 
                    library_users(
                        `id_users`, 
                        `id_mangas`) 
                    VALUES (
                        $userId, 
                        $mangaId
                        )
            ");
        } catch (\PDOException $th) {
            return false;
        }
    }
}


