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

    public function fetchReviewsByFacilityID($facilityId) {
        $sql = "SELECT review.*, users.username AS reviewer_name FROM review 
            JOIN users ON review.user_id = users.id 
            WHERE review.facility_id = :facility_id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':facility_id', $facilityId);
        $statement->execute();
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Review($row);
        }
        return $dataSet;
    }

    public function addReview($data) {
        $sql = "INSERT INTO review (user_id, facility_id, review) VALUES (:user_id, :facility_id, :review)";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':user_id', $data['user_id']);
        $statement->bindValue(':facility_id', $data['facility_id']);
        $statement->bindValue(':review', $data['review']);
        $statement->execute();
    }

    public function updateReview($data) {
        $sql = "UPDATE review SET review = :review WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $data['id']);
        $statement->bindValue(':review', $data['review']);
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
}
