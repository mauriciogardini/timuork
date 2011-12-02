function Chat(projectId, chatId, userId) {
    var self = this;

    var timestamp = "";

    var updateChatMessagesUrl = "/projects/updateChatMessages/" + chatId;
    var sendMessageUrl = "/projects/sendMessage/" + chatId;
    var updateOnlineUsersUrl = "/projects/updateOnlineUsers/" + projectId;
    
    var updateChatMessagesCallback = function(data) {
        console.log(timestamp);
        if(data.messages && data.messages.length) {
            $.each(data.messages, function(index, message) {
                $("#chat").append($("<p><b>"+ message.name + "</b> - " + message.text +"</p>"));   
            });
            timestamp = data.messages[data.messages.length - 1].date_time;
        }
        else {
            console.log("No new messages");
        }
        setTimeout(self.update, 5000);
    };

    var sendMessageCallback = function(){};

    var updateOnlineUsersCallback = function(data) {
        console.log('Users updated');
        if(data.onlineUsers && data.onlineUsers.length) {
            $("#online-users").empty();
            $.each(data.onlineUsers, function(index, user) {
                $("#online-users").append($("<p>" + user.name + "</p>"));
            });
        }

        setTimeout(self.getUsers, 5000);
    };

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    };

    self.update = function() {
        $.getJSON(updateChatMessagesUrl, {timestamp: timestamp}).success(updateChatMessagesCallback)
            .error(errorCallback);
    };

    self.sendMessage = function() {
        var data = {
            text: $("#text").val(),
            chatId: chatId,
            userId: userId
        };
        $.post(sendMessageUrl, data).success(sendMessageCallback)
            .error(errorCallback);
    }

    self.getUsers = function() {
        $.getJSON(updateOnlineUsersUrl).success(updateOnlineUsersCallback)
            .error(errorCallback);
    }

    self.update();
    self.getUsers();

    $("#new-message").submit(function(e) {
        self.sendMessage();
        $("#text").val("");
        e.preventDefault();
    });
}
