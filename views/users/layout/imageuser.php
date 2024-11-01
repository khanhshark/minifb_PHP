<?php 
if (!isset($_SESSION['username'])) {
    // Chuyển hướng người dùng đến trang đăng nhập nếu chưa đăng nhập
    header('Location:  /fb/index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Ảnh Người Dùng</title>
  <style type="text/css">
    /* Định dạng cho toàn bộ trang */
body {
    font-family: Arial, sans-serif; /* Đặt font chữ */
    background-color: #f0f2f5; /* Đặt màu nền */
    margin: 0; /* Xóa khoảng cách mặc định */
    padding: 0; /* Xóa khoảng cách mặc định */
    display: flex; /* Sử dụng Flexbox */
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center; /* Căn giữa theo chiều dọc */
    height: 100vh; /* Chiều cao 100% cửa sổ trình duyệt */
}



/* Định dạng cho phần chứa ảnh và thông tin người dùng */
.profile-container {
    text-align: center; /* Căn giữa chữ và hình ảnh */
    background-color: white; /* Màu nền */
    padding: 20px; /* Khoảng cách bên trong */
    border-radius: 10px; /* Bo góc */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Đổ bóng */
}

/* Định dạng cho ảnh đại diện */
.profile-picture {
    width: 500px; /* Chiều rộng ảnh */
    height: 500x; /* Chiều cao ảnh */
    object-fit: cover; /* Giữ tỉ lệ ảnh */
    margin-bottom: 10px; /* Khoảng cách dưới ảnh */
}

/* Định dạng cho tên người dùng */
.user-name {
    font-size: 24px; /* Kích thước chữ */
    color: #333; /* Màu chữ */
}

  </style>
</head>
<body>
    <main>
        <div class="profile-container">
            <img src=<?php echo "/fb/public/images/".($_SESSION['profile_picture'] ?  $_SESSION['profile_picture'] : 'avatar.jpg') ; ?> alt="Ảnh đại diện" class="profile-picture">
            <h1 class="user-name"><?php echo $_SESSION['fullname']; ?></h1>
        </div>
    </main>
</body>
</html>
