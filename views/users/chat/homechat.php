<?php 
if (!isset($_SESSION['username'])) {
    // Chuyển hướng người dùng đến trang đăng nhập nếu chưa đăng nhập
    header('Location:  /fb/index.php');
    exit();
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
//! xử lý list người dùng chat
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
    $friendsListHtml .=
                       ' <a href="index.php?page=users&controller=chat&action=chat&id='.$user['id'].'">
                        <div class="content">
                            <img src="' . htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') . '"> 
                            <div class="details" data-friend-id="' . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8').'">
                                <span>' . htmlspecialchars($user['fullname'], ENT_QUOTES, 'UTF-8') . '</span>
                                <p>'.$user['message'].'</p>
                            </div>
                        </div>
                        <div class="status-dot '.($user['status']?'':'offline') .' "></div>
                </a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/fb/public/css/chat.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/fb/public/js/search.js"></script>
</head>
<body>
    <div class="container">
        <section class="users">
            <header class="profile">
                <div class="content">
                <img src="<?php echo htmlspecialchars($profile , ENT_QUOTES, 'UTF-8'); ?>" 
                    alt="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>">
   
                    <div class="details">
                    <span><?php echo htmlspecialchars($_SESSION['fullname'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <p> Active now</p>
                    </div>
                </div>
                <a href="index.php?page=users&controller=home&action=index" class="home"> Trang chủ</a>
                </header>
                <form action="#" method="post" class="search">
                    <input type="text" name="search_box" placeholder="Name user to search">
                    <button type="submit" >Search</button>
                </form>
                <div class="all-users">
                <!-- <a href="index.php?page=users&controller=chat&action=chat">
                        <div class="content">
                            <img src="/fb/public/images/avatar.jpg" alt="Load ..."> 
                            <div class="details">
                                <span>Altd</span>
                                <p>prop</p>
                            </div>
                        </div>
                        <div class="status-dot offline"></div>
                </a> -->
                <?php echo $friendsListHtml;?>
                </div>
        </section>
    </div>
</body>
</html>