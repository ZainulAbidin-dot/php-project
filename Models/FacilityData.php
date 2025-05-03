<?php
/*
 * Class FacilityData
 *
 * This class models a facility’s data, utilizing protected fields for data encapsulation.
 * It takes a database row (array) as input in the constructor and assigns values to private fields, which include:
 * - Title
 * - Category
 * - Description
 * - House Number
 * - Street Name
 * - County
 * - Town
 * - Postcode
 * - Longitude
 * - Latitude
 * - Contributor
 */
class FacilityData implements JsonSerializable {

    // private fields
    protected $_id, $_title, $_category, $_description, $_houseNumber, $_streetName, $_county, $_town, $_postcode, $_longitude, $_latitude, $_contributor;

    // constructor
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_title = $dbRow['title'];
        $this->_category = $dbRow['category'];
        $this->_description = $dbRow['description'];
        $this->_houseNumber = $dbRow['houseNumber'];
        $this->_streetName = $dbRow['streetName'];
        $this->_county = $dbRow['county'];
        $this->_town = $dbRow['town'];
        $this->_postcode = $dbRow['postcode'];
        $this->_longitude = $dbRow['lng'];
        $this->_latitude = $dbRow['lat'];
        $this->_contributor = $dbRow['contributor'];
    }

    // accessors
    public function getId() {
        return $this->_id;
    }
    public function getTitle() {
        return $this->_title;
    }
    public function getCategory() {
        return $this->_category;
    }
    public function getDescription() {
        return $this->_description;
    }
    public function getHouseNumber() {
        return $this->_houseNumber;
    }
    public function getStreetName() {
        return $this->_streetName;
    }
    public function getCountry() {
        return $this->_county;
    }
    public function getTown() {
        return $this->_town;
    }
    public function getPostcode() {
        return $this->_postcode;
    }
    public function getLongitude() {
        return $this->_longitude;
    }
    public function getLatitude() {
        return $this->_latitude;
    }
    public function getContributor() {
        return $this->_contributor;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->_id,
            'title' => $this->_title,
            'category' => $this->_category,
            'description' => $this->_description,
            'houseNumber' => $this->_houseNumber,
            'streetName' => $this->_streetName,
            'county' => $this->_county,
            'town' => $this->_town,
            'postcode' => $this->_postcode,
            'longitude' => $this->_longitude,
            'latitude' => $this->_latitude,
            'contributor' => $this->_contributor
        ];
    }

}
