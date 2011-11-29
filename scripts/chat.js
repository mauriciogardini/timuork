function Chat (chat_id) {
    var self = this;
    this.timestamp = '';
    this.chat_id = chat_id;
    this.update = updateChat(this.timestamp, this.chat_id, function(data) {
    self.timestamp = data.messages ? data.messages[data.messages.length - 1].timestamp : self.timestamp   
    });
    this.send = sendMessage;
}

function updateChat(timestamp, chat_id){
    $.ajax({
        type: "GET",
        url: "/projects/update/" + chat_id,
        data: { 'timestamp': timestamp },
        dataType: "json",
        success: function(data){
            if(data.messages){
                for (var i = 0; i < data.messages.length; i++) {
                    $('#chat').append($("<p><b>"+ data.messages[i].name + "</b> - " + (data.messages[i]).text +"</p>"));   
                }
            }
            else {
                alert('No new messages!')
            }
        },
        error: function(xhr, status, error){
            alert(xhr.responseText)
        }
    });
}

function sendMessage(text, user_id, chat_id){
    $.ajax({
        type: "POST",
        url: "/projects/sendMessage/" + chat_id,
        data: { 'timestamp': Math.round(new Date().getTime() / 1000),
                'user_id': user_id,
                'text': text
        },
        error: function(xhr, status, error){
            alert(xhr.responseText)
        }
    });
}
