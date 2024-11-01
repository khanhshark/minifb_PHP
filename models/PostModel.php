<?php 
require_once('models/baseModel.php');
class Post extends BaseModel{
    private $table_name = 'posts';
    public function __construct(){
        parent::__construct();
    }
    public function getAllPost() {
        $sql = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $posts = [];
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            return $posts;
        } else {
            return false;
        }
    }
    
   //!
   public function getPostByUserId($userId) {
    $sql = "SELECT * FROM $this->table_name WHERE userId = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Lưu tất cả các bài đăng vào mảng
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    } else {
        return false;
    }
}


    public function addPost($message,$postPicture = null){
        $id = SessionManager::getUserId();
            // Tạo tên tệp mới bằng cách kết hợp id và thời gian
             // Lấy phần mở rộng của tệp (ví dụ: .jpg, .png)
             if($postPicture === null){
                $sql = "INSERT INTO $this->table_name (message, userId, created_at,updated_at, post_picture) VALUES (?, ?, NOW(),NOW(), '')";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("si", $message, $id);
                $stmt->execute();
                return [
                    'message' => $message,
                    'post_picture' => ""
                ];
             }
             else {
               
                $extension = pathinfo($postPicture['name'], PATHINFO_EXTENSION);
                $newFileName =  $id. '_' . time() . '.' . $extension;
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/fb/public/images/' . $newFileName;  
                if(move_uploaded_file($postPicture['tmp_name'],  $uploadDir)) { 
                $sql = "INSERT INTO $this->table_name (`message`, userId, created_at,updated_at, post_picture) VALUES (?, ?, NOW(),NOW(), ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sis", $message,$id, $newFileName);
               }
                else{
                  return false;
                }
             }
            
            $stmt->execute();
            return [
                'message' => $message,
                'post_picture' => $newFileName
            ];
    }
    public function updatePost($postId,$content,$postPicture=''){
        $sql = "UPDATE $this->table_name SET message = ?, post_picture = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $content, $postPicture, $postId);;
        $stmt->execute();
        if ($stmt->execute()) {
            return true;
        } else {
            // Lấy thông tin lỗi nếu execute() không thành công
            return "Error: " . $stmt->error;
        }
        return false;
    }
    public function deletePost($postId){
        $sql = "DELETE FROM $this->table_name WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i" ,$postId);;
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            // Lấy thông tin lỗi nếu execute() không thành công
            return "Error: " . $stmt->error;
        }
        return false;
    }
    public function likePost(){}

}

?>