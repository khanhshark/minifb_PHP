<?php 
// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    // Chuyển hướng người dùng đến trang đăng nhập nếu chưa đăng nhập
    header('Location:  /fb/index.php');
    exit();
}
$friendsListHtml = '';
if (!isset($data)) {
    $data = []; // Hoặc khởi tạo với một giá trị mặc định
}
foreach ($data as $user) {
    // Xây dựng đường dẫn tệp ảnh
    $profilePicturePath = '/fb/public/images/' . $user['profile_picture'];
    
    // Kiểm tra nếu tệp ảnh tồn tại
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profilePicturePath) && $user['profile_picture']) {
        $profilePicture = $profilePicturePath;
    } else {
        // Nếu tệp ảnh không tồn tại, sử dụng ảnh mặc định
        $profilePicture = '/fb/public/images/avatar.jpg';
    }
    
    $friendsListHtml .= '<a href="index.php?page=users&controller=chat&action=chat&id='.$user['id'].'" data-friend-id="' . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') . '">
                            <img src="' . htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . '">
                            <span class="friend-name">' . htmlspecialchars($user['fullname'], ENT_QUOTES, 'UTF-8') . '</span>
                        </a>';
}

// Xây dựng đường dẫn đến hình ảnh đại diện của người dùng hiện tại
$profile = '/fb/public/images/' . $_SESSION['profile_picture'];
$profilePictureFullPath = $_SERVER['DOCUMENT_ROOT'] . $profile;
// Kiểm tra nếu tệp ảnh tồn tại
if (isset($_SESSION['profile_picture']) && file_exists($profilePictureFullPath)) {
} else {
    // Nếu không có hình ảnh hoặc tệp không tồn tại, sử dụng hình ảnh mặc định
    $profile = '/fb/public/images/avatar.jpg';
}

if (!isset($Post)) {
    $Post = []; // Hoặc khởi tạo với một giá trị mặc định
}
// hiển thị các bài post 
    $PostListHtml = '';
    foreach($Post as $post){
        
    // Xây dựng đường dẫn tệp ảnh
    $postPicturePath = '/fb/public/images/' . $post['post_picture'];
    $profilePicturePath = '/fb/public/images/' . $post['profile_picture'];
    // Kiểm tra nếu tệp ảnh tồn tại
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $postPicturePath ) && $post['post_picture']) {
        $postPicture = $postPicturePath;
    } else {
        $postPicture = ''; // Không có ảnh kèm theo
    }

   if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profilePicturePath ) && $post['profile_picture']) {
        $profilePicture = $profilePicturePath ;
    } else {
        $profilePicture = '/fb/public/images/avatar.jpg'; // Không có ảnh kèm theo
    }
         // Xây dựng HTML cho bài post
    $PostListHtml .= '
    <div class="post" data-post-id="' . $post['id'] . '">
        <div class="user-info">
            <img src="' . htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8') . '" 
                alt="' . "upload..." . '" 
                class="user-avatar">
            <span class="user-name">' . htmlspecialchars($post['fullname'], ENT_QUOTES, 'UTF-8') . '</span>
            <button class="more-options-button">...</button> <!-- Nút "..." -->
        <div class="more-options-menu">
            <button class="edit-post">Chỉnh sửa</button>
            <button class="delete-post">Xóa</button>
        </div>
            </div>
        <div class="post-content">
            <p>' . htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8') . '</p>
        </div>';
        // Kiểm tra và thêm ảnh vào HTML nếu có
    if ($postPicture) {
        $PostListHtml .= '
        <div class="post-image">
            <img src="' . htmlspecialchars($postPicture, ENT_QUOTES, 'UTF-8') . '" alt="Hình ảnh không thể tải">
        </div>';
    }

    $PostListHtml .= '
        <div class="post-actions">
            <button class="like-button">Thả cảm xúc</button>
            <button class="comment-button">Bình luận</button>
        </div>
        <div class="comments-section">
            <div class="comments-container">';
            
                foreach ($post['comment'] as $comment) {
                        $PostListHtml.= '
                <div class="comment">
                    <div class="user-info">
                        <img src="/fb/public/images/' . ($comment['profile_picture'] ? $comment['profile_picture'] : "avatar.jpg") . '" 
                            alt="' . $comment['username'] . '" 
                            class="user-avatar">
                        <span class="user-name">' . $comment['fullname'] . '</span>
                    </div>
                    <p>' . $comment['comment'] . '</p>
                </div>
            ';
            }
    
            $PostListHtml.='</div>
            <textarea class="comment-input" placeholder="Viết bình luận..."></textarea>
            <button class="submit-comment">Gửi</button>
        </div>
    </div>';
                
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniFacebook</title>
    <link href="/fb/public/css/home.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // Đưa dữ liệu PHP vào biến JavaScript với dấu ngoặc kép để đảm bảo nó là chuỗi
    var fullname = "<?php echo htmlspecialchars($_SESSION['fullname'], ENT_QUOTES, 'UTF-8'); ?>";
    var username = "<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";
    var profile_picture = "<?php echo htmlspecialchars($_SESSION['profile_picture'], ENT_QUOTES, 'UTF-8'); ?>";

  
    </script>

    <script src="/fb/public/js/home.js"></script>

