<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class studentList {
    private $db, $service, $last_id;
    function __construct()
    {
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    function getList() {
       $res = $this->service->getData("tbl_student", "id");
       $this->db->success($res);
    }
    // function getListReg() {
    //     $res = $this->service->getData("tbl_register", "id");
    //     $this->db->success($res);
    //  }
 

    // function save($student) {
    //     // Convert data to array object by decoding params
    //     $jsonString = json_encode($student);
    //     $students = json_decode($jsonString);
    
    //     // Prepare data array
    //     $data = array(
    //         "student_id" => $student->student_id;
    //         "khmer_name" => $students->khmer_name;
    //         "english_name" => $students->english_name;
    //         "gender" => $students->gender;
    //         "dob" => $students->dob;        
    //         "nationality" => $students->nationality;        
    //         "pob" => $students->pob;        
    //         "address" => $students->address;        
    //         "student_phonenumber" => $students->student_phonenumber;        
    //         "father_name" => $students->father_name;        
    //         "mother_name" => $students->mother_name;        
    //         "phone_number1" => $students->phone_number1;        
    //         "phone_number2" => $students->phone_number2;        
    //         "is_deleted" => $students->is_deleted // Fixed typo: was `is_delete`
    //     );

    //     if (!isset($students->id) || $students->id == 0) {
    //         // Debug: Attempt to insert new record
    //         error_log('Attempting to insert new class study record.');
    //         $res = $this->service->save("tbl_student", $data);
    //         $students->id = $this->db->last_id;  // Set the ID of the newly inserted record
    //     } else {
    //         // Debug: Attempt to update existing record
    //         error_log('Attempting to update existing class study record with ID: ' . $students->id);
    //         $res = $this->service->update("tbl_student", $data, "WHERE id = {$students->id}");
    //     }
    //     $registerData = array(
    //         "student_id" => $student_id,
    //         "register_date" => date('Y-m-d'),
    //         "user_id" => 1
    //     );
    //     $datas=$this->service->save("tbl_register", $registerData);
    
    //     // Return response
    //     return $res;
    //     return $datas;
    // }
    // function save($student) {
    //     // Convert data to array object by decoding params
    //     $jsonString = json_encode($student);
    //     $students = json_decode($jsonString);
    
    //     // Prepare data array
    //     $data = array(
    //         "student_id" => $students->student_id,  // Fixed semicolon
    //         "khmer_name" => $students->khmer_name,
    //         "english_name" => $students->english_name,
    //         "gender" => $students->gender,
    //         "dob" => $students->dob,
    //         "nationality" => $students->nationality,
    //         "pob" => $students->pob,
    //         "address" => $students->address,
    //         "student_phonenumber" => $students->student_phonenumber,
    //         "father_name" => $students->father_name,
    //         "mother_name" => $students->mother_name,
    //         "phone_number1" => $students->phone_number1,
    //         "phone_number2" => $students->phone_number2,
    //         "is_deleted" => $students->is_deleted  // Fixed typo
    //     );
    
    //     if (!isset($students->id) || $students->id == 0) {
    //         // Debug: Attempt to insert new record
    //         error_log('Attempting to insert new class study record.');
    //         $res = $this->service->save("tbl_student", $data);
    //         $students->id = $this->db->last_id;  // Set the ID of the newly inserted record
    //     } else {
    //         // Debug: Attempt to update existing record
    //         error_log('Attempting to update existing class study record with ID: ' . $students->id);
    //         $res = $this->service->update("tbl_student", $data, "WHERE id = {$students->id}");
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
            "student_id" => $students->student_id,  // Fixed semicolon
            "khmer_name" => $students->khmer_name,
            "english_name" => $students->english_name,
            "gender" => $students->gender,
            "dob" => $students->dob,
            "nationality" => $students->nationality,
            "pob" => $students->pob,
            "address" => $students->address,
            "student_phonenumber" => $students->student_phonenumber,
            "father_name" => $students->father_name,
            "mother_name" => $students->mother_name,
            "phone_number1" => $students->phone_number1,
            "phone_number2" => $students->phone_number2,
            "is_deleted" => $students->is_deleted  // Fixed typo
        );
        if (!isset($students->id) || $students->id == 0) {
            // Debug: Attempt to insert new record
            error_log('Attempting to insert new class study record.');
            $res = $this->service->save("tbl_student", $data);
            $students->id = $this->db->last_id;  // Set the ID of the newly inserted record
        } else {
            // Debug: Attempt to update existing record
            error_log('Attempting to update existing class study record with ID: ' . $students->id);
            $res = $this->service->update("tbl_student", $data, "WHERE id = {$students->id}");
        }
    
        // Return response
        return $res;
    }
    
    function load($id) {
        $res = $this->service->getDataById("tbl_student", "id", $id);
        $this->db->success($res);
    }


    function deleteById($id) {
        // Call the delete function from service.php
        $result = $this->service->delete("tbl_student", "id", $id); // Assuming 'id' is the column name in the 'tbl_room' table
    
        // Check if the delete operation was successful
        if ($result) {
            // If successful, send a success message with the response
            $this->db->success(["message" => "Student deleted successfully", "userID" => $id]);
        } else {
            // If deletion failed, send an error message
            $this->db->error(["message" => "Failed to delete Student", "userID" => $id]);
        }
    }    
    
}
?>