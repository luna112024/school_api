<?php
require_once("../school_api/path.php");
require_once(APP_PATH_CONNECTION . "/connection.php");
require_once(APP_PATH_SERVICE . "/service.php");

class student {

    public $service, $db;

    function __construct()
    {
        // call connection
        $this->db = new connection();
        $this->service = new service($this->db);
    }

    /** Save Student */
    function save($students) {   

        $data = array (
            "student_id" => isset($students->student_id) ? $students->student_id : "",
            "khmer_name" => isset($students->khmer_name) ? $students->khmer_name : ""
        );
        
        // call funtion save
        $res = $this->service->save("tbl_student", $data);
        $this->db->success($res);
    }

    /** Get Student List */
    function get_list() {
        $res = $this->service->fun_showdata("tbl_student", "id");
        print json_encode($res);
    }
}
?>
