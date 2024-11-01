<?php 
require_once('models/baseModel.php');
class Comment extends BaseModel{
    private $table_name = 'comments';
    public function __construct(){
        parent::__construct();
    }
    public function getAllComment($post_id){
        $sql = "SELECT * FROM $this->table_name c
                join users  u
                on u.id = c.userId 
                WHERE postId = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $comment =[] ;
            while($row = $result->fetch_assoc()){
                $comment[] = $row;
            }
            return $result;
        }
        return false;
    }
    public function createComment($post_id, $content){
       
        $userid = SessionManager::getUserId();
        $sql = "INSERT INTO $this->table_name (userId,postId,comment,
created_at,updated_at) VALUES (?,?,?,NOW(),NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis",$userid, $post_id, $content);
        if($stmt->execute()){
        // Lấy ID của bình luận mới được thêm
        $newCommentId = $stmt->insert_id;

        // Truy vấn để lấy dữ liệu bình luận mới từ cơ sở dữ liệu
        $sql = "SELECT c.*, u.username, u.profile_picture ,u.fullname
            FROM $this->table_name c
            JOIN users u ON c.userId = u.id
            WHERE c.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $newCommentId);
        $stmt->execute();
        $result = $stmt->get_result();
            
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Trả về dữ liệu bình luận mới
    } else {
        return false; // Trường hợp không tìm thấy bình luận
    }
    } else {
    return false; // Trường hợp lỗi khi thêm bình luận
    }
}
    public function updateComment($comment_id, $content){
        $sql = "UPDATE $this->table_name SET comment =? WHERE id =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $content, $comment_id);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else false;
    }
    public function deleteComment($comment_id){
        $sql = "DELETE FROM $this->table_name WHERE id =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);
        if($stmt->execute()){
            return true;
        }
        else false;
    }

}

?>