

$(document).ready(function() {
    // chat
    // focus messages
    $('.input-field').focus();
     
    $('.typing-area .image').on('click', function(){
        $('.typing-area .upload_img').click();
    });
    // send message hiện màu 
    $('.typing-area .input-field').on('keyup', function(){
        if($('.typing-area .input-field').val()!== '') $('.typing-area .send_btn').addClass('active');
        else $('.typing-area .send_btn').removeClass('active');
       
    });
    $('.typing-area .upload_img').on('change', function(){
       
        if(this.files.length > 0){
            $('.typing-area .send_btn').addClass('active');
        }
        else $('.typing-area .send_btn').removeClass('active'); 
    });
    //form
    $('.typing-area').on('submit', function(e){
        e.preventDefault();
       const message = $(this).find('input[name="message"]').val().trim();
       const incoming_id = $(this).find('input[name="incoming_id"]').val().trim();
       const inputFile = $(this).find('input[name="send_image"]');
       // Kiểm tra nếu incoming_id là một số
        if (incoming_id !== '' && !isNaN(incoming_id) && (inputFile.length > 0 && inputFile[0].files.length > 0 || message.length > 0)) {
            let formdata = new FormData(this);
            if(inputFile.length > 0 && inputFile[0].files.length > 0) formdata.append('image', inputFile[0].files[0]);
            formdata.append('message', message);
            formdata.append('incoming_id', incoming_id);
            $.ajax({
                dataType: 'json',
                url: '/fb/index.php?page=users&controller=chat&action=sendMessage',
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
            }).done(function(data){
                    console.log(data);
                    let chatHtml = `
                    <div data-id ="${data['data']['messageId']}" class="chat outgoing">
                        <div class="details">`;
                    if(data['data']['message']) chatHtml+= `<p>${data['data']['message']}</p>`;
                    if(data['data']['image']) chatHtml+= `<p><img src="/fb/public/images/${data['data']['image']}" alt="gửi ảnh"></p>
                    </div>
                </div>
                    `;
                    $('.chat-box').append(chatHtml);
                    $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
                    // reset
                    $('.typing-area')[0].reset();
                    $('.typing-area .send_btn').removeClass('active');
                    
            });

        }   
    });
    
    function fetchMessages(id){
      
        $.ajax({
            url: '/fb/index.php?page=users&controller=chat&action=getMessages',
            type: 'POST',
            dataType: 'json',
            data:{messageId: id}
        }).done(function(data){
           
                if(data['data'] === null){
                    
                    let chatHtml = '';
                        chatHtml += `
                        <div class="text">
                    <img src="${profile}" alt="Load ...">
                    <span>no message are available </span>
                    </div> 
                        `;
    
                    $('.chat-box').html(chatHtml);
                }
                else {
                    let chatHtml = '';
                    data['data'].forEach(function(element) {
                      if(element['receiver_id'] == incomingId) {
                        
                        chatHtml += `
                        <div data-id ="${element['id']}" class="chat outgoing">`;
                            
                      }
                      else {
                        chatHtml += `
                        <div data-id ="${element['id']}" class="chat incoming">
                            <img src="${profile}" alt="image">`;
                      }
                      chatHtml += `
                            <div class="details">`;
                        if(element['message']) chatHtml+= `<p>${element['message']}</p>`;
                        if(element['image_path']) chatHtml+= `<p><img src="/fb/public/images/${element['image_path']}" alt="gửi ảnh"></p>`;
                        chatHtml += `
                            </div>
                        </div>`;
                    
                    });
                    $('.chat-box').html(chatHtml);
                    // scroll to bottom
                    $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
                }
                
                });
            }

    // Thiết lập setInterval để gọi hàm fetchMessages mỗi 30 giây
     setInterval(() => fetchMessages(incomingId), 500);
   

});
