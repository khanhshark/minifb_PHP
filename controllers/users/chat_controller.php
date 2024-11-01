<?php 
require_once('controllers/base_controller.php');
require_once('models/ChatModel.php');

class chatController extends BaseController {
    function __construct(){
       
        $this->folder = 'views/users/chat';
    }
    public function index(){
        $userChat = new Chat();
        $list = $userChat->chatUser()??[];
        $this->render('homechat',['data'=>$list]);
    }
    public function chat(){
        $id = isset($_GET['id']) ? $_GET['id'] :0;
        $chat = new Chat();
        $user = $chat->Userid($id);
        
        $chat = null;
        $this->render('chat',['user'=>$user]);
    }
    //! xử lý json
    public function search(){
        $name = isset($_POST['name']) ? $_POST['name'] :'';
            $userChat = new Chat();
            $list = $userChat->chatUser($name)??[] ;
            $userChat = null;
            echo json_encode($list);
    }
    public function sendMessage(){
        $message = isset($_POST['message'])? $_POST['message']: '';
        $userId = isset($_POST['incoming_id'])? $_POST['incoming_id']: '';
        //! UPLOAD_ERR_OK các lỗi vd 4 là k có ảnh gửi kèm 
        $image = (isset($_FILES['image']) && ($_FILES['image']['error'] == UPLOAD_ERR_OK )) ?  $_FILES['image']:null;
        $chat = new Chat();
        $data = $chat->sendMessage($message, $image, $userId);
        $chat = null;
        echo json_encode(['data' => $data]);
    }
    public function getMessages(){
        $chat = new Chat();
        $incoming_id = isset($_POST['messageId']) ? $_POST['messageId'] :0;
        $data = $chat->getMessages($incoming_id);
       
        $chat = null;
        echo json_encode(['data' => $data]);
    }
}
?>
