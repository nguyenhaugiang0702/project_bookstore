function chat_validation() {
    const textmsg = $('#typing').val();
    const receiver_id = $('#receiver_id').val();
    const sender_id = $('#sender_id').val();

    if (textmsg == '') {
        alert("Nhập để chat");
        return false;
    }
    const datastr = 'message=' + textmsg + '&receiver_id=' + receiver_id + '&sender_id=' + sender_id;

    $.ajax({
        url: 'chatlog.php',
        type: 'post',
        data: datastr,
        success: function (e) {
            $('#msg').html(e);
        }
    });
    document.getElementById('typing-sending').reset();
    return false;
}

$(document).ready(function mess() {
    const receiver_id = $('#receiver_id').val();
    const sender_id = $('#sender_id').val();
    const datastr = 'receiver_id=' + receiver_id + '&sender_id=' + sender_id;
    setInterval(function () {
        $.ajax({
            url: 'chat_loader.php',
            type: 'get',
            data: datastr,
            success: function (e) {
                $('#chat_load').html(e);
            }
        });
    }, 500)
});

$(document).ready(function loadListMess() {
    setInterval(function () {
        $.ajax({
            url: 'sidebar_chat.php',
            success: function (e) {
                $('#chat_load_list').html(e);
            }
        });
    }, 500)
});

// search in chat
$(document).ready(function(){
    $('#getName').on('keyup',function(){
        var getName = $(this).val();
        if(getName!=''){
            $('#search_chat').css('display','block');

            $('#chat_load_list').css('display','none');
            $.ajax({
                method: 'POST',
                url: 'search_chat.php',
                data: {getName:getName},
                success: function(e){
                    $('#search_chat').html(e);
                }
            })
        }else{
            $('#search_chat').css('display','none');
            $('#chat_load_list').css('display','block');
        }
        
    })
})
