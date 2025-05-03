<?php
/*
 * Class Review
 *
 * This class models a review, utilizing protected fields for data encapsulation.
 * It takes a database row (array) as input in the constructor and assigns values to private fields, which include:
 * - User ID
 * - Review
 */
class Review implements ArrayAccess {

    // private fields
    protected $_id, $_userId, $_review, $_facilityId, $_reviewerName;

    // Implement ArrayAccess methods
    public function offsetExists($offset) {
        return property_exists($this, "_$offset");
    }

    public function offsetGet($offset) {
        return $this->{"_$offset"} ?? null;
    }

    public function offsetSet($offset, $value) {
        if (property_exists($this, "_$offset")) {
            $this->{"_$offset"} = $value;
        }
    }

    public function offsetUnset($offset) {
        if (property_exists($this, "_$offset")) {
            $this->{"_$offset"} = null;
        }
    }

    // constructor
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_userId = $dbRow['user_id'];
        $this->_review = $dbRow['review'];
        $this->_facilityId = $dbRow['facility_id'];
        $this->_reviewerName = $dbRow['reviewer_name'] ?? null; // Optional field
    }

    // accessors
    public function getId() {
        return $this->_id;
    }
    public function getUserId() {
        return $this->_userId;
    }
    public function getReview() {
        return $this->_review;
    }

    public function getFacilityId() {
        return $this->_facilityId;
    }

    public function getReviewerName() {
        return $this->_reviewerName;
    }

    // Add additional methods if needed
}
