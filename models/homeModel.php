<?php 
require_once('models/baseModel.php');
class Home extends BaseModel{
    private $table_name = 'users';
    public function __construct(){
        parent::__construct();
    }
    public function Image($id){
        try{
            $sql = "SELECT profile_picture FROM $this->table_name WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['profile_picture'];
        }
        catch(Exception $e){
            return false;
        }
        return null;
    }
    public function Update($id,$image){
        try{
             // Tạo tên tệp mới bằng cách kết hợp id và thời gian
             // Lấy phần mở rộng của tệp (ví dụ: .jpg, .png)
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newFileName = $id . '_' . time() . '.' . $extension;
            // Đường dẫn lưu tệp
            
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/fb/public/images/' . $newFileName;
           
            if(move_uploaded_file($image['tmp_name'],  $uploadDir)) {
              
                // Cập nhật tên tệp mới vào cơ sở dữ liệu
            $sql = "UPDATE $this->table_name SET profile_picture=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $newFileName, $id);
            $stmt->execute();
            // Cập nhật thông tin ảnh đại diện trong session nếu cần thiết
            $_SESSION['profile_picture'] = $newFileName;
            
            return $newFileName;
        }
        else {
            // Xử lý nếu di chuyển tệp thất bại
            return false;
        }
    }
        catch(Exception $e){
            return false;
        }
        return null;
    }

    public function updateName($name){
        try{
            $id = $_SESSION['userId'];
            $sql = "UPDATE $this->table_name SET fullname=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $name, $id);
            $stmt->execute();
            $_SESSION['fullname'] = $name;
            return true;
        }
        catch(Exception $e){
            return false;
        }
        return false;
    }
    public function listUser(){
        try{
            $sql = "SELECT username,fullname,id,profile_picture FROM $this->table_name WHERE role=0 and id <> ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['userId']); // id của user đang đăng nhập
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

    public function getAllPost() {
        //! lấy thêm ảnh và tên người dùng
        $sql = "
        SELECT 
            posts.*, 
            users.fullname, 
            users.profile_picture 
        FROM 
            posts 
        JOIN 
            users 
        ON 
            posts.userId = users.id
        order by updated_at desc
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $posts = [];
            while ($row = $result->fetch_assoc()) {
                $posts[] = (object)$row;
            }
            return $posts;
        } 
            return null;
        
    }
    //! comment 
    public function getAllComment($post_id){
       
        $sql = "SELECT  c.*, u.username, u.profile_picture ,u.fullname FROM comments c
                join users  u
                on u.id = c.userId 
                WHERE postId = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
       
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            
            while($row = $result->fetch_assoc()){
                $comment[] = $row;
            }
           
            return $comment;
        }
     
        return null;
    }

}

