<?php 
require_once('models/baseModel.php');
class Account extends BaseModel{
    private $table_name = 'users';
    public function __construct(){
        parent::__construct();
    }
    public function createUser($username, $password, $fullname,$mobile,$role=0) {
        //! tạo người dùng 
        try{
            $sql = "INSERT INTO $this->table_name SET username=?,password=PASSWORD(?),fullname=?,mobile=?,role=?,status=1";
            $stmt = $this->conn->prepare($sql); //! chuẩn bị câu truy vấn 
            $stmt->bind_param("sssss",$username,$password,$fullname,$mobile,$role); 
            $stmt->execute();
            $id = $stmt->insert_id;
        }
        catch(Exception $e){
            return false; //
        }
        return true;
    }
    //! hàm check sự tồn tại của username
    //! true là chưa tồn tại hợp lệ để thêm vào database
    public function checkUsername($username){
        try{
            $sql = "SELECT * FROM $this->table_name WHERE username=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows > 0;
        }
        catch(Exception $e){
            return false; //
        }
        return true;
    }
   
    //!hàm xác thực mật khẩu và tài khoảng 
    public function authenticate($username,$password){
        try{
            $sql = "SELECT * FROM $this->table_name WHERE username=? AND password=PASSWORD(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $username,$password);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
            if($user = $result->fetch_assoc()){
                
				return (object) $user; //! để xử lý session
	         
			}
        }
        else {
           return  false; //
        }
        }
        catch(Exception $e){
            return false; //
        }
        return true;
    }
    
    public function status($enum=0){
        //! gán status = 0;
        try{
            $sql = "UPDATE $this->table_name SET status=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii",$enum, $_SESSION['userId']);
            $stmt->execute();
            return true;
        }
        catch(Exception $e){
            return false; //
        }
        return false;
    }
    
    
}



?>