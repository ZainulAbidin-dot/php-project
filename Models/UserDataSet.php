<?php

require_once ('Database.php');
require_once ('UserData.php');

class UserDataSet {
    protected $_dbHandle, $_dbInstance;
        
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllUsers() {
        $sqlQuery = 'SELECT * FROM users;';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        // loop through and read the results of the query and cast
        // them into a matching object
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }

    public function addUser($username, $password, $role) {
        $sql = "INSERT INTO users (username, password, role)
            VALUES (:username, :password, :role)";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT)); // Hash the password
        $statement->bindValue(':role', $role);
        $statement->execute();

        $lastInsertId = $this->_dbHandle->lastInsertId(); // Get the ID of the newly created user

        // Fetch the newly created user and return it as a UserData object
        return $this->fetchUserByID($lastInsertId);
    }
    
    public function loginUser($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            return new UserData($row); // Return a UserData object if login is successful
        }
        return null; // Return null if login fails
    }

    public function updateUser($id, $username, $password, $role) {
        $sql = "UPDATE users SET username = :username, password = :password, role = :role WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT)); // Hash the password
        $statement->bindValue(':role', $role);
        $statement->execute();
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    public function fetchUserByID($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return new UserData($row); // Return a UserData object
    }
}
