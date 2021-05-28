<?php
require_once(__DIR__ . './Manga.php');

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
                DESC
        ");
        } catch (\PDOException $th) {
            return false;
        }
    }
}
