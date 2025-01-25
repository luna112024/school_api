<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class user {
    private $db, $service, $last_id;
    function __construct()
    {
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    function getList() {
       $res = $this->service->getData("tbl_user", "id");
       $this->db->success($res);
    }


    function save($user) {
        // Convert data to array object by decoding params
        $jsonString = json_encode($user);
        $users = json_decode($jsonString);
    
        // Prepare data array
        $data = array(
            "fullname" => $users->fullname,
            "username" => $users->username,
            "password" => $users->password,
            "email" => $users->email,
            "user_type" => $users->user_type,
            "image" => $users->image,
            "is_deleted" => $users->is_deleted // Fixed typo: was `is_delete`
        );

    
        if (!isset($users->id) || $users->id == 0) {
            // Debug: Attempt to insert new record
            error_log('Attempting to insert new class study record.');
            $res = $this->service->save("tbl_user", $data);
            $users->id = $this->db->last_id;  // Set the ID of the newly inserted record
        } else {
            // Debug: Attempt to update existing record
            error_log('Attempting to update existing class study record with ID: ' . $classes->id);
            $res = $this->service->update("tbl_user", $data, "WHERE id = {$classes->id}");
        }
    
        // Return response
        return $res;
    }
    
    function load($id) {
        $res = $this->service->getDataById("tbl_user", "id", $id);
        $this->db->success($res);
    }


    function deleteById($id) {
        // Call the delete function from service.php
        $result = $this->service->delete("tbl_user", "id", $id); // Assuming 'id' is the column name in the 'tbl_room' table
    
        // Check if the delete operation was successful
        if ($result) {
            // If successful, send a success message with the response
            $this->db->success(["message" => "User deleted successfully", "userID" => $id]);
        } else {
            // If deletion failed, send an error message
            $this->db->error(["message" => "Failed to delete User", "userID" => $id]);
        }
    }    
    
}
?>