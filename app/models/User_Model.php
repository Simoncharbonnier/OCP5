<?php

require_once 'app/models/Model.php';

class User_Model extends Model
{

    /**
     * Get all users
     *
     * @return array
     */

    public function getAll()
    {
        $sql = "SELECT * FROM User";
        $query = $this->database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get a user by id
     * @param integer $userId user id
     *
     * @return array
     */

    public function getById($userId)
    {
        $sql = "SELECT * FROM User WHERE id = :user_id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':user_id', $userId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get a user by mail
     * @param string $mail mail
     *
     * @return array
     */

    public function getByMail($mail)
    {
        $sql = "SELECT * FROM User WHERE mail = :mail";
        $query = $this->database->prepare($sql);
        $query->bindParam(':mail', $mail);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Create a user
     * @param array $datas user datas
     *
     * @return integer
     */

    public function create(array $datas)
    {
        $sql = "INSERT INTO User (first_name, last_name, mail, password)
                VALUES (:first_name, :last_name, :mail, :password)";
        $query = $this->database->prepare($sql);
        $query->execute($datas);
        return $this->database->lastInsertId();
    }

    /**
     * Update a user
     * @param array $datas user datas
     *
     * @return void
     */

    public function update(array $datas)
    {
        $sql = "UPDATE User SET first_name = :first_name, last_name = :last_name, password = :password, avatar = :avatar
                WHERE id = :id";
        $query = $this->database->prepare($sql);
        $query->execute($datas);
    }

    /**
     * Delete a user
     * @param integer $userId user id
     *
     * @return void
     */

    public function delete($userId)
    {
        $sql = "DELETE FROM User WHERE id = :user_id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':user_id', $userId);
        $query->execute();
    }
}
