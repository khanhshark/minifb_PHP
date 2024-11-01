
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Description" content="Facebook login html and css in the home" />
    <title>MiniFaceBook</title>
    <link href="/fb/public/css/login.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="minifb-container">
        <header class="minifb-header">
            <h1>MiniFaceBook</h1>
        
        
        <div class="minifb-form-container">
            <form class="login-fb" method="post" action="">
                <div class="minifb-form-group-login">
                    <label for="username">Username</label>
                    <input id="username" placeholder="Username"  autocomplete="username" type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                </div>
                <div class="minifb-form-group-login">
                    <label for="password">Password</label>
                    <input id="password" placeholder="Password"  type="password" name="password" autocomplete="current-password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required>
                </div>
               
                <button type="submit" name="action" class="submit-btn" id ="Login">Login</button>
               
            </form>
            
        </div>
       
        </header>
        <div class="minifb-body">
            <div class="minifb-intro">
                
            </div>
            <div class="register-container">
            <form method="post" action="register.php">
    <div class="minifb-form-group">
        <label for="fullname">Name</label>
        <input id="fullname" placeholder="Name" type="text" name="FullName" value="<?php echo isset($FullName) ? htmlspecialchars($FullName) : ''; ?>" required>
        <p class="error-msg" id="fullname-error">Name is required.</p>
    </div>
    <div class="minifb-form-group">
        <label for="rusername">Username</label>
        <input id="rusername" placeholder="Username" type="text" name="Rusername"autocomplete="username" value="<?php echo isset($Rusername) ? htmlspecialchars($Rusername) : ''; ?>" required pattern="\w+">
        <p class="error-msg" id="username-error">Username must contain only letters, numbers, and underscores.</p>
    </div>
    <div class="minifb-form-group">
        <label for="rmobile">Mobile</label>
        <input id="rmobile" placeholder="Mobile" type="text" name="Rmobile" value="<?php echo isset($Rmobile) ? htmlspecialchars($Rmobile) : ''; ?>" required pattern="[0-9]{10}">
        <p class="error-msg" id="mobile-error">Mobile must be a 10-digit number.</p>
    </div>
    <div class="minifb-form-group">
        <label for="rpassword">Password</label>
        <input id="rpassword" placeholder="Password" type="password" name="Rpassword" autocomplete="new-password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}">
        <p class="error-msg" id="password-error">Password must be at least 6 characters long and contain at least one number, one lowercase, and one uppercase letter.</p>
    </div>
    <div class="minifb-form-group">
        <label for="repassword">Confirm Password</label>
        <input id="repassword" placeholder="Confirm Password" type="password" name="repassword"autocomplete="new-password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}">
        <p class="error-msg" id="repassword-error">Passwords do not match.</p>
        <p class="note">Note: For password, at least one number, one lowercase and one uppercase letter with at least six characters.</p>
    </div>
    <button type="submit" name="action" class="register-btn" id="register">Register</button>
</form>
            </div>
        </div>
        <footer class="minifb-footer">
        <div class="footer-content">
        <p>&copy; 2024 MiniFaceBook. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="#privacy">Trần kim khanh </a></li>
            <li><a href="#terms">21110318</a></li>
            <li><a href="#contact">ĐẠI HỌC KHOA HỌC TỰ NHIÊN</a></li>
        </ul>
    </div>
</footer>
    </div>
    <script>
    $(document).ready(function() {
        function validateInput(input, errorMsg, pattern = null) {
            //! kiểm tra ô nhập có khớp với hay không test
            if (input.val().trim() === '' || (pattern && !pattern.test(input.val().trim()))) {
                errorMsg.show(); //! hiển thị ra thẻ p
                return false;
            } else {
                errorMsg.hide(); //! ẩn thẻ 
                return true;
            }
        }
        //! Kiểm tra khi người dùng rời khỏi ô input
        $('#fullname').blur(function() {
            validateInput($(this), $('#fullname-error'));
        });

        $('#rusername').blur(function() {
            const usernamePattern = /^\w+$/;
            validateInput($(this), $('#username-error'), usernamePattern);
        });

        $('#rmobile').blur(function() {
            const mobilePattern = /^[0-9]{10}$/;
            validateInput($(this), $('#mobile-error'), mobilePattern);
        });

        $('#rpassword').blur(function() {
            const passwordPattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            validateInput($(this), $('#password-error'), passwordPattern);
        });

        $('#repassword').blur(function() {
            if ($('#rpassword').val() !== $(this).val()) {
                $('#repassword-error').show();
            } else {
                $('#repassword-error').hide();
            }
        });
       
        // Kiểm tra khi người dùng submit form
        $('#register').click(function(event) {
          
            let isValid = true;

            isValid = validateInput($('#fullname'), $('#fullname-error')) && isValid;
            
            const usernamePattern = /^\w+$/;
            isValid = validateInput($('#rusername'), $('#username-error'), usernamePattern) && isValid;
            
            const mobilePattern = /^[0-9]{10}$/;
            isValid = validateInput($('#rmobile'), $('#mobile-error'), mobilePattern) && isValid;
            
            const passwordPattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
            isValid = validateInput($('#rpassword'), $('#password-error'), passwordPattern) && isValid;

            if ($('#rpassword').val() !== $('#repassword').val()) {
                $('#repassword-error').show();
                isValid = false;
            } else {
                $('#repassword-error').hide();
            }

            if (!isValid) {
                event.preventDefault();
            }
            else {
                const name = $('#fullname').val();
                const username = $('#rusername').val();
                const mobile = $('#rmobile').val();
                const password = $('#rpassword').val();
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'index.php?page=users&controller=login&action=register',
                    data: {fullname:name,username : username,mobile:mobile,password : password}, // Lấy tất cả dữ liệu từ form
            }).done(function(data) {
                
            // Tạo và hiển thị thông báo
            if(data['error'] == '') data['error'] = "Registration successful!";
            var notification = $('<div class="notification">' +data['error']+'</div>');
            $('body').append(notification);
            notification.addClass('show');
            setTimeout(function() {
                notification.removeClass('show').remove();
            }, 3000); // Ẩn và xóa thông báo sau 3 giây
            
            //! reset 
            $('#fullname').val("");
            $('#rusername').val("");
            $('#rmobile').val("");
            $('#rpassword').val("");
            $('#repassword').val("");

        });
    }
    });

    $('#Login').click(function(event){
        event.preventDefault();
        const username = $('#username').val();
        const password = $('#password').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'index.php?page=users&controller=login&action=login_check',
            data: {username : username, password : password}, // Lấy tất cả dữ liệu từ form
        }).done(function(data){
            if(data['error'] != "") {
            var notification = $('<div class="notification">Invalid username or password </div>');
            $('body').append(notification);
            notification.addClass('show');
            setTimeout(function() {
                notification.removeClass('show').remove();
            }, 3000); // Ẩn và xóa thông báo sau 3 giây
            }
            else {
                window.location.href="index.php?page=users&controller=login&action=home";
            }
            //! reset
            $('#username').val("");
            $('#password').val("");

        });
    });

});
</script>
</body>

</html>
