<?php 
require_once('controllers/base_controller.php');
require_once('models/AccountModel.php');
class LoginController extends BaseController {
    function __construct(){
        $this->folder = 'views/main/home';
    }
    public function login(){
        SessionManager::logout();
        $this->render('login');
        
    }
    public function home(){
        $user = new Account();
        $ArrayUsers = $user->listUser();
        foreach ($ArrayUsers as $user) {
            $usersArray[$user->username] = [
                'username' => $user->username,
                'fullname' => $user->fullname,
                'id' => $user->id,
                'profile_picture' => $user->profile_picture
            ];
}
        $this->render('../layout/home',['data' => $usersArray]);
    }
    public function login_check(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $Account = new Account();
        $error = "";
        $user = $Account->authenticate($username, $password);
        if($user){
            SessionManager::login($user->username,$user->id,$user->role,$user->fullname,$user->profile_picture);
            $Account = null;
            echo json_encode(['error' => $error]);
            exit();
        }
        echo json_encode(['error' => null]);
    }
   


}


?>