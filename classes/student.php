<?php

class Student
{
    // These will accessed using API's
    public $name;
    public $email;
    public $mobile;
    public $id;
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

    // update student information
    public function update_student()
    {
        // Query
        $update_query = "UPDATE " . $this->table_name ." SET name = ?, email = ?, mobile = ? " . "WHERE id = ?";
        // prepare statement
        $query_object = $this->conn->prepare($update_query);
        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // binding parameters
        $query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

        // execute query
        if($query_object->execute())
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    // delete student
    public function delete_student()
    {
        // Query
        $delete_query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // Prepare query 
        $delete_obj = $this->conn->prepare($delete_query);

        // sanitization
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameter
        $delete_obj->bind_param("i", $this->id);

        // executing querys
        if($delete_obj->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>