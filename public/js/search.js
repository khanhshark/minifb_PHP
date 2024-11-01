$(document).ready(function() {
    // tìm kiếm
    $('.search').on('submit', function(e){
        e.preventDefault();
        // Lấy giá trị từ input
       const name = $(this).find('input[name="search_box"]').val().trim();
       if(name.length > 0){
        $.ajax({
            dataType: 'json',
            url: '/fb/index.php?page=users&controller=chat&action=search',
            type: 'POST',
            data: {name: name},
        }).done(function(data){
            let friendsListHtml = "";
            if($.isArray(data)  && data.length > 0){
                data.forEach(user => {
                     friendsListHtml +=
                        `<a href="index.php?page=users&controller=chat&action=chat&id=123">
                            <div class="content">
                                <img src="/fb/public/images/${user['profile_picture'] ? user['profile_picture'] : 'avatar.jpg'}" 
                                    alt="${user['username']}" class="user-avatar"> 
                                <div class="details" data-friend-id="${user['id']}">
                                    <span>${user['fullname']}</span>
                                    <p>${user['message']}</p>
                                </div>
                            </div>
                            <div class="status-dot ${user['status'] ? '' : 'offline'}"></div>
                        </a>
                    `;
                });   
            }
           friendsListHtml = friendsListHtml?friendsListHtml :"Không tìm thấy !"
            $('.all-users').html(friendsListHtml);
            if ($('.all-users').next('.back-icon').length === 0) {
                // Nếu không có .back-icon kế tiếp thì thêm thẻ vào
                $('.all-users').after(`
                    <a href="index.php?page=users&controller=chat&action=index" class="back-icon">
                        <img src="/fb/public/images/back.png" alt="back">
                    </a>
                `);
            }
        })  
       }
    });

});