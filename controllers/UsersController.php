<?php
    require_once '../models/UsersModel.php';
    require_once '../helpers/session_helper.php';
    require_once('../controllers/BaseController.php');
    require_once('../connection.php');

    class UsersController extends BaseController{

        private $userModel;
        
        public function __construct(){
            $this->userModel = new UsersModel;
            $this->folder = 'pages';
        }

        public function register(){
            //Process form
            
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data = [
                'usersName' => trim($_POST['usersName']),
                'usersEmail' => trim($_POST['usersEmail']),
                'usersUid' => trim($_POST['usersUid']),
                'usersPwd' => trim($_POST['usersPwd']),
                'pwdRepeat' => trim($_POST['pwdRepeat'])
            ];
 
            //Validate inputs
            if(empty($data['usersName']) || empty($data['usersEmail']) || empty($data['usersUid']) || 
            empty($data['usersPwd']) || empty($data['pwdRepeat'])){
                redirect("../index.php?controller=pages&action=signup");
            }

            if(!preg_match("/^[a-zA-Z0-9]*$/", $data['usersUid'])){
                redirect("../index.php?controller=pages&action=signup");
            }

            if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
                redirect("../index.php?controller=pages&action=signup");
            }

            if(strlen($data['usersPwd']) < 6){
                redirect("../index.php?controller=pages&action=signup");
            } else if($data['usersPwd'] !== $data['pwdRepeat']){
                redirect("../index.php?controller=pages&action=signup");
            }

            //User with the same email or password already exists
            if($this->userModel->findUserByEmailOrUsername($data['usersEmail'], $data['usersName'])){
                redirect("../index.php?controller=pages&action=signup");
            }

            //Passed all validation checks.
            //Now going to hash password
            $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

            //Register User
            if($this->userModel->register($data)){
                redirect("../index.php");
            }else{
                die("Something went wrong");
            }
        }

    public function login(){
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data=[
            'name/email' => trim($_POST['name/email']),
            'usersPwd' => trim($_POST['usersPwd']),
            'remember'=> ((isset($_POST['remember'])!=0)?1:"")
        ];

        if(strlen($data['usersPwd']) < 6){
            flash("login", "Invalid Pwd");
            redirect("../index.php?controller=pages&action=login");
        }


        if(empty($data['name/email']) || empty($data['usersPwd'])){
            redirect("../index.php");
            exit();
        }

        //Check for user/email
        if($this->userModel->findUserByEmailOrUsername($data['name/email'], $data['name/email'])){
            //User Found

            $loggedInUser = $this->userModel->login($data['name/email'], $data['usersPwd']);
            if($loggedInUser){

                $this->createUserSession($loggedInUser, $data);
            }else{
                redirect("../index.php?controller=pages&action=login");
            }
        }else{
            redirect("../index.php?controller=pages&action=login");
        }
    }
    

    public function createUserSession($user, $data){
        $_SESSION['usersId'] = $user->usersId;
        $_SESSION['usersName'] = $user->usersName;
        $_SESSION['usersEmail'] = $user->usersEmail;
        // redirect("../index.php");
        header("location: ../index.php?controller=pages&action=index");
        if(isset($_POST['remember'])){
            setcookie("name/email", $data['name/email'], time()+3600*24, '/');
            setcookie("usersPwd", $data['usersPwd'], time()+3600*24, '/');
        }
        else {
            setcookie("name/email", "", 0, '/');
            setcookie("usersPwd", "", 0, '/');
        }
    }

    public function logout(){
        unset($_SESSION['usersId']);
        unset($_SESSION['usersName']);
        unset($_SESSION['usersEmail']);
        session_destroy();
        redirect("../index.php");
    }

    public function create(){
        $db = new Database;

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
        
                $db->query("INSERT INTO nhanvien (name, address, salary) VALUES (:name, :address, :salary)");
                // if($stmt = $db->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $db->bind(":name", $name);
                    $db->bind(":address", $address);
                    $db->bind(":salary", $salary);

                    if($db->stmt->execute()){

                        header("location: ../index.php?controller=pages&action=index");
                        exit();
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }
        
                // Close statement
                // unset($stmt);
                unset($db);
            }
        
            // Close connection

    public function delete(){
        if(isset($_POST["id"]) && !empty($_POST["id"])){
            // Include config file
            // require_once "config.php";
            $db = new Database;
            // Prepare a delete statement
            $db->query("DELETE FROM nhanvien WHERE id = :id");
        
            // if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $db->bind(":id", trim($_POST["id"]));
        
                // Set parameters
                // Attempt to execute the prepared statement
                if($db->stmt->execute()){
                    // Records deleted successfully. Redirect to landing page
                    header("location: ../index.php?controller=pages&action=index");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
        
        
            // Close statement
            // unset($stmt);
        
            // Close connection
            unset($db);
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

            // Close statement
            // unset($stmt);
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
                    // } else{
                    //     // URL doesn't contain valid id. Redirect to error page
                    //     header("location: error.php");
                    //     exit();
                    // }

                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            // }

            // Close statement
            // unset($stmt);

            // Close connection
            unset($db);
        }  else {
            // URL doesn't contain id parameter. Redirect to error page
            header("location: index.php");
            exit();
        }
}
    }
}


    

    $init = new UsersController;

    // Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $pcase = $_POST['type'];
        $init->$pcase();

    }else{
        switch($_GET['q']){
            case 'logout':
                $init->logout();
                break;
            default:
            redirect("../index.php");
        }
    }
