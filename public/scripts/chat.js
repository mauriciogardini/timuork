function Chat(projectId, chatId, userId) {
    var self = this;

    var timestamp = "";

    var sendMessageUrl = "/projects/sendMessage/" + chatId;
    var updateChatMessagesUrl = "/projects/updateChatMessages/" + chatId;
    var updateOnlineUsersUrl = "/projects/updateOnlineUsers/" + projectId;
    var updateLinksUrl = "/projects/updateLinks/" + projectId;
    var createInteractionUrl = "/projects/createInteraction/";
    var createLinkUrl = "/projects/createLink/";

    var updateChatMessagesCallback = function(data) {
        if(data.messages && data.messages.length) {
            $.each(data.messages, function(index, message) {
                $("#chat").append($("<p data-controls-modal=\"modalInteraction\" data-backdrop=\"true\" data-keyboard=\"true\" class=\"chat-paragraph\"><span class=\"chat-username\"><b>"+ message.user_name + "</b></span></br><span class=\"chat-text\">" + message.message_text +"</span></p>"));             
            });
            
            timestamp = data.messages[data.messages.length - 1].message_date_time;
        }

        setTimeout(self.update, 5000);
    };

    var updateOnlineUsersCallback = function(data) {
        if(data.onlineUsers && data.onlineUsers.length) {
            $("#onlineUsers").empty();
            $.each(data.onlineUsers, function(index, user) { 
                if(user.admin) {
                    var p = $("<p class=\"admin-online-users-row\" />").text(user.name);
                }
                else {
                    var p = $("<p class=\"online-users-row\" />").text(user.name);
                }
                $("#onlineUsers").append(p);
            });
        }

        setTimeout(self.getUsers, 5000);
    };

    var updateLinksCallback = function(data) {
        if(data.links && data.links.length) {
            $("#links").empty();
            $.each(data.links, function(index, link) {
                console.log(link.url);
                var a = $("<a href=\""+link.url+"\"/><br />").text(link.caption);
                $("#links").append(a);
            });
        }

        setTimeout(self.getLinks, 5000);
    }

    var createInteractionCallback = function(){};
 
    var sendMessageCallback = function(){
        $("#message").val("");
    };

    var createLinkCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                if (error != null) {
                    $("#"+index).attr("rel", "popover");
                    $("#"+index).attr("title", "Erro");
                    $("#"+index).attr("data-content", error);
                    $("#"+index).attr("html", "true");
                    $("#"+index).popover();
                    $("#"+index).addClass("input-with-error");
                }
                else {
                    $("#"+index).removeClass("input-with-error");
                }
            });
        }
        else {
            console.log("Sem erros");
            $("#modalLink").modal("hide");
            $("#caption").val("");
            $("#url").val("");
        }
    };

    var errorCallback = function(xhr, status, error) {
        console.log("Erro");
        console.log(arguments);
    };

    self.update = function() {
        $.getJSON(updateChatMessagesUrl, {timestamp: timestamp}).success(updateChatMessagesCallback)
            .error(errorCallback);
    };

    self.sendMessage = function() {
        var data = {
            text: $("#message").val(),
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

    self.getLinks = function()  {
        $.getJSON(updateLinksUrl).success(updateLinksCallback)
            .error(errorCallback);
    }

    self.createInteraction = function() {
        var usersTemp = new Array();
        usersTemp[0] = $("#normalSelect").find('option:selected').attr('id');
        users = usersTemp.toString();
        var data = {
            projectId: projectId,
            users: users,
            title: $("#title").val(),
            description: $("#description").val()
        };
        $.post(createInteractionUrl, data).success(createInteractionCallback)
            .error(errorCallback);
    } 

    self.createLink = function() { 
        var data = {
            projectId: projectId,
            caption: $("#caption").val(),
            url: $("#url").val()
        };

        $.post(createLinkUrl, data, createLinkCallback, "json")
            .error(errorCallback);
    } 

    self.update();
    self.getUsers();
    self.getLinks();

    $("#newMessage").submit (function(e) {
        self.sendMessage();
        $("#message").val("");
        e.preventDefault();
    });
    
    $("#newInteraction").submit(function(e) {
        console.log("Interação");
        self.createInteraction();
        e.preventDefault();
    }); 

    $("#newLink").submit(function(e) {
        console.log("Link");
        self.createLink();
        e.preventDefault();
    });
}
