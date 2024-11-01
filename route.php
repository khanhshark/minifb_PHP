<?php 
//! các file trong thư mục controlers
$pages = array(
    'error' =>['error'],
    'main' => [],
    'users'=>['login','home','post','comment','chat'],
);

//! các hàm trong các file $page tương ứng 

$controllers = array(
    'login' =>['login','login_check','logout','register','home'],
    'home' => ['showImage','updateImage','updateName','index'],
    'post' =>['addPost','deletePost'],
    'comment' =>['addComment'],
    'chat' =>['index','chat','search','sendMessage','getMessages']
);

//! nếu các tham số không hợp lệ thì trả về trang error
if($page == 'error' || !array_key_exists($page,$pages) ||!array_key_exists($controller,$controllers) || !in_array($action,$controllers[$controller]) ){
    require_once('error/error_404.php');
}

else {
  
    include_once('controllers/'.$page.'/'.$controller.'_controller.php');
    $nameClass = str_replace('_', '', ucwords($controller,'_')).'Controller'; //! ghi hoa chữ đầu  rồi thay thế các _ thành "
    $controller = new $nameClass;
    $controller->$action();
}
?>
