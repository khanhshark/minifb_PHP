
        document.addEventListener('DOMContentLoaded', function() {
            var settingsBtn = document.getElementById('settingsBtn');
            var dropdownContent = document.getElementById('dropdownContent');
            
            settingsBtn.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
                
                // Toggle lớp 'show' để hiển thị hoặc ẩn dropdown
                dropdownContent.classList.toggle('show');
            }); 

            // Đóng dropdown nếu nhấp ra ngoài
            window.addEventListener('click', function(event) {
                if (!event.target.matches('#settingsBtn')) {
                    if (dropdownContent.classList.contains('show')) {
                        dropdownContent.classList.remove('show');
                    }
                }
            });

             // Lấy các phần tử cần thiết
            var userAvatar = document.querySelector('.user-avatar');
            var menu = document.querySelector('#avatarMenu');
            var menuCloseButton = document.querySelector('#menuCloseButton');
            var updateImageLink = document.getElementById('updateImageLink');
            var imageInput = document.getElementById('imageInput');
            // Xử lý sự kiện nhấp vào ảnh đại diện
            userAvatar.addEventListener('click', function(event) {
                event.stopPropagation(); // Ngăn chặn sự kiện nhấp chuột lan ra ngoài
                menu.classList.toggle('show'); // Hiển thị hoặc ẩn menu
            });

            // Xử lý sự kiện nhấp vào nút đóng menu
            menuCloseButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Ngăn chặn sự kiện nhấp chuột lan ra ngoài
                menu.classList.remove('show'); // Ẩn menu
            });

            // Đóng menu nếu nhấp ra ngoài
            window.addEventListener('click', function(event) {
                if (!menu.contains(event.target) && event.target !== userAvatar) {
                    menu.classList.remove('show'); // Ẩn menu
                }
            });


             // Mở hộp thoại chọn ảnh khi nhấn vào "Cập nhật ảnh"
             updateImageLink.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
                imageInput.click(); // Kích hoạt input file để mở hộp thoại chọn file
            });

            // Xử lý khi người dùng chọn ảnh
            imageInput.addEventListener('change', function() {
                //! kiểm tra xem tệp có được chọn hay k 
                if (this.files && this.files[0]) {
                    // Ở đây, bạn có thể gửi tệp lên server qua AJAX hoặc xử lý theo nhu cầu của bạn
                    var formData = new FormData();
                    formData.append('image', this.files[0]);

                    $.ajax({
                       dataType:'json',
                       url: '/fb/index.php?page=users&controller=home&action=updateImage',
                       type: 'POST',
                       data: formData,
                       contentType: false,
                       processData: false,
                    }).done(function(data){
                       
                       
                        if(data['data']  != false) {
                            userAvatar.src = '/fb/public/images/' + data['data'];
                        var notification = $('<div class="notification">cập nhật ảnh thành công </div>');
                        $('body').append(notification);
                        notification.addClass('show');
                        setTimeout(function() {
                            notification.removeClass('show').remove();
                        }, 3000); // Ẩn và xóa thông báo sau 3 giây
                        }
                    });
                }
            });

    var changeNameLink = document.getElementById('changeNameLink');
    var modal = document.getElementById('changeNameModal');
    var closeButton = document.querySelector('.close');
    var changeNameForm = document.getElementById('changeNameForm');
    
    // Hiển thị modal khi nhấp vào liên kết thay đổi tên
    changeNameLink.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
        modal.style.display = 'block'; // Hiển thị modal
    });

    // Đóng modal khi nhấp vào nút đóng (x)
    closeButton.addEventListener('click', function() {
        modal.style.display = 'none'; // Ẩn modal
    });
   
        // Sử dụng event delegation để xử lý sự kiện click cho các nút "Bình luận"
        $(document).on('click', '.comment-button', function() {
            // Tìm phần tử kế tiếp có lớp 'comments-section' của nút "Bình luận" và ẩn/hiện nó
            $(this).closest('.post').find('.comments-section').toggle();
        });

        // Đăng bài 
        $('#postForm').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var $form = $(this); // Lưu trữ tham chiếu đến form
           $.ajax({
            type: 'POST',
            dataType:'json',
            url: '/fb/index.php?page=users&controller=post&action=addPost',
            data: formData,
            contentType: false,
            processData: false,
           }).done(function(data){
            // reset
            $('#postForm')[0].reset(); 
            if(data['data']=== undefined){
             
               // Tạo phần tử HTML mới
           // Tạo phần tử HTML mới
    var newPostElement = document.createElement('div');
    newPostElement.className = 'post';
    // Xây dựng nội dung HTML
    var postContent = `
        <div class="user-info">
            <img src="/fb/public/images/${profile_picture ? profile_picture : 'avatar.jpg'}" 
                alt="${username}" 
                class="user-avatar">
            <span class="user-name">${fullname}</span>
            <button class="more-options-button">...</button> <!-- Nút "..." -->
        <div class="more-options-menu">
            <button class="edit-post">Chỉnh sửa</button>
            <button class="delete-post">Xóa</button>
        </div>
        </div>
        <div class="post-content">
            <p>${data['message']}</p>
        </div>
    `;

    // Kiểm tra nếu có ảnh
    if (data['post_picture'] && data['post_picture'] !== '') {
        postContent += `
            <div class="post-image">
                <img src="/fb/public/images/${data['post_picture']}" alt="Hình ảnh không thể tải">
            </div>
        `;
    }

    postContent += `
        <div class="post-actions">
            <button class="like-button">Thả cảm xúc</button>
            <button class="comment-button">Bình luận</button>
        </div>
        <div class="comments-section">
            <div class="comments-container">
                <!-- Các bình luận sẽ được thêm vào đây -->
            
            </div>
            <textarea class="comment-input" placeholder="Viết bình luận..."></textarea>
            <button class="submit-comment">Gửi</button>
        </div>
    `;
    
    // Gán nội dung HTML vào phần tử mới
    newPostElement.innerHTML = postContent;

    // Chèn phần tử HTML mới vào đầu trang
    document.querySelector('.post-container').prepend(newPostElement);
            }
           });
        });
        
        // chỉnh sửa post
        $(document).on('click', '.more-options-button', function() {
            $(this).next('.more-options-menu').toggle();
        });
        // commmnet 
        $(document).on('click', '.submit-comment', function() {
            var commentInput = $(this).prev('.comment-input');
            var commentText = commentInput.val().trim();
            var post_id= $(this).closest('.post').data('post-id');//! lấy tổ tiên gấn nhất có class post
          if(commentText.trim() !== ''){
                $.ajax({
                    type: 'POST',
                    dataType:'json',
                    url: 'index.php?page=users&controller=comment&action=addComment',
                    data: {post_id: post_id, comment: commentText},
                   }).done(function(data){
                    // reset
                    commentInput.val('');
                    if(data['data']!== false){

                    
                       // Tạo nội dung HTML mới cho bình luận
                        var newCommentElement = `
                            <div class="comment">
                             <div class="user-info">
                                <img src="/fb/public/images/${data['data']['profile_picture']} ? ${data['data']['profile_picture']} : 'avatar.jpg') ?>" 
                                    alt="${data['data']['username']}" 
                                    class="user-avatar">
                                <span class="user-name">${data['data']['fullname']}</span>
                                </div>
                                <p>${data['data']['comment']}</p>
                            </div>
                        `;
                        // Thêm phần tử mới vào '.comments-container'
                commentInput.closest('.comments-section').find('.comments-container').append(newCommentElement);
                    }
                });
          }
        });
        // delete post
        $(document).on('click','.delete-post',function(){
            const postElement = $(this).closest('.post');
            const postId = postElement.data('post-id');
            $.ajax({
                type: 'POST',
                dataType:'json',
                url: 'index.php?page=users&controller=post&action=deletePost',
                data: {post_id: postId},
            }).done(function(data){
                if(data['data'] === true){
                    postElement.remove(); //! xóa phần tử div post
                }
            });
        });
        // update post
        
    });
   