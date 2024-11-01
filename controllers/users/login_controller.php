<?php 
require_once('controllers/base_controller.php');
require_once('models/AccountModel.php');
class LoginController extends BaseController {
    function __construct(){
        $this->folder = 'views/users/login';
    }
    public function login(){
        $Account = new Account();
        $Account->status();
        SessionManager::logout();
        $this->render('login');
        
    }
    public function addAcount(){
       
    }
    public function forgetPassword(){}
    public function resetPassword(){}
    public function changePassword(){}
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
    public function home(){
        $Account = new Account();
        $Account->status(1);
        header("Location: index.php?page=users&controller=home&action=index");
        exit();
       
    }
    public function register(){
        //! Lấy dữ liệu từ yêu cầu POST
        $fullName = $_POST['fullname'] ?? '';
        $username = $_POST['username'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = "";
        $Account = new Account();
        if($Account->checkUsername($username)){
            $error = "Username already exists!";
            echo json_encode([ 'error' => $error]);
            exit();
        }
        else if($Account->createUser($username, $password,$fullName,$mobile)){
            echo json_encode([ 'error' => '', ]);
            exit();
        }
        else {
            $error = "An error occurred while creating the account!";
            echo json_encode(['error' => $error]);
            exit();
        }
    }

   


}


?>