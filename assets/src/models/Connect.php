<?php

class Connect
{
    public $pdo;
    static function getPdo()
    {
        try {
            return $pdo = new PDO(
                'mysql:host=localhost;dbname=easy_manga;charset=utf8',
                'root',
                '',
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (\PDOException $th) {
            return $th->getMessage();
        }
    }
}

