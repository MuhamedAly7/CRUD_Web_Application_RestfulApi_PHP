<?php

// include headers
header("Access-Control-Allow-Origin: *");
// Data which we are getting inside request
header("Access-Contol-Allow-Methods: GET");
// Method type 



include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();

// Create object for student
$student = new Student($db);

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $student_id = isset($_GET['id']) ? intval($_GET['id']) : "";
    if(!empty($student_id))
    {
        $student->id = $student_id;
        $student_data = $student->get_single_student();
        if(!empty($student_data))
        {
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "data" => $student_data
            ));
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
