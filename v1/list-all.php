<?php

// include headers
header("Access-Control-Allow-Origin: *"); 
// It allow all origings like localhost, any domain or any subdomain
header("Access-Contol-Allow-Methods: GET");
// Method type 



include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();

// Create object for student
$students = new Student($db);

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $data = $students->get_all_data();
    if($data->num_rows > 0)
    {
        // So here we have some data inside table
        $student["records"] = array();
        while($row = $data->fetch_assoc())
        {
            array_push($student["records"], array(
                "id" => $row['id'],
                "name" => $row['name'],
                "email" => $row['email'],
                "mobile" => $row['mobile'],
                "status" => $row['status'],
                "created_at" => date("Y-m-d",strtotime($row['created_at']))
            ));
        }

        http_response_code(200); // OK status code
        echo json_encode(array(
            "status" => 1,
            "data" => $student["records"]
        ));
    }
}
else
{
    http_response_code(503); // Service Unavailable status code
    echo json_encode(array(
        "status" => 0,
        "message" => 'Access denied!'
    ));
}

?>
