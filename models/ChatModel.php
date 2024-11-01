<?php 
require_once('models/baseModel.php');
class Chat extends BaseModel{
    private $table_name = 'messages';
    public function __construct(){
        parent::__construct();
    }
    public function chatUser($name = ''){
        $user_id = $_SESSION['userId'];
        try{
            if($name===''){
                $sql = "SELECT username,fullname,id,profile_picture,status FROM users WHERE id <> ? AND role = 0";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
            }
            else {
                $sql = "SELECT username,fullname,id,profile_picture,status FROM users
                        WHERE id <> ? AND role = 0 AND LOWER(fullname) LIKE LOWER(?)
                        order by fullname";
                $name = '%'.$name.'%';
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("is", $user_id,$name);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    $row['message'] = $this->message_waiting($row['id']);
                    $user[] =$row;
                }
                $stmt->close();
                return $user;
            }
            $stmt->close();
            return null;
        }
        catch(Exception $e){
            return null;
        }    
    }
    public function Userid($id){
        try{
            $sql = "SELECT username,fullname,id,status,profile_picture FROM users WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows >0){
                $row = $result->fetch_assoc();
                return $row;
            } 
            return null;
           
        }
        catch(Exception $e){
            return null; //
        }
        return null;
    }
    public function message_waiting($userB){
        try{
            $userA = $_SESSION["userId"];
            $sql = "SELECT message,image_path,sender_id
            FROM $this->table_name WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiii", $userA, $userB, $userB, $userA);
            $stmt->execute();
            $query = $stmt->get_result();
            if($query->num_rows > 0){
                $row = $query->fetch_assoc();
                $stmt->close();
                $result ='';
                if($row['sender_id'] == $userA) $result = 'you :';
                if($row['image_path']){
                    $result .=' send images';
                }
                else  $result .= strlen($row['message']) > 28 ? substr($row['message'],0,25).'...' : $row['message'] ;
                return  $result;
            }
            return 'No message available';

        }
        catch(Exception $e){
            return null;
        }
        return null;     
}
    public function sendMessage($message,$image,$incoming_id){
       try{
        $send_id= $_SESSION['userId'];
        $message = $message??"";
        if($image === null){
            
            $sql = "INSERT INTO $this->table_name (message, sender_id, receiver_id) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii",  $message, $send_id, $incoming_id);
            $stmt->execute();
            $data['messageId'] = $stmt->insert_id;
            $data['message'] = $message;
            $data['image'] = '';
            return $data;
        }
        
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newFileName =  $send_id. '_' . time() . '.' . $extension;
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/fb/public/images/' . $newFileName;    
        if(move_uploaded_file($image['tmp_name'],  $uploadDir)) {
            $sql = "INSERT INTO $this->table_name (image_path ,message, sender_id, receiver_id) VALUES ( ?, ?,?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssii", $newFileName, $message, $send_id, $incoming_id);
            $stmt->execute();
            $data['messageId'] = $stmt->insert_id;
            $data['message'] = $message;
            $data['image'] = $newFileName;
            return $data;
        } 

       }
       catch(Exception $e){
        
            return null;
       }
       return null;
    }
    public function getMessages($incoming_id){
        try{
            $id = $_SESSION['userId'];
            $sql = "SELECT *
            FROM $this->table_name WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiii", $id, $incoming_id, $incoming_id, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                $stmt->close();
                return $data;
            }
        }
        catch(Exception $e){
            return null;
        }
        return null;
}
}
?>
