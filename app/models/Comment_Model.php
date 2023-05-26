<?php

require_once 'app/models/Model.php';

class Comment_Model extends Model
{

    /**
     * Get all comments
     *
     * @return array
     */

    public function getAll()
    {
        $sql = "SELECT Comment.id, Comment.message, Comment.created_at, Comment.valid,
                        User.id author_id, User.first_name author, User.avatar author_avatar,
                        Post.id post_id, Post.title post_title
                FROM Comment
                JOIN User ON User.id = Comment.user_id
                JOIN Post ON Post.id = Comment.post_id
                ORDER BY Comment.created_at DESC";
        $query = $this->database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get a comment by id
     * @param integer $commentId commment id
     *
     * @return array
     */

    public function getById($commentId)
    {
        $sql = "SELECT * FROM Comment WHERE id = :comment_id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':comment_id', $commentId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get comments by user
     * @param integer $userId user id
     *
     * @return array
     */

    public function getByUser($userId)
    {
        $sql = "SELECT * FROM Comment WHERE user_id = :user_id ORDER BY created_at DESC";
        $query = $this->database->prepare($sql);
        $query->bindParam(':user_id', $userId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get comments by post
     * @param integer $postId post id
     *
     * @return array
     */

    public function getByPost($postId)
    {
        $sql = "SELECT * FROM Comment WHERE post_id = :post_id ORDER BY created_at DESC";
        $query = $this->database->prepare($sql);
        $query->bindParam(':post_id', $postId);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Create a comment
     * @param array $datas comment datas
     *
     * @return void
     */

    public function create(array $datas)
    {
        $sql = "INSERT INTO Comment (user_id, post_id, message, created_at)
                VALUES (:user_id, :post_id, :message, :created_at)";
        $query = $this->database->prepare($sql);
        $query->execute($datas);
    }

    /**
     * Update a comment
     * @param array $datas comment datas
     *
     * @return void
     */

    public function update(array $datas)
    {
        $sql = "UPDATE Comment SET valid = :valid WHERE id = :id";
        $query = $this->database->prepare($sql);
        $query->execute($datas);
    }

    /**
     * Delete a comment
     * @param integer $commentId comment id
     *
     * @return void
     */

    public function delete($commentId)
    {
        $sql = "DELETE FROM Comment WHERE id = :id";
        $query = $this->database->prepare($sql);
        $query->bindParam(':id', $commentId);
        $query->execute();
    }
}
