<?php
require_once('controllers/base_controller.php');
require_once('models/homeModel.php');
class HomeController extends BaseController{
    function __construct(){
        $this->folder = 'views/users/layout';
    }
    public function index(){
        
        $home = new Home();
        $ArrayUsers =  $home->listUser()??[];
        $ArrayPost =  $home->getAllPost()??[];
        $usersArray = [];
        $PostsArray = [];
        foreach ($ArrayUsers as $user) {
            $usersArray[$user->username] = [
                'username' => $user->username,
                'fullname' => $user->fullname,
                'id' => $user->id,
                'profile_picture' => $user->profile_picture
            ];
        } 
        foreach ( $ArrayPost as $post) {
            $comment = $home->getAllComment($post->id) ?? [];
            $PostsArray[] = [
                'id' => $post->id,
                'message' => $post->message,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'post_picture' => $post->post_picture,
                'fullname' => $post->fullname,
                'profile_picture' => $post->profile_picture,
                'comment' =>   $comment
            ];   
    }
        
        $this->render('home',['data' => $usersArray, 'Post' => $PostsArray]);
    }
    public function showImage(){
        $homeModel = new Home();
        $image = $homeModel->Image($_SESSION['userId']);
       $this->render('imageuser',['data'=>$image]);
    }
    public function updateImage(){
      $homeModel = new Home();
      $image = $_FILES['image'];
      $result = $homeModel->Update($_SESSION['userId'],$image);  
      echo json_encode(['data'=>$result]);
      
}
 public function updateName(){
    $homeModel = new Home();
    if(isset($_POST['name'])){
    $name = $_POST['name'];
    $homeModel->UpdateName($name);  
    }
    header("Location: index.php?page=users&controller=home&action=index");
    exit();
 
}
}

?>