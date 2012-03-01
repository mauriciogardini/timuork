function Chat() {
    var self = this;
    var timestamp = "";

    var messageTemplate = '<p href="#modalNotification" data-toggle="modal" class="chat-paragraph"><span class="chat-username"><b>{{messageUserName}}</b></span></br><span class="chat-text">{{messageText}}</span></p>';
    var adminUserTemplate = '<p class="admin-online-users-row">{{userName}}</p>';
    var userTemplate = '<p class="online-users-row">{{userName}}</p>';
    var linkTemplate = '<a href="{{linkUrl}}">{{linkCaption}}</a><br />';

    var updateProjectMessagesCallback = function(data) {
        if(data.messages && data.messages.length) {
            $.each(data.messages, function(index, message) {
                var a = Mustache.render(messageTemplate, {messageUserName : message.user_name,
                    messageText : message.message_text}); 
                $("#chat").append(a); 
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
                    var p = Mustache.render(adminUserTemplate, {userName : user.name});
                }
                else {
                    var p = Mustache.render(userTemplate, {userName : user.name});
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
                var a = Mustache.render(linkTemplate, {linkUrl : link.url, linkCaption : link.caption});
                $("#links").append(a);
            });
        }
        setTimeout(self.getLinks, 5000);
    }

    var createNotificationCallback = function(data){
        $("#modalNotification").modal("hide");
    };
 
    var sendMessageCallback = function(){
        $("#message").val("");
        $("#message").focus();
    };

    var createLinkCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.popover({ placement: "right", title: "Erro", content: error });
                    div.removeclass("success").addClass("error");
                }
                else {
                    div.removeClass("error").addClass("success");
                }
            });
        }
        else {
            console.log("Sem erros");
            $("#modalLink").modal("hide");
            $(".success, .error").popover("hide");
            $("#caption").val("");
            $("#url").val("");
        }
    };

        var errorCallback = function(xhr, status, error) {
        console.log("Erro");
        console.log(arguments);
    };

    self.update = function() {
        var updateProjectMessagesUrl = $("[data-update-project-messages-url]").data("update-project-messages-url") + 
            $("[data-project-id]").data("project-id");
        $.getJSON(updateProjectMessagesUrl, {timestamp: timestamp}).success(updateProjectMessagesCallback)
            .error(errorCallback);
    };

    self.sendMessage = function() {
        var sendMessageUrl = $("[data-send-message-url]").data("send-message-url"); 
        var projectId = $("[data-project-id]").data("project-id"); 
        var userId = $("[data-user-id]").data("user-id"); 
        var data = {
            text: $("#message").val(),
            projectId: projectId,
            userId: userId
        };
        $.post(sendMessageUrl, data).success(sendMessageCallback)
            .error(errorCallback);
    }

    self.getUsers = function() {
        var updateOnlineUsersUrl = $("[data-update-online-users-url]").data("update-online-users-url") + 
            $("[data-project-id]").data("project-id");
        $.getJSON(updateOnlineUsersUrl).success(updateOnlineUsersCallback)
            .error(errorCallback);
    }

    self.getLinks = function()  {
        var updateLinksUrl = $("[data-update-links-url]").data("update-links-url") + 
            $("[data-project-id]").data("project-id");
        $.getJSON(updateLinksUrl).success(updateLinksCallback)
            .error(errorCallback);
    }

    self.createNotification = function() {
        createNotificationUrl = $("[data-create-notification-url]").data("create-notification-url");
        users = $("#userSelect :selected").attr('id');
        var projectId = $("[data-project-id]").data("project-id"); 
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
        var createLinkUrl = $("[data-create-link-url]").data("create-link-url");
        var projectId = $("[data-project-id]").data("project-id"); 
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
