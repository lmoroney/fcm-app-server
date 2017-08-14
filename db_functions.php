<?php
 
class DB_Functions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        include_once 'db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($fcm_regid) {
        // insert user into database
        $result = mysql_query("INSERT INTO fcm_users(fcm_regID, created_at) VALUES('$fcm_regid', NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM fcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            //echo "Insert Failed!";
            //echo mysql_error();
            return false;
        }
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM fcm_users");
        return $result;
    }
 
}
 
?>