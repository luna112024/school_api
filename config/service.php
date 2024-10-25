<?php
require_once("../school_api/config/connection.php");
header('Content-Type: application/json; charset=utf-8');

// CORS headers
header("Access-Control-Allow-Origin: http://localhost:8100"); // Allow requests from Angular/Ionic app
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow these HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With"); // Allow specific headers

// Handle preflight (OPTIONS) request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // Return 200 OK for preflight
    exit();
}
class service {
    private $pro_conn, $pro_sql, $pro_cmd, $pro_count, $pro_result, $pro_arr, $pro_record, $pro_target;
    public $databaseConnection;

    function __construct()
    {
    //    $this->databaseConnection = $databaseConnection;
       $this->pro_conn = new connection();
    }

    // public function insert($table, $columns) {
	// 	$tmpCol = array();
	// 	$tmpVal = array();
	// 	foreach ($columns as $k => $v) {
	// 		$tmpCol[] = $k;
	// 		$tmpVal[] = $v;
	// 	}
		
	// 	$q = "INSERT INTO " . $table . " (" . implode(",", $tmpCol) . ") VALUES ('" . implode("','", $tmpVal) . "');";
		
	// 	return $this->query($q);
	// }

    function save($table_name, $data) {
        $fields = array();
        $values = array();

        foreach ($data as $k => $v) {
            $fields[] = $k;
            $values[] = $v;
        }

        $this->pro_sql = "INSERT INTO " . $table_name . " (" . implode(", ", $fields) . ") VALUES ('" . implode("', '", $values) . "');";
        $this->pro_cmd = mysqli_query($this->pro_conn->get_connection(), $this->pro_sql);

        if ($this->pro_cmd == 1) {
            $this->pro_result = true; 
        } else {
            $this->pro_result = false; 
        }
        
        return $this->pro_result;
    }

    function update($table_name, $data, $con) {
        $tmp = array();

        foreach ($data as $k => $v) {
            $tmp[] = "$k = '$v'";
        }

        $this->pro_sql = "UPDATE " . $table_name . " SET " . implode(", ", $tmp) . " $con ";
        $this->pro_cmd = mysqli_query($this->pro_conn->get_connection(), $this->pro_sql);

        if ($this->pro_cmd == 1) {
            $this->pro_result = true;
        } else {
            $this->pro_result = false; 
        }
        
        return $this->pro_cmd;
    }

    // function fun_insertData($par_table, $par_fields, $par_value)
    // {
    //     $this->pro_conn = new connection();

    //     $this->pro_count = count($par_fields);
    //     $this->pro_sql = "INSERT INTO $par_table(";
    //     for ($x = 0; $x < $this->pro_count; $x++) {
    //         $this->pro_sql .= $par_fields[$x];
    //         if ($x < ($this->pro_count - 1)) {
    //             $this->pro_sql .= ",";
    //         } else {
    //             $this->pro_sql .= ") VALUES(";
    //         }
    //     }
    //     for ($x = 0; $x < $this->pro_count; $x++) {
    //         $this->pro_sql .= "'$par_value[$x]'";
    //         if ($x < ($this->pro_count - 1)) {
    //             $this->pro_sql .= ",";
    //         } else {
    //             $this->pro_sql .= ")";
    //         }

    //         //command SQL statement to db
    //         $this->pro_cmd = mysqli_query($this->pro_conn->get_connection(), $this->pro_sql);
    //         if ($this->pro_cmd == 1) {
    //             $this->pro_result = true;
    //         } else {
    //             $this->pro_result = false;
    //         }
    //         // Accessing close connection
    //         $this->pro_conn->fun_closecon();
    //     }
    // }

    // function Show data
    function getData($par_table, $par_field = null)
    {
        $this->pro_conn = new connection();

        //create empty array
        $this->pro_arr = array();
        //create sql statement
        $this->pro_sql = "SELECT *FROM $par_table Order By $par_field DESC";
        //command sql Statement to database server
        $this->pro_cmd = mysqli_query($this->pro_conn->get_connection(), $this->pro_sql);
        while ($this->pro_record = mysqli_fetch_assoc($this->pro_cmd)) {
            array_push($this->pro_arr, $this->pro_record);
        }
        return $this->pro_arr;
    }
    // function find record
    function getDataById($par_table,$par_arrfield,$par_arrvalue) 
    {
        $this->pro_conn = new connection();
        //create empty array
        $this->pro_arr = array();
        //create sql statement
        $this->pro_sql = "SELECT *FROM $par_table WHERE $par_arrfield='$par_arrvalue'";
        //command sql Statement to database server
        $this->pro_cmd = mysqli_query($this->pro_conn->get_connection(), $this->pro_sql);
        $this->pro_record = mysqli_fetch_assoc($this->pro_cmd);
        return $this->pro_record;
    }

    function delete($arg_table,$arg_fid,$arg_vid)
    {
        $this->pro_conn = new connection();

        $this->pro_sql = "DELETE FROM $arg_table WHERE $arg_fid=$arg_vid";
        //Send / Command Sql Statement to Database Server
        $this->pro_cmd = mysqli_query($this->pro_conn->get_connection(), $this->pro_sql);
        if($this->pro_cmd){
            return true;
        }else{
            return false;
        }
    }

}
?>