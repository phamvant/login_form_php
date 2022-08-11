<?php
require_once '/home/thuan/login_form_php/connection.php';

class EmployeeModel
{

    public Database $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getEmployee(){
        $this->db->query("SELECT * FROM nhanvien");
        if($this->db->execute()) {
            return $this->db->stmt;;
        } else {
            return false;
        }
    }

    public function getEmployee_read($id){
        $this->db->query("SELECT * FROM nhanvien WHERE id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        return $this->db->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create_db($name,  $address,  $salary){
        $this->db->query("INSERT INTO nhanvien (name, address, salary) VALUES (:name, :address, :salary)");
        // if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
        $this->db->bind(":name", $name);
        $this->db->bind(":address", $address);
        $this->db->bind(":salary", $salary);

        if($this->db->stmt->execute()){
            return true;
        }else
            return false;
    }

    public function delete_db($id) {
        $this->db->query("DELETE FROM nhanvien WHERE id = :id");
        $this->db->bind(":id", $id);
        if($this->db->stmt->execute()){
            return true;
        }else
            return false;
    }

    public function update_db($name, $address, $salary, $id) {
        $this->db->query("UPDATE nhanvien SET name=:name, address=:address, salary=:salary WHERE id=:id");

    // if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $this->db->bind(":name", $name);
        $this->db->bind(":address", $address);
        $this->db->bind(":salary", $salary);
        $this->db->bind(":id", $id);
        if($this->db->stmt->execute()) {
            return true;
        }else {
            return false;
        }
    }
    
}