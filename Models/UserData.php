<?php
/*
 * Class UserData
 *
 * This class models a user’s data, utilizing protected fields for data encapsulation.
 * It takes a database row (array) as input in the constructor and assigns values to private fields, which include:
 * - Username
 * - Password
 * - Role (can be 'user' or 'admin')
 */
class UserData {

    // private fields
    protected $_id, $_username, $_password, $_role;

    // constructor
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_username = $dbRow['username'];
        $this->_password = $dbRow['password'];
        $this->_role = $dbRow['role'];
    }

    // accessors
    public function getId() {
        return $this->_id;
    }
    public function getUsername() {
        return $this->_username;
    }
    public function getPassword() {
        return $this->_password;
    }
    public function getRole() {
        return $this->_role;
    }

    // add in accessors for the other fields, check the view file in the given project to see what
    // the accessor methods should be called

}
