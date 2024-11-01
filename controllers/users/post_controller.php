<?php 
require_once('controllers/base_controller.php');
require_once('models/PostModel.php');

class PostController extends BaseController {
    function __construct(){
        $this->folder = 'views/users/layout';
    }
    
    public function addPost(){
        $postModel = new Post();
        $message = isset($_POST['content'])? $_POST['content']: '';
        //! UPLOAD_ERR_OK các lỗi vd 4 là k có ảnh gửi kèm 
        $image = isset($_FILES['image']) && ($_FILES['image']['error'] == UPLOAD_ERR_OK)?  $_FILES['image']:null;
        $Post = $postModel->addPost($message, $image);
        if($Post=== false) return json_encode(['data' => false]);
        
        echo json_encode($Post);

    }
    public function updatePost(){
       $postModel = new Post();
       $id = isset($_POST['id'])? $_POST['id']: '';

    }
    public function deletePost(){
       $postModel = new Post();
       $id = isset($_POST['post_id'])? $_POST['post_id']: '';
       $data = $postModel->deletePost($id);
     
       echo json_encode(['data' => $data]);
    }
    public function showPost(){

    }

}


?>