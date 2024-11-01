<?php 
require_once('models/baseModel.php');
class Friend extends BaseModel{
    private $table_name = 'users';
    public function __construct(){
        parent::__construct();
    }
    public function listUser(){
        try{
            $sql = "SELECT username,fullname,id,role FROM $this->table_name WHERE role=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $users = array();
            while($row = $result->fetch_assoc()){
                $users[] = (object) $row;
            }
            return $users;
        }
        catch(Exception $e){
            return false; //
        }
        return null;
    }

}