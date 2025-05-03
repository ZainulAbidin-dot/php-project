<?php
require_once('Models/FacilityDataSet.php');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $facilityDataSet = new FacilityDataSet();
    $deleted = $facilityDataSet->deleteFacility($id);

    if ($deleted) {
        echo 'success';
    } else {
        echo 'fail';
    }
} else {
    echo 'invalid';
}
