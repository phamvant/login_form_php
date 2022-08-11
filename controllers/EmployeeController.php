<?php
    require_once '/home/thuan/login_form_php/models/EmployeeModel.php';
    require_once '/home/thuan/login_form_php/helpers/session_helper.php';
    require_once('/home/thuan/login_form_php/controllers/BaseController.php');
    require_once('/home/thuan/login_form_php/connection.php');

class EmployeeController extends BaseController
{
        
    public EmployeeModel $employeeModel;
    public string $test;
        
    public function __construct(){
        $this->employeeModel = new EmployeeModel;
        $this->test = 'test';
    }

    public function getE(){
        return $this->employeeModel->getEmployee();
    }

    public function getEr($id){
        return $this->employeeModel->getEmployee_read($id);
    }

    public function create(){
        // $db = new Database;

        // Define variables and initialize with empty values
        $name = $address = $salary = "";
        $name_err = $address_err = $salary_err = "";
        
        // Processing form data when form is submitted
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Validate name
            $input_name = trim($_POST["name"]);
                $name = $input_name;

            $input_address = trim($_POST["address"]);
                $address = $input_address;
        
            $input_salary = trim($_POST["salary"]);
                $salary = $input_salary;
                
            if((!preg_match("/^[a-zA-Z]*$/", $input_name))) {
                flash('create', 'Name can not contain symbol or number');
                header("location: ../index.php?controller=pages&action=create");
                exit();
            }

            if((!preg_match("/^[0-9]*$/", $input_salary))) {
                flash('create', 'Salary must be a number');
                header("location: ../index.php?controller=pages&action=create");
                // exit();
            }
        

        if($this->employeeModel->create_db($name,  $address,  $salary)){
                header("location: ../index.php?controller=pages&action=index");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        }


    public function delete(){
        if(isset($_POST["id"]) && !empty($_POST["id"])){
            // header("location: error.php");
                if($this->employeeModel->delete_db(trim($_POST["id"]))){
                    // Records deleted successfully. Redirect to landing page
                    header("location: ../index.php?controller=pages&action=index");
                    // exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                    header("location: error.php");
                }
        
            // unset($db);
        } else{
            // Check existence of id parameter
            if(empty(trim($_GET["id"]))){
                // URL doesn't contain id parameter. Redirect to error page
                header("location: index.php");
                exit();
            }
        }
    }

    public function update() {
    $db = new Database;
    // Include config file
    // Define variables and initialize with empty values
    $name = $address = $salary = "";
    $name_err = $address_err = $salary_err = "";

    // Processing form data when form is submitted
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        // Get hidden input value
        $id = $_POST["id"];

        // Validate name
        $input_name = trim($_POST["name"]);
            $name = $input_name;

        // Validate address address
        $input_address = trim($_POST["address"]);
            $address = $input_address;

        // Validate salary
        $input_salary = trim($_POST["salary"]);
            $salary = $input_salary;

        // Check input errors before inserting in database
        if(empty($name_err) && empty($address_err) && empty($salary_err)){
            // Prepare an update statement
            $db->query("UPDATE nhanvien SET name=:name, address=:address, salary=:salary WHERE id=:id");

            // if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $db->bind(":name", $name);
                $db->bind(":address", $address);
                $db->bind(":salary", $salary);
                $db->bind(":id", $id);

                // Attempt to execute the prepared statement
                if($db->stmt->execute()){
                    // Records updated successfully. Redirect to landing page
                    header("location: ../index.php?controller=pages&action=index");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            // }
        }

        // Close connection
        unset($db);
    } else{

        // Check existence of id parameter before processing further
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Get URL parameter
            $id =  trim($_GET["id"]);
            // Prepare a select statement
            $db->query("SELECT * FROM nhanvien WHERE id = :id");
            // if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $db->bind(":id", $id);
                // Set parameters

                // Attempt to execute the prepared statement
                if($db->stmt->execute()){
                    // if($stmt->rowCount() == 1){
                        /* Fetch result row as an associative array. Since the result set
                        contains only one row, we don't need to use while loop */
                        $row = $db->stmt->fetch(PDO::FETCH_OBJ);

                        // Retrieve individual field value
                        $name = $row["name"];
                        $address = $row["address"];
                        $salary = $row["salary"];

                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            // }

            unset($db);
        }  else {
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }
    }

    // public function read() {
    //     // Check existence of id parameter before processing further
    //     $db = new Database;
    //     if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    //         // Include config file
    //         // require_once "config.php";

    //         // Prepare a select statement
    //         $db->query("SELECT * FROM nhanvien WHERE id = :id");

    //         // if($stmt = $pdo->prepare($sql)){
    //             // Bind variables to the prepared statement as parameters
    //             $db->bind(":id", $param_id);

    //             // Set parameters
    //             $param_id = trim($_GET["id"]);

    //             // Attempt to execute the prepared statement
    //             if($db->stmt->execute()){
    //                 if($db->stmt->rowCount() == 1){
    //                     /* Fetch result row as an associative array. Since the result set
    //                     contains only one row, we don't need to use while loop */
    //                     $row = $db->stmt->fetch(PDO::FETCH_ASSOC);

    //                     // Retrieve individual field value
    //                     $name = $row["name"];
    //                     $address = $row["address"];
    //                     $salary = $row["salary"];
                        
                        
    //                 } else{
    //                     // URL doesn't contain valid id parameter. Redirect to error page
    //                     header("location: index.php");
    //                     exit();
    //                 }

    //             } else{
    //                 echo "Oops! Something went wrong. Please try again later.";
    //             }
    //         }

    //         // Close statement
    //         // unset($stmt);

    //         // Close connection
    //         // unset($pdo);
    // }
}

$init = new EmployeeController;

    // Ensure that user is sending a post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pcase = $_POST['type'];
    $init->$pcase();
}