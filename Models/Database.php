<?php

class Database {
    /**
     * @var Database
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO
     */
    protected $_dbHandle;

    /**
     * @return Database
     */
    public static function getInstance() {

       if(self::$_dbInstance === null) { //checks if the PDO exists
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self();
        }
        return self::$_dbInstance;
    }

    private function __construct() {
        try { 
             $this->_dbHandle = new PDO("sqlite:" . dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "ecobuddy.sqlite");
             $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

             // Ensure the 'users' table exists
             $this->_dbHandle->exec("
                 CREATE TABLE IF NOT EXISTS users (
                     id INTEGER PRIMARY KEY AUTOINCREMENT,
                     username TEXT NOT NULL,
                     password TEXT NOT NULL,
                     role TEXT NOT NULL
                 )
             ");

            // Ensure the 'facility' table exists
            $this->_dbHandle->exec("
                CREATE TABLE IF NOT EXISTS facility (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    category TEXT NOT NULL,
                    description TEXT NOT NULL,
                    houseNumber TEXT NOT NULL,
                    streetName TEXT NOT NULL,
                    county TEXT NOT NULL,
                    town TEXT NOT NULL,
                    postcode TEXT NOT NULL,
                    lng REAL NOT NULL,
                    lat REAL NOT NULL,
                    contributor TEXT NOT NULL
                )
            ");

            // Ensure the 'review' table exists
            $this->_dbHandle->exec("
                CREATE TABLE IF NOT EXISTS review (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    facility_id INTEGER NOT NULL,
                    review TEXT NOT NULL,
                    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY(facility_id) REFERENCES facility(id) ON DELETE CASCADE
                )
            ");
        }
        catch (PDOException $e) { // catch any failure to connect to the database
	    echo $e->getMessage();
	}
    }

    /**
     * @return PDO
     */
    public function getdbConnection() {
        return $this->_dbHandle; // returns the PDO handle to be used                                        elsewhere
    }

    public function __destruct() {
        $this->_dbHandle = null; // destroys the PDO handle when nolonger needed                                        longer needed
    }
}
