<?php 
class BaseController{
    protected $folder;//! biến lưu url
        function render($file,$data = array()) {
            //! Kiểm tra file gọi đến có tồn tại hay không 
            $view_file =$this->folder.'/'.$file.'.php';
            if(is_file($view_file)){
                extract($data); //! tách thành từng biến 
                ob_start();
                require_once($view_file);
                $content = ob_get_clean(); // Lấy nội dung từ bộ đệm và xóa bộ đệm
    
                // Hiển thị nội dung đã xử lý
                echo $content;
            }
            else {
                require_once('error/error_404.php');
            }

        }
    }



?>