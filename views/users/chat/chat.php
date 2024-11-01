<?php 
if (!isset($_SESSION['username'])) {
    header('Location:  /fb/index.php');
    exit();
}
if(!isset($user) || $user === null) {
    header('Location: index.php?page=users&controller=chat&action=index');
    exit();
}
$profile = '/fb/public/images/' . $user['profile_picture'];
$profilePictureFullPath = $_SERVER['DOCUMENT_ROOT'] . $profile;
// Kiểm tra nếu tệp ảnh tồn tại
if (isset($user['profile_picture']) && file_exists($profilePictureFullPath)) {
} else {
    $profile = '/fb/public/images/avatar.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/fb/public/css/chat.css">
    <script>
        let incomingId = <?php echo $user['id']; ?>;
        let profile = "<?php echo htmlspecialchars($profile, ENT_QUOTES, 'UTF-8'); ?>";
    
    </script>
    <script src="/fb/public/js/chat.js"></script>
</head>
<body>
    <div class="container">
        <section class="chat-area">
            <header>
                <a href="index.php?page=users&controller=chat&action=index" class="back-icon"><img src="/fb/public/images/back.png" alt="back"></a>
                <img src=<?php echo $profile ?> alt="<?php echo $user['username'] ?> ">
                <div class="details">
                    <span><?php echo $user['fullname'] ?></span>
                    <p><?php echo ($user['status']?'Active' :'No Active') ?> </p>
                </div>
            </header>
            <div class="chat-box">
                    <!-- <div class="text">
                    <img src="/fb/public/images/avatar.jpg" alt="Load ...">
                    <span>no message are available </span>
                    </div> -->
                    <!-- <div class="chat outgoing">
                        <div class="details">
                        <p>hello </p>
                        <p><img src="/fb/public/images/avatar.jpg" alt=""> </p>
                        </div>
                    </div>
                    <div class="chat incoming">
                        <img src="/fb/public/images/avatar.jpg" alt="">
                        <div class="details">
                            <p>khanh</p>
                            <p><img src="/fb/public/images/avatar.jpg" alt=""> </p>
                        </div>
                    </div> -->
            </div>
            <form action="#" class="typing-area">
                <input type="text"  name ="incoming_id" value="<?php echo $user['id'] ?>" placeholder="Type a message..." hidden>
                <input type ="text" name="message" class="input-field" placeholder="type a message...">
                <button type="button" class="image"><img src="/fb/public/images/cam.jpg" alt=""></button>
                <input type="file" name="send_image" class="upload_img" accept="image/*" hidden>
                <button type="submit" class="send_btn" name="send_btn"><img src="/fb/public/images/send.png" alt=""></button>
            </form>
        </section>
    </div>


</body>
</html>