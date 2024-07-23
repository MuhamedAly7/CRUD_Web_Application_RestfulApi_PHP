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
    $student_id = isset($_GET['id']) ? $_GET['id'] : "";
    if(!empty($student_id))
    {
        $student->id = $student_id;
        if($student->delete_student())
        {
            http_response_code(200); // OK
            echo json_encode(array(
                "status" => 1,
                "message" => "Student has been deleted successfully!"
            ));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to delete student"
            ));
        }
    }
    else
    {
        http_response_code(404);
        echo json_encode(array(
            "status" => 0,
            "message" => 'All data needed'
        ));        
    }
}
else
{
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => 'Access Denied'
    ));
}

?>