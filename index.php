<?php 
//! kiểm tra session đã được khởi tạo chưa
require_once("session.php");
//! $page là tên của folder main hoặc users
//! $controller là tên file của các controller
//! $action là tên hàm của file controller

if(isset($_GET['page'])){
    $page = $_GET['page'];
    if(isset($_GET['controller'])){
        $controller = $_GET['controller'];
        if(isset($_GET['action'])){
            $action = $_GET['action'];
        }else {
            $action = 'index';
        }
    }
    
    else {
        $controller = 'home';
        $action = 'index';
    }
}
    else {
        //! trang mặc định ban đầu 
        $page = 'users';
        $action = 'login';
        $controller = 'login'; //* 2 trang này chung 
    }
require_once ('route.php');

?>