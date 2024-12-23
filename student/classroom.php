<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class classroom {
    private $db, $service, $last_id;

    function __construct()
    {
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    function getList() {
       $res = $this->service->getData("tbl_class", "id");
       $this->db->success($res);
    }

    function save($class) {
        // Convert data to array object by decode params
        $jsonString = json_encode($class);
        $classes = json_decode($jsonString);

        $data = array (
            "class_name" => $classes->class_name,
            "description" => $classes->description,
            "is_deleted" => 0
        );

        if (isset($classes->id) == 0) {
            $res = $this->service->save("tbl_class", $data);
            $classes->id = $this->db->last_id;
        } else {
            $res = $this->service->update("tbl_class", $data, "WHERE id = $classes->id ");
        }
        return $res;
    } 

    function load($id) {
        $res = $this->service->getDataById("tbl_class", "id", $id);
        $this->db->success($res);
    }

    function deleteById($id) {
        // Call the delete function from service.php
        $result = $this->service->delete("tbl_class", "id", $id);

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
