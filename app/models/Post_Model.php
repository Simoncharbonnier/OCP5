<?php

require_once 'app/models/Model.php';

class Post_Model extends Model
{

    /**
     * Get all posts
     *
     * @return array
     */

    public function getAll()
    {
        $sql = "SELECT * FROM Post ORDER BY updated_at DESC";
        $query = $this->database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get 3 lasts
     *
     * @return array
     */

    public function get3Lasts()
    {
        $sql = "SELECT * FROM Post ORDER BY updated_at DESC LIMIT 3";
        $query = $this->database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get posts by user
     * @param integer $userId user id
     *
     * @return array
     */

    public function getByUser($userId)
    {
        $sql = "SELECT * FROM Post WHERE user_id = :user_id ORDER BY created_at DESC";
        $query = $this->database->prepare($sql);
        $query->bindParam(':user_id', $userId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get a post by id with its comments and author
     * @param integer $postId post id
     *
     * @return array
     */

    public function getById($postId)
    {
        $sql = "SELECT Post.id, Post.title, Post.headline, Post.content, Post.image, Post.created_at, Post.updated_at,
                        User.id post_author_id, User.first_name post_author, User.avatar post_author_avatar,
                        Comment.message, Comment.created_at comment_created_at,
                        U.id comment_author_id, U.first_name comment_author, U.avatar comment_author_avatar
                FROM Post
                JOIN User ON User.id = Post.user_id
                LEFT JOIN Comment ON Comment.post_id = Post.id AND Comment.valid = 1
                LEFT JOIN User U ON U.id = Comment.user_id
                WHERE Post.id = :post_id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':post_id', $postId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get a post by title
     * @param string $title post title
     * @param integer $postId post id
     *
     * @return array
     */

    public function getByTitle($title, $postId = 0)
    {
        $sql = "SELECT * FROM Post WHERE Post.title = :title AND Post.id != :id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':title', $title);
        $query->bindParam(':id', $postId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Create a post
     * @param array $datas post datas
     *
     * @return integer
     */

    public function create(array $datas)
    {
        $sql = "INSERT INTO Post (user_id, title, headline, content, image, created_at, updated_at)
                VALUES (:user_id, :title, :headline, :content, :image, :created_at, :updated_at)";
        $query = $this->database->prepare($sql);
        $query->execute($datas);
        return $this->database->lastInsertId();
    }

    /**
     * Update a post
     * @param array $datas post datas
     *
     * @return void
     */

    public function update(array $datas)
    {
        $sql = "UPDATE Post SET title = :title, headline = :headline, content = :content, image = :image, updated_at = :updated_at
                WHERE id = :id";
        $query = $this->database->prepare($sql);
        $query->execute($datas);
    }

    /**
     * Delete a post
     * @param integer $postId post id
     *
     * @return void
     */

    public function delete($postId)
    {
        $sql = "DELETE FROM Post WHERE id = :post_id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':post_id', $postId);
        $query->execute();
    }
}
