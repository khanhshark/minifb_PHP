<?php
require_once('controllers/base_controller.php');
require_once('models/FriendModel.php');
class FriendController extends BaseController{
    function __construct(){
        $this->folder = 'views/users/layout';
    }
    public function listFriends(){
        $FriendModel = new Friend();
        $friends = $FriendModel->listUser();
        $error = "";
        $data = array();
        if($friends == false){
            $error = "Có lỗi phía máy chủ";
        }
        else {
            $data = $friends;
        }
        echo json_encode(['data' => $data, 'error' => $error]);
    }

}


?>