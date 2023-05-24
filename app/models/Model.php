<?php

class Model
{

    /**
     * Database
     */
    protected PDO $database;

    /**
     * Database connection
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $this->database = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (Exception $e) {
            header("Location: ".PATH."?controller=home&action=index&error=".$e->getMessage());
            exit;
        }
    }
}
