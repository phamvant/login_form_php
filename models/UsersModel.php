<?php
require_once '../connection.php';

class UsersModel {

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // public function view_content(){
    //     $this->db->query('SELECT * FROM nhanvien');

    // }

    //Find user by email or username

    public function view(){
        $this->db->query('SELECT * FROM nhanvien');
        $row = $this->db->single();
        return $row;
    }
    public function findUserByEmailOrUsername($email, $username){
        $this->db->query('SELECT * FROM users WHERE usersUid = :username OR usersEmail = :email');
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        // exit();
        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    //Register User
    public function register($data){
        $this->db->query('INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) 
        VALUES (:name, :as, :Uid, :password)');
        //Bind values

        $this->db->bind(':name', $data['usersName']);
        $this->db->bind(':as', $data['usersEmail']);
        $this->db->bind(':Uid', $data['usersUid']);
        $this->db->bind(':password', $data['usersPwd']);
        // echo 'Not';
        // exit();
        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Login user
    public function login($nameOrEmail, $password){
        $row = $this->findUserByEmailOrUsername($nameOrEmail, $nameOrEmail);
 
        if($row == false) return false;

        $hashedPassword = $row->usersPwd;

        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }

    //Reset Password
    public function resetPassword($newPwdHash, $tokenEmail){
        $this->db->query('UPDATE users SET usersPwd=:pwd WHERE usersEmail=:email');
        $this->db->bind(':pwd', $newPwdHash);
        $this->db->bind(':email', $tokenEmail);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}