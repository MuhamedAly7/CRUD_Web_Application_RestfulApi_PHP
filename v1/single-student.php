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

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $param = json_decode(file_get_contents("php://input"));
    if(!empty($param->id))
    {
        $student->id = $param->id;
        $student_data = $student->get_single_student();
        if(!empty($student_data))
        {
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "data" => $student_data
            ));
            // print_r($student_data);
        }
        else
        {
            http_response_code(404); // 404: status code page not found
            echo json_encode(array(
                "status" => 0,
                "message" => 'Student not found!'
            ));
        }
    }
    else
    {
        http_response_code(404); // 404: status code page not found
        echo json_encode(array(
            "status" => 0,
            "message" => 'Student ID needed!'
        ));
    }
}
else
{
    http_response_code(503); // Service unavailable
    echo json_encode(array(
        "status" => 0,
        "message" => 'Access Denied'
    ));
}

?>
