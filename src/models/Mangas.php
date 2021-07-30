<?php
require_once(__DIR__ . '/Manga.php');

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
                    tomes,
                    img,
                    resume
                FROM
                    library
                ORDER BY 
                    name 
                ASC
        ");
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function detailManga($idManga)
    {
        $pdo = $this::getPdo();
        return $pdo->query("SELECT
            name,
            author,
            editor,
            name,
            tomes,
            img,
            resume
        FROM
        library 
        WHERE
            id = $idManga
        ");
    }
}
