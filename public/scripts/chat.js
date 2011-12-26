function Chat(projectId, chatId, userId) {
    var self = this;

    var timestamp = "";

    var sendMessageUrl = "/projects/sendMessage/" + chatId;
    var updateChatMessagesUrl = "/projects/updateChatMessages/" + chatId;
    var updateOnlineUsersUrl = "/projects/updateOnlineUsers/" + projectId;
    var createInteractionUrl = "/projects/createInteraction/"; 

    var updateChatMessagesCallback = function(data) {
        if(data.messages && data.messages.length) {
            $.each(data.messages, function(index, message) {
                $("#chat").append($("<p data-controls-modal=\"modal-interaction\" data-backdrop=\"true\" data-keyboard=\"true\" class=\"chat-paragraph\"><span class=\"chat-username\"><b>"+ message.user_name + "</b></span></br><span class=\"chat-text\">" + message.message_text +"</span></p>"));             
            });
            
            timestamp = data.messages[data.messages.length - 1].message_date_time;
            console.log(timestamp);
        }

        setTimeout(self.update, 5000);
    };

    var sendMessageCallback = function(){};

    var updateOnlineUsersCallback = function(data) {
        if(data.onlineUsers && data.onlineUsers.length) {
            $("#online-users").empty();
            $.each(data.onlineUsers, function(index, user) { 
                if(user.admin) {
                    var p = $("<p class=\"admin-online-users-row\" />").text(user.name);
                }
                else {
                    var p = $("<p class=\"online-users-row\" />").text(user.name);
                }
                $("#online-users").append(p);
            });
        }

        setTimeout(self.getUsers, 5000);
    };

    var createInteractionCallback = function(){};

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    };

    self.update = function() {
        $.getJSON(updateChatMessagesUrl, {timestamp: timestamp}).success(updateChatMessagesCallback)
            .error(errorCallback);
    };

    self.sendMessage = function() {
        var data = {
            text: $("#message-text").val(),
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

    self.createInteraction = function() {
        console.log("Chegou");
        var usersTemp = new Array();
        usersTemp[0] = $("#normalSelect").find('option:selected').attr('id');
        users = usersTemp.toString();
        console.log(users);
        var data = {
            projectId: projectId,
            users: users,
            title: $("#title-text").val(),
            description: $("#description-text").val()
        };
        $.post(createInteractionUrl, data).success(createInteractionCallback)
            .error(errorCallback);
    }

    self.update();
    self.getUsers();

    $("#new-message").submit(function(e) {
        self.sendMessage();
        $("#message-text").val("");
        e.preventDefault();
    });
    
    $("#new-interaction").submit(function(e) {
        console.log("Interação");
        self.createInteraction();
        e.preventDefault();
    });
}
