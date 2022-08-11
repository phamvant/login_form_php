<?php
    require_once '/home/thuan/login_form_php/models/UsersModel.php';
    require_once '/home/thuan/login_form_php/helpers/session_helper.php';
    require_once '/home/thuan/login_form_php/controllers/BaseController.php';
    require_once '/home/thuan/login_form_php/connection.php';

    class UsersController extends BaseController{

        private UsersModel $userModel;
        public string $test;

        public function __construct(){
            $this->userModel = new UsersModel;
            $this->test = "test";
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
                flash("register", "Please fill out all inputs");
                redirect("../index.php?controller=pages&action=signup");
            }

            if(!preg_match("/^[a-zA-Z0-9]*$/", $data['usersUid'])){
                flash("register", "Invalid username");
                redirect("../index.php?controller=pages&action=signup");
            }

            if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Invalid email");
                redirect("../index.php?controller=pages&action=signup");
            }

            if(strlen($data['usersPwd']) < 6){
                redirect("../index.php?controller=pages&action=signup");
                flash("register", "Invalid password");
            } else if($data['usersPwd'] !== $data['pwdRepeat']){
                flash("register", "Passwords don't match");
                redirect("../index.php?controller=pages&action=signup");
            }

            //User with the same email or password already exists
            if($this->userModel->findUserByEmailOrUsername($data['usersEmail'], $data['usersName'])){
                flash("register", "Username or email already taken");
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


        // if(empty($data['name/email']) || empty($data['usersPwd'])){
        //     redirect("../index.php");
        //     exit();
        // }

        //Check for user/email
        if($this->userModel->findUserByEmailOrUsername($data['name/email'], $data['name/email'])){
            //User Found
            
            $loggedInUser = $this->userModel->login($data['name/email'], $data['usersPwd']);
            if($loggedInUser){

                $this->createUserSession($loggedInUser, $data);
            }else{
                flash("login", "Wrong Username/Password");
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
        header("location: ../index.php?controller=employee&action=index");
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
        $_SESSION = [];
        header("location: ../index.php");
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
