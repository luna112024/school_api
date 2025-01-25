<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class register {
    private $db, $service, $last_id;
    function __construct()
    {
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    function getList() {
       $res = $this->service->getData("tbl_register", "id");
       $this->db->success($res);
    }


    // function save($student) {
    //     // Convert data to array object by decoding params
    //     $jsonString = json_encode($student);
    //     $students = json_decode($jsonString);
    
    //     // Prepare data array
    //     $data = array(
    //         "student_id" => $students->student_id,  // Fixed semicolon
    //         "register_date" => $students->register_date,
    //         "user_id" => $students->user_id,
    //         "is_deleted" => $students->is_deleted  // Fixed typo
    //     );

    
    //     if (!isset($students->id) || $students->id == 0) {
    //         // Debug: Attempt to insert new record
    //         error_log('Attempting to insert new class study record.');
    //         $res = $this->service->save("tbl_register", $data);
    //         $students->id = $this->db->last_id;  // Set the ID of the newly inserted record
    //     } else {
    //         // Debug: Attempt to update existing record
    //         error_log('Attempting to update existing class study record with ID: ' . $students->id);
    //         $res = $this->service->update("tbl_register", $data, "WHERE id = {$students->id}");
    //     }
    
    //     // Return response
    //     return $res;
    // }
    
   
    function save($student) {
        // Convert data to array object by decoding params
        $jsonString = json_encode($student);
        $students = json_decode($jsonString);
    
        // Prepare data array
        $data = array(
            "student_id" => $students->student_id,
            "register_date" => $students->register_date,
            "user_id" => $students->user_id,
            "is_deleted" => $students->is_deleted,
            "register_status" => $students->register_status  
        );

    
        if (!isset($students->id) || $students->id == 0) {
            // Debug: Attempt to insert new record
            error_log('Attempting to insert new class study record.');
            $res = $this->service->save("tbl_register", $data);
            $students->id = $this->db->last_id;  // Set the ID of the newly inserted record
        } else {
            // Debug: Attempt to update existing record
            error_log('Attempting to update existing class study record with ID: ' . $students->id);
            $res = $this->service->update("tbl_register", $data, "WHERE id = {$students->id}");
        }
    
        // Return response
        return $res;
    }
    // function save($student)
    // {
    //     // Convert data to an object by decoding params
    //     $jsonString = json_encode($student);
    //     $students = json_decode($jsonString);

    //     // Prepare data array including status
    //     $data = array(
    //         "student_id" => $students->student_id,
    //         "register_date" => $students->register_date,
    //         "user_id" => $students->user_id,
    //         "is_deleted" => $students->is_deleted,
    //         "register_status" => $students->register_status  
    //     );

    //     // Connect to the database
    //     $this->pro_conn = new connection(); 

    //     if (!isset($students->id) || $students->id == 0) {
    //         // Debug: Attempt to insert new record
    //         error_log('Attempting to insert new class study record.');

    //         // Insert new record
    //         $res = $this->service->save("tbl_register", $data);

    //         // Set the ID of the newly inserted record
    //         $students->id = $this->db->last_id; 
    //     } else {
    //         // Debug: Attempt to update existing record
    //         error_log('Attempting to update existing class study record with ID: ' . $students->id);

    //         // Update existing record, but also make sure to retain status if it's already set
    //         $data['status'] = isset($students->status) ? $students->status : 'pending'; // Retain existing status if already set
    //         $res = $this->service->update("tbl_register", $data, "WHERE id = {$students->id}"); 
    //     }

    //     // Return response
    //     return $res;
    // }

    

    function load($id) {
        $res = $this->service->getDataById("tbl_register", "id", $id);
        $this->db->success($res);
    }


    function deleteById($id) {
        // Call the delete function from service.php
        $result = $this->service->delete("tbl_register", "id", $id); // Assuming 'id' is the column name in the 'tbl_room' table
    
        // Check if the delete operation was successful
        if ($result) {
            // If successful, send a success message with the response
            $this->db->success(["message" => "Register deleted successfully", "userID" => $id]);
        } else {
            // If deletion failed, send an error message
            $this->db->error(["message" => "Failed to delete User", "userID" => $id]);
        }
    }    
   
    function checkStudentId() {
        if (isset($_GET['student_id'])) {
            $student_id = $_GET['student_id'];
        } else {
            $this->db->error([
                "status" => "error",
                "message" => "Student ID is required"
            ]);
            return;
        }
    
        // Prepare the query
        $query = "SELECT * FROM tbl_register WHERE student_id = '$student_id'";
    
        // Assuming you have a mysqli connection object, execute the query
        $result = $this->db->conn->query($query);
    
        // Response payload structure
        $response = [];
    
        if ($result->num_rows > 0) {
            // If student_id exists, set success status
            $response = [
                "status" => "success",
                "message" => "Student ID exists in tbl_register",
                "studentID" => $student_id,
                "data" => $result->fetch_all(MYSQLI_ASSOC)
            ];
        } else {
            // If student_id doesn't exist, set error status
            $response = [
                "status" => "error",
                "message" => "Student ID does not exist in tbl_register",
                "studentID" => $student_id
            ];
        }
    
        echo json_encode($response);
    }
    
}
?>