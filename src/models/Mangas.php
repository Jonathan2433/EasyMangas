<?php
require_once(__DIR__ . './User.php');

class Mangas extends Manga
{
    public function __construct()
    {
    }
    public function getMangas()
    {
        try {
            $pdo = $this::getPdo();
            return $pdo->query("SELECT
            id,
            name,
            editor,
            author,
            tomes
        FROM
            mangas
        ORDER BY 
            name 
        DESC
        ");
        } catch (\PDOException $th) {
            return false;
        }
    }
}
