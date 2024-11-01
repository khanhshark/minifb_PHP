<?php 
require_once('controllers/base_controller.php');
require_once('models/CommentModel.php');

class CommentController extends BaseController {
    function __construct(){
        $this->folder = 'views/users/layout';
    }
    
    public function addComment(){
        $commentModel = new Comment();
        $data = '';
        $message = isset($_POST['comment'])? $_POST['comment']: '';
        $postId = isset($_POST['post_id'])? $_POST['post_id']: '';
        $data = $commentModel->createComment($postId,$message);
        echo json_encode(['data' => $data]);
    }
    public function deleteComment(){}
    public function editComment(){}
    public function listComment(){}
}

?>
