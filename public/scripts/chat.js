function Chat(projectId, userId) {
    var self = this;

    var timestamp = "";

    var sendMessageUrl = "/projects/sendMessage/" + projectId;
    var updateProjectMessagesUrl = "/projects/updateProjectMessages/" + projectId;
    var updateOnlineUsersUrl = "/projects/updateOnlineUsers/" + projectId;
    var updateLinksUrl = "/projects/updateLinks/" + projectId;
    var createNotificationUrl = "/projects/createNotification/";
    var createLinkUrl = "/projects/createLink/";

    var updateProjectMessagesCallback = function(data) {
        if(data.messages && data.messages.length) {
            $.each(data.messages, function(index, message) {
                $("#chat").append($("<p data-controls-modal=\"modalInteraction\" data-backdrop=\"true\" data-keyboard=\"true\" class=\"chat-paragraph\"><span class=\"chat-username\"><b>"+ message.user_name + "</b></span></br><span class=\"chat-text\">" + message.message_text +"</span></p>"));             
            });
            
            timestamp = data.messages[data.messages.length - 1].message_timestamp;
            console.log(timestamp);
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

    var createNotificationCallback = function(){};
 
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
        $.getJSON(updateProjectMessagesUrl, {timestamp: timestamp}).success(updateProjectMessagesCallback)
            .error(errorCallback);
    };

    self.sendMessage = function() {
        var data = {
            text: $("#message").val(),
            projectId: projectId,
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

    self.createNotification = function() {
        users = $("#userSelect :selected").attr('id');
        console.log(users);
        var data = {
            projectId: projectId,
            users: users,
            title: $("#title").val(),
            description: $("#description").val()
        };
        $.post(createNotificationUrl, data).success(createNotificationCallback)
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
    
    $("#newNotification").submit(function(e) {
        console.log("Notificação");
        self.createNotification();
        e.preventDefault();
    }); 

    $("#newLink").submit(function(e) {
        console.log("Link");
        self.createLink();
        e.preventDefault();
    });
}
