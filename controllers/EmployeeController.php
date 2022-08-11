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
    }


    public function index() {
        $this->render('index', $this->employeeModel->getEmployee());
    }

    public function read() {
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $row = $this->employeeModel->getEmployee_read(trim($_GET["id"]))->fetch(PDO::FETCH_ASSOC);
        }
        $this->render('read', $row);
    }

    public function create(){

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
                header("location: ../index.php?controller=employee&action=create");
                exit();
            }

            if((!preg_match("/^[0-9]*$/", $input_salary))) {
                flash('create', 'Salary must be a number');
                header("location: ../index.php?controller=employee&action=create");
                // exit();
            }
        
        if($this->employeeModel->create_db($name,  $address,  $salary)){
                header("location: ../index.php?controller=employee&action=index");
                // $this->render('index');
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }     
        $this->render('create');   
    }


    public function delete(){
        if(isset($_POST["id"]) && !empty($_POST["id"])){
           
                if($this->employeeModel->delete_db(trim($_POST["id"]))){
                  
                    header("location: ../index.php?controller=employee&action=index");
                    // exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                    header("location: error.php");
                }
        
        } else{
            // Check existence of id parameter
            if(empty(trim($_GET["id"]))){
                // URL doesn't contain id parameter. Redirect to error page
                header("location: index.php");
                exit();
            }
        }
        $this->render('delete');
    }

    public function update() {
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
            if($this->employeeModel->update_db($name, $address, $salary, $id)){
                    // Records updated successfully. Redirect to landing page
                    header("location: ../index.php?controller=employee&action=index");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            // }
        }

    } else{
        // Check existence of id parameter before processing further
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Get URL parameter

            $id =  trim($_GET["id"]);

        $row = $this->employeeModel->getEmployee_read($id);

        }  else {
            header("location: error.php");
            // exit();
        }
    }
    $this->render('update', $row);
    }

}

$init = new EmployeeController;

    // Ensure that user is sending a post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pcase = $_POST['type'];
    $init->$pcase();
}