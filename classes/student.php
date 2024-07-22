<?php

class Student
{
    // These will accessed using API's
    public $name;
    public $email;
    public $mobile;
    //--------------------------
    private $conn;
    private $table_name;

    // Passing database connection object variable
    public function __construct($db)
    {
        $this->conn = $db->connect();
        $this->table_name = "tbl_students";
    }

    public function create_data()
    {
        // Here we will write SQL query to insert data inside our database
        $query = "INSERT INTO " . $this->table_name . " SET name = ?, email = ?, mobile = ?";

        // Prepare the sql
        $obj = $this->conn->prepare($query);

        // "Sanitize" input variable => basically remove the extra characters
        // like some special symbols as well as if some tags available in input variables
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        // binding out parameters
        $obj->bind_param("sss", $this->name, $this->email, $this->mobile);

        if($obj->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // read all data
    public function get_all_data()
    {
        $sql_query = "SELECT * FROM " . $this->table_name;
        $std_obj = $this->conn->prepare($sql_query);

        // execute query
        $std_obj->execute();

        // return the result data
        return $std_obj->get_result();
    }


    // read single student data
    public function get_single_student()
    {
        $sql_query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $obj = $this->conn->prepare($sql_query);
        $obj->bind_param("i", $this->id);
        $obj->execute();

        $data = $obj->get_result();

        return $data->fetch_assoc();
    }
}

?>