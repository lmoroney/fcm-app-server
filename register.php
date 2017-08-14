<?php
 
// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_POST["regid"])) {
    $fcm_regid = $_POST["regid"]; // GCM Registration ID
    // Store user details in db
    include_once 'db_functions.php';
    $db = new DB_Functions();
    $res = $db->storeUser($fcm_regid); 
    echo "Done!";
} else {
    // user details missing
    echo "Problem with parameters";
}
?>