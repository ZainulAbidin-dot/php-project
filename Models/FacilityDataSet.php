<?php

require_once('Database.php');
require_once('FacilityData.php');

class FacilityDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllFacilities() {
        $sqlQuery = 'SELECT * FROM facility;';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new FacilityData($row);
        }
        return $dataSet;
    }

    public function addFacility($title, $category, $description, $houseNumber, $streetName, $county, $town, $postcode, $lng, $lat, $contributor) {
        $sql = "INSERT INTO facility (title, category, description, houseNumber, streetName, county, town, postcode, lng, lat, contributor)
                VALUES (:title, :category, :description, :houseNumber, :streetName, :county, :town, :postcode, :lng, :lat, :contributor)";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':houseNumber', $houseNumber);
        $statement->bindValue(':streetName', $streetName);
        $statement->bindValue(':county', $county);
        $statement->bindValue(':town', $town);
        $statement->bindValue(':postcode', $postcode);
        $statement->bindValue(':lng', $lng);
        $statement->bindValue(':lat', $lat);
        $statement->bindValue(':contributor', $contributor);
        $statement->execute();
    }

    public function updateFacility($id, $title, $category, $description, $houseNumber, $streetName, $county, $town, $postcode, $lng, $lat) {
        $sql = "UPDATE facility SET title = :title, category = :category, description = :description, houseNumber = :houseNumber, 
                streetName = :streetName, county = :county, town = :town, postcode = :postcode, lng = :lng, lat = :lat
                WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':houseNumber', $houseNumber);
        $statement->bindValue(':streetName', $streetName);
        $statement->bindValue(':county', $county);
        $statement->bindValue(':town', $town);
        $statement->bindValue(':postcode', $postcode);
        $statement->bindValue(':lng', $lng);
        $statement->bindValue(':lat', $lat);
        $statement->execute();
    }

    public function deleteFacility($id) {
        $sql = "DELETE FROM facility WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    public function fetchFacilityByID($id) {
        $sql = "SELECT * FROM facility WHERE id = :id";
        $statement = $this->_dbHandle->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return new FacilityData($row);
    }
}
