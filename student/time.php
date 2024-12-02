<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class time {
    private $db, $service, $last_id;
    function __construct()
    {
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    function getList() {
       $res = $this->service->getData("tbl_time", "id");
       $this->db->success($res);
    }

    function save($time) {
        // convert data to array object by decode params
        $jsonString = json_encode($time);
        $times = json_decode($jsonString);

        $data = array(
            "time_label" => isset($times->time_label) ? $times->time_label : '',
            "description" => isset($times->description) ? $times->description : '', // Corrected typo
            "is_deleted" => isset($times->is_delete) ? (int)$times->is_delete : 0  // Ensure it's an integer
        );
        if (isset($times->id) == 0) {
            $res = $this->service->save("tbl_time", $data);
            $times->id = $this->db->last_id;
        } else {
            $res = $this->service->update("tbl_time", $data, "WHERE id = $times->id ");
        }
        return $res;
    } 
    function load($id) {
        $res = $this->service->getDataById("tbl_time", "id", $id);
        $this->db->success($res);
    }

    // //Delete
    // function deleteList() {
    //     // Get the ID from the query parameter
    //     if (isset($_GET['id']) && $_GET['id'] > 0) {
    //         $id = intval($_GET['id']); // Make sure to sanitize the input
            
    //         // Call the delete method
    //         $res = $this->service->delete("tbl_room", "id", $id);
            
    //         if ($res) {
    //             return 'Delete successful';
    //         } else {
    //             return 'Delete not successful';
    //         }
    //     } else {
    //         return 'Room ID is required';
    //     }
    // }

    function deleteById($id) {
        // Call the delete function from service.php
        $result = $this->service->delete("tbl_time", "id", $id); // Assuming 'id' is the column name in the 'tbl_room' table
    
        // Check if the delete operation was successful
        if ($result) {
            // If successful, send a success message with the response
            $this->db->success(["message" => "time deleted successfully", "TimeId" => $id]);
        } else {
            // If deletion failed, send an error message
            $this->db->error(["message" => "Failed to delete Time", "TimeIds" => $id]);
        }
    }    
    
}
?>