</head>
<body>
    <header>
        <div class="top-section">
            <div class="logo">MiniFacebook</div>
            <nav>
                <ul>
                    <li><a href="index.php?page=users&controller=chat&action=index">Chat</a></li>
                    <li class="dropdown">
                        <a href="#" id="settingsBtn">Cài đặt</a>
                        <div id="dropdownContent" class="dropdown-content">
                            <a href="<?php echo '/fb/index.php'; ?>">Đăng xuất</a>
                            <a href="#settings">Cài đặt giao diện</a>
                            <a href="#profile">Trang thông tin cá nhân</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="user-info">
    <img src="<?php echo htmlspecialchars($profile , ENT_QUOTES, 'UTF-8'); ?>" 
         alt="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>" 
         class="user-avatar">
    <span class="user-name"><?php echo htmlspecialchars($_SESSION['fullname'], ENT_QUOTES, 'UTF-8'); ?></span>
    <!-- Menu tùy chọn -->
    <div id="avatarMenu" class="avatar-menu">
        <a href="index.php?page=users&controller=home&action=showImage">Xem ảnh</a>
        <a href="#updateImage" id="updateImageLink">Cập nhật ảnh</a>
        <a href="#changeName" id="changeNameLink">Thay đổi tên</a>
        <button id="menuCloseButton">Đóng</button>
    </div>
</div>
    </header>
    
    <div class="container">
        <aside class="left-sidebar">
            <div class="post-box">
                <h2>Đăng bài viết</h2>
                <form id="postForm" method="POST" enctype="multipart/form-data">
                    <textarea id="postContent" name="content" placeholder="Bạn đang nghĩ gì?" required></textarea>
                    <input type="file" id="postImage" name="image" accept="image/*">
                    <button type="submit">Đăng</button>
                </form>
            </div>
        </aside>

        <main>
    <!-- Nội dung chính của trang -->
    <div class="post-wrapper">
        <div class="post-container">
        <?php echo $PostListHtml; ?>
    </div>
</main>
        <aside class="right-sidebar">
        <div class="friends-list">
            <h2>Danh sách bạn bè</h2>
            <div id="friends">
            <?php echo $friendsListHtml; ?>
            </div>
        </div>
    </aside>

    </div>
    <!-- Thẻ input file ẩn để chọn ảnh -->
    <input type="file" id="imageInput" style="display:none;" accept="image/*">
    <!-- Modal để thay đổi tên -->
<div id="changeNameModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Thay đổi tên</h2>
        <form id="changeNameForm" method="POST" action="/fb/index.php?page=users&controller=home&action=updateName">
            <input type="text" id="newName" name="name" placeholder="Nhập tên mới" required>
            <button type="submit">Cập nhật</button>
        </form>
    </div>
</div>
   

    
</body>
</html>
