<?php 
class BaseModel {
    private $severname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "secad_project";
    public $conn = null;
     function __construct()   
     {
        //! tạo kết nói
        $this->conn = new mysqli($this->severname, $this->username, $this->password, $this->dbname);
        //! kiểm tra kết nối
        if(!$this->conn){
            die("Connection failed : " .$this->conn->connect_error());
        }
        else "Connected successfully";
    }
    function __destruct(){
        try{
            $this->conn->close(); //! ngắt kết nối
        }
        catch(Exception $e){
            echo "Error: ". $e->getMessage()."\n"; //! thông báo lỗi 
        }
    }
}

?>