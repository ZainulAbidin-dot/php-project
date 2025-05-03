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
    protected $_id, $_userId, $_review;

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

    // Add additional methods if needed
}
