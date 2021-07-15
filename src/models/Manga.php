<?php
require_once(__DIR__ . './Connect.php');

class Manga extends Connect
{
    protected $name;
    protected $author;
    protected $editor;
    protected $tomes;
    public $img;

    public function __construct($name, $author, $editor, $tomes, $img, $resume)
    {
        $this->_name = $name;
        $this->_author = $author;
        $this->_editor = $editor;
        $this->_tomes = $tomes;
        $this->_img = $img;
        $this->_resume = $resume;
    }
    protected function setName($name)
    {
        $this->_name = $name;
    }
    protected function setAuthor($author)
    {
        $this->_author = $author;
    }
    protected function setEditor($editor)
    {
        $this->_editor = $editor;
    }
    protected function setTomes($tomes)
    {
        $this->_tomes = $tomes;
    }
    protected function setImg($img)
    {
        $this->_img = $img;
    }
    protected function setResume($resume)
    {
        $this->_resume = $resume;
    }
    public function checkManga()
    {
        try {
            $pdo = $this::getPdo();
            $name = $pdo->query("SELECT 
                name 
            FROM
                library
            WHERE 
                name = '$this->_name'
            ");
            if ($name->rowCount() >= 1) {
                return false;
            } else {
                return true;
            }
        } catch (\PDOException $th) {
            return false;
        }
    }

    public function createManga()
    {
        try {
            $pdo = $this::getPdo();
            $stmt = $pdo->prepare(
                "INSERT INTO 
                    library
                (name,author, editor, tomes, img, resume) 
                    VALUES 
                (:name, :author, :editor, :tomes, :img, :resume)"
            );
            $stmt->bindParam(':name', $this->_name);
            $stmt->bindParam(':author', $this->_author);
            $stmt->bindParam(':editor', $this->_editor);
            $stmt->bindParam(':tomes', $this->_tomes);
            $stmt->bindParam(':img', $this->_img);
            $stmt->bindParam(':resume', $this->_resume);
            return $stmt->execute();
        } catch (\PDOException $th) {
            return false;
        }
    }
    public function deleteManga($idManga)
    {
        $pdo = $this::getPdo();

        $stmt = $pdo->prepare("DELETE  
            FROM 
                `library` 
            WHERE
                `id` = :id 
            LIMIT 1
        ");
        $stmt->bindParam(':id', $idManga);
        return $stmt->execute();
    }
    public function editManga($idManga)
    {
        try {
            $pdo = $this::getPdo();
            $stmt = $pdo->prepare("UPDATE
                `library`
            SET
                name = :name ,
                author = :author,
                editor = :editor,
                tomes = :tomes,
                img = :img,
                resume = :resume
            WHERE
                id = $idManga
            ");
            $stmt->bindParam(':name', $this->_name);
            $stmt->bindParam(':author', $this->_author);
            $stmt->bindParam(':editor', $this->_editor);
            $stmt->bindParam(':tomes', $this->_tomes);
            $stmt->bindParam(':img', $this->_img);
            $stmt->bindParam(':resume', $this->_resume);
            return $stmt->execute();
        } catch (\PDOException $th) {
            return false;
        }
    }
}
