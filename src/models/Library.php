<?php

require_once(__DIR__ . './Connect.php');

class Library extends Connect
{
    public function __construct()
    {
    }
    public function getLibrary($userId)
    {
        try {
            $pdo = $this::getPdo();
            return $pdo->query("SELECT
                    l.name,
                    l.author,
                    l.editor,
                    l.tomes,
                    l.img,
                    l.id,
                    lu.tomes_read
                FROM
                    library_users lu
                JOIN 
                    users u ON lu.id_users = u.id
                JOIN 
                    library l ON lu.id_mangas = l.id
                WHERE
                    id_users = $userId
            ");
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function addReading($userId, $mangaId, $tomesRead)
    {
        try {
            $pdo = $this::getPdo();
             $pdo->query("INSERT 
                    INTO 
                    library_users(
                        `id_users`, 
                        `id_mangas`,
                        `tomes_read`) 
                    VALUES (
                        $userId, 
                        $mangaId,
                        $tomesRead
                        )
            ");
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function deleteReading($userId, $mangaId)
    {
        try {
            $pdo = $this::getPdo();
            return $pdo->query("DELETE 
                FROM 
                    library_users
                WHERE id_users = $userId
                AND id_mangas = $mangaId
            ");
        } catch (\PDOException $th) {
            return false;
        }
    }
}


