<?php

// include headers
header("Access-Control-Allow-Origin: *"); 
// It allow all origings like localhost, any domain or any subdomain
header("Content-type: application/jason; charset=UTF8");
// Data which we are getting inside request
header("Access-Contol-Allow-Methods: POST");
// Method type 



include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();

// Create object for student
$student = new Student($db);

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $data = json_decode(file_get_contents("php://input"));
    

    if(!empty($data->name) && !empty($data->email) && !empty($data->mobile))
    {
        // submit data
        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile = $data->mobile;
    
        if($student->create_data())
        {
            http_response_code(200); // 200: status code Ok
            echo json_encode(array(
                "status" => 1,
                "message" => 'Student has been created!'
            ));
        }
        else
        {
            http_response_code(500); // 500: status code internal server error
            echo json_encode(array(
                "status" => 0,
                "message" => 'Failed to insert student!'
            ));
        }
    }
    else
    {
        http_response_code(404); // 404: status code page not found
        echo json_encode(array(
            "status" => 0,
            "message" => 'All values needed!'
        ));
    }
}
else
{
    http_response_code(503); // 503: status code service unavailable
    echo json_encode(array(
        "status" => 0,
        "message" => 'Access denied!'
    ));
}

?>
