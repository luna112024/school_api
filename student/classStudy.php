<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class classStudy {
    private $db, $service, $last_id;

    function __construct()
    {
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    function getList() {
       $res = $this->service->getData("tbl_class_study", "id");
       $this->db->success($res);
    }

    function save($class) {
        // Convert data to array object by decode params
        $jsonString = json_encode($class);
        $classes = json_decode($jsonString);
    
        // Debug: Check the decoded data
        error_log('Decoded class data: ' . print_r($classes, true));
    
        // Prepare the data for the insert or update query
        $data = array(
            "class_id" => $classes->class_id,
            "room_id" => $classes->room_id,
            "teacher_id" => $classes->teacher_id, // Fixed typo
            "time_id" => $classes->time_id,
            "create_date" => $classes->create_date,
            "end_date" => $classes->end_date,
            "student_capacity" => $classes->student_capacity,
            "is_deleted" => 0
        );
    
        // Debug: Check if the ID exists and the data to be saved
        error_log('Data to be saved: ' . print_r($data, true));
    
        // Check if the ID is set (new record or existing record)
        if (!isset($classes->id) || $classes->id == 0) {
            // Debug: Attempt to insert new record
            error_log('Attempting to insert new class study record.');
            $res = $this->service->save("tbl_class_study", $data);
            $classes->id = $this->db->last_id;  // Set the ID of the newly inserted record
        } else {
            // Debug: Attempt to update existing record
            error_log('Attempting to update existing class study record with ID: ' . $classes->id);
            $res = $this->service->update("tbl_class_study", $data, "WHERE id = {$classes->id}");
        }
    
        // Debug: Return the result of the save or update operation
        error_log('Save/Update result: ' . print_r($res, true));
    
        return $res;
    }
    
    function load($id) {
        $res = $this->service->getDataById("tbl_class_study", "id", $id);
        $this->db->success($res);
    }

    function deleteById($id) {
        // Call the delete function from service.php
        $result = $this->service->delete("tbl_class_study", "id", $id);

        // Check if the delete operation was successful
        if ($result) {
            // If successful, send a success message with the response
            $this->db->success(["message" => "Class deleted successfully", "classId" => $id]);
        } else {
            // If deletion failed, send an error message
            $this->db->error(["message" => "Failed to delete Class", "classId" => $id]);
        }
    }    
}
?>
