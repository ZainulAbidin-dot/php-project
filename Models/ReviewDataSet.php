<?php

require_once('Database.php');
require_once('Review.php');

class ReviewDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllReviews() {
        $sqlQuery = 'SELECT * FROM review;';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Review($row);
        }
        return $dataSet;
    }

    public function addReview($user_id, $review) {
        $sql = "INSERT INTO review (user_id, review) VALUES (:user_id, :review)";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':review', $review);
        $statement->execute();
    }

    public function updateReview($id, $user_id, $review) {
        $sql = "UPDATE review SET user_id = :user_id, review = :review WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':review', $review);
        $statement->execute();
    }

    public function deleteReview($id) {
        $sql = "DELETE FROM review WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    public function fetchReviewByID($id) {
        $sql = "SELECT * FROM review WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return new Review($row);
    }

    public function fetchReviewByUserID($id) {
        $sql = "SELECT * FROM review WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Review($row);
        }
        return $dataSet;
    }
}
