<?php 
   require_once("../school_api/path.php");
   require_once(APP_PATH_CONNECTION . "/connection.php");
   require_once(APP_PATH_SERVICE . "/service.php");

   class teacher {
    private $db ,$service,$last_id;
    function __construct() {
        $this->db = new connection();
        $this->service = new service($this->db);
    }
    function getList() {
        $res = $this->service->getData("tbl_teacher", "id");
        $this->db->success($res);
     }
 
     function save($teacher) {
         // convert data to array object by decode params
         $jsonString = json_encode($teacher);
         $teachers = json_decode($jsonString);
 
         $data = array (
             "teacher_id" => $teachers->0,
             "khmer_name" => $teachers->khmer_name,
             "english_name" => $teachers->english_name,
             "gender" => $teachers->gender,
             "dob"=>$teachers->dob,
             "nationality"=> $teachers->nationality,
             "pob"=>$teachers->pob,
             "address"=>$teachers->address,
             "phone_number1"=>$teachers->phone_number1,
             "phone_number2"=>$teachers->phone_number2m
             "is_deleted"=>$teachers->0
         );
 
         if (isset($teachers->id) == 0) {
             $res = $this->service->save("tbl_teacher", $data);
             $teachers->id = $this->db->last_id;
         } else {
             $res = $this->service->update("tbl_teacher", $data, "WHERE id = $teachers->id ");
         }
         return $res;
     } 
     function load($id) {
         $res = $this->service->getDataById("tbl_teacher", "id", $id);
         $this->db->success($res);
     }
 
     function deleteById($id) {
         // Call the delete function from service.php
         $result = $this->service->delete("tbl_teacher", "id", $id); // Assuming 'id' is the column name in the 'tbl_room' table
     
         // Check if the delete operation was successful
         if ($result) {
             // If successful, send a success message with the response
             $this->db->success(["message" => "Room deleted successfully", "roomId" => $id]);
         } else {
             // If deletion failed, send an error message
             $this->db->error(["message" => "Failed to delete room", "roomId" => $id]);
         }
     }    
     
   }
?>