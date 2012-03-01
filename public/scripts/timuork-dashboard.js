function Dashboard() {
    var loadedUsers = {};

    var projectLinkTemplate = '<a href="/projects/overview/{{projectId}}">{{caption}}</a><br />';
    var modalLinkTemplate = '<p id="new-project-link"><a data-add-project-url="/projects/add" data-toggle="modal" href="{{modalId}}">{{caption}}</a></p>';
    var otherProjectsPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.</div>';
    var myProjectsPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.<p><a data-toggle="modal" href="{{modalId}}">{{caption}}</a></p></div>'
    var notificationsPlaceholderTemplate = '<div class="notification-placeholder">Não há notificações a serem exibidas.</div>';
    var notificationLinkTemplate = '<a class="notificationLink" href="#" data-notification-id="{{notificationId}}" data-notification-title="{{notificationTitle}}" data-notification-description="{{notificationDescription}}" data-notification-timestamp="{{notificationTimestamp}}" data-notification-sender-id="{{notificationSenderId}}" data-notification-sender-name="{{notificationSenderName}}" data-notification-project-id="{{notificationProjectId}}" data-notification-project-title="{{notificationProjectTitle}}">{{notificationTitle}} - {{notificationProjectTitle}}</a><br />';
    var notificationProjectLinkTemplate = '<a href="/projects/view/{{projectId}}">{{caption}}</a>';

    var addProjectCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.popover({ placement: "right", title: "Erro", content: error });
                    div.removeClass("success").addClass("error");
                }
                else {
                    div.removeClass("error").addClass("success");
                }
            });
        }
        else {
            console.log("Sem erros");
            $(".success, .error").popover("hide");
            $(".modal-body .control-group").removeClass("error").removeClass("success");
            $("#modalProject").modal("hide");
        }
    }

    var updateNotificationsCallback = function(data) {
        $("#notifications").empty();
        if(data.notifications && data.notifications.length) {
            $.each(data.notifications, function(index, notification) {
                console.log("Notificações - "+notification.title);
                var a = Mustache.render(notificationLinkTemplate, {modalId : "#modalViewNotification", 
                    notificationId : notification.id, notificationTitle : notification.title, 
                    notificationDescription : notification.description, 
                    notificationTimestamp : notification.timestamp, 
                    notificationSenderId : notification.sender_user_id, 
                    notificationSenderName : notification.sender_user_name,
                    notificationProjectId : notification.project_id,
                    notificationProjectTitle : notification.project_title });
                $("#notifications").append(a);
            });
        }
        else {
            var placeholder = Mustache.render(notificationsPlaceholderTemplate, {});
            $("#notifications").append(placeholder);
        }

        setTimeout(self.getNotifications, 5000);
    }

    var updateOtherProjectsCallback = function(data) {
        $("#otherProjects").empty();
        if(data.otherProjects && data.otherProjects.length) {
            $.each(data.otherProjects, function(index, project) {
                console.log("Outros projetos - "+project.title);
                var a = Mustache.render(projectLinkTemplate, {projectId: project.id, caption: project.title});
                $("#otherProjects").append(a);
            });
        }
        else {
            var placeholder = Mustache.render(otherProjectsPlaceholderTemplate, {});
            $("#otherProjects").append(placeholder);
        }

        setTimeout(self.getOtherProjects, 5000);
    }

    var updateMyProjectsCallback = function(data) {
        $("#myProjects").empty();
        if(data.myProjects && data.myProjects.length) {
            $.each(data.myProjects, function(index, project) {
                console.log("Meus projetos - "+project.title);
                var a = Mustache.render(projectLinkTemplate, {projectId: project.id, caption: project.title});
                $("#myProjects").append(a);
            });
            var newProject = Mustache.render(modalLinkTemplate, {modalId: "#modalProject", caption: "Novo Projeto"});
            $("#myProjects").append(newProject);
        }
        else {
            var placeholder = Mustache.render(myProjectsPlaceholderTemplate, {modalId: "#modalProject", caption: "Crie um novo."});
            $("#myProjects").append(placeholder);
        }

        setTimeout(self.getMyProjects, 5000);
    }

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    }

    self.addUser = function() {
        var user = $("#newUser").val();
        if(loadedUsers[user]) {
            var userOption = $("<option />").attr("data-select-user-id", loadedUsers[user]).text(user);
            $("#users").append(userOption);
            $("#newUserDiv").popover("hide");
            $("#newUserDiv").removeClass("error");
            $("#newUser").val("");
        }
        else {
            $("#newUserDiv").popover({ placement: "right", title: "Erro",
                content: "Usuário inexistente."});
            $("#newUserDiv").addClass("error");
        }
    }

    self.removeUser = function() {
        $('#users :selected').each(function(i, selected) {
            $(selected).remove();
        });
    }
  
    self.addProject = function() {
        var allowedUsers = [];
        var addProjectUrl = $("[data-add-project-url]").data("add-project-url");
        var userId = $("[data-user-id]").data("user-id");
        $("#users option").each(function() {
            allowedUsers.push($(this).data("select-user-id")); 
        });
        var data = {
            allowedUsers: allowedUsers,
            title: $("#title").val(),
            description: $("#description").val(),
            userId: userId 
        };

        $.post(addProjectUrl, data, addProjectCallback, "json")
            .error(errorCallback);
    }

    self.getMyProjects = function() {
        updateMyProjectsUrl = $("[data-update-my-projects-url]").data("update-my-projects-url");
        $.getJSON(updateMyProjectsUrl).success(updateMyProjectsCallback)
            .error(errorCallback);
    }
    
    self.getOtherProjects = function() {
        updateOtherProjectsUrl = $("[data-update-other-projects-url]").data("update-other-projects-url");
        $.getJSON(updateOtherProjectsUrl).success(updateOtherProjectsCallback)
            .error(errorCallback);
    }
   
    self.getNotifications = function() {
        updateNotificationsUrl = $("[data-update-notifications-url]").data("update-notifications-url");
        $.getJSON(updateNotificationsUrl).success(updateNotificationsCallback)
            .error(errorCallback);
    }

    if($("#modalWelcome").length) {
        $("#modalWelcome").modal("show");
        setTimeout(function() {
            $("#modalWelcome").modal("hide")
        }, 3000);
    } 
    self.getMyProjects();
    self.getOtherProjects();
    self.getNotifications();
    
    $("#newProject").submit(function(e) {
        e.preventDefault();
        console.log("Projeto");
        self.addProject();
    });

    $("#addUser").click(function(e) {
        console.log("Adicionar usuário");
        self.addUser();
    });

    $("#removeUser").click(function(e) {
        console.log("Remover usuário");
        self.removeUser(); 
    });

    $("#modalProject").on("show", function() {
        $("#title").val("");
        $("#description").val("");
        $("#users option").each(function(i, selected) {
            $(selected).remove();
        });
        $(".modal-body .control-group").removeClass("error").removeClass("success");
        $(".modal-body .control-group").popover("hide");
    });

    $(".div-content").on("click", ".notificationLink", function(e) {
        //TODO - Arrumar a data para ser exibida no formato correto 
        var timestamp = new Date(($(this).attr("data-notification-timestamp"))*1000);
        var date = timestamp.getDate() + '/' + timestamp.getMonth() + '/' + timestamp.getYear() + 
            " " + timestamp.getHours() + ':' + timestamp.getMinutes() + ':' + timestamp.getSeconds();
        $("#viewNotificationModalHeaderTitle").text($(this).attr("data-notification-title"));
        var projectId = $(this).attr("data-notification-project-id");
        var a = Mustache.render(notificationProjectLinkTemplate, {projectId: projectId, caption: "Ir para o projeto"});
        $("#notificationTimestamp").text(date); 
        $("#notificationTitle").text($(this).attr("data-notification-title"));
        $("#notificationSender").text($(this).attr("data-notification-sender-name"));
        $("#notificationDescription").text($(this).attr("data-notification-description"));
        $("#notificationProjectLink").append(a);
        $("#modalViewNotification").modal("show");
    });

    $("#newUser").typeahead({
        source: function(query, callback) {
            var adminUserId = $("[data-user-id]").data("user-id");
            var refreshUsersUrl = $("[data-search-url]").data("search-url");
            var excludeList = [];
            $("[data-select-user-id]").each(function() {
                excludeList.push($(this).data("select-user-id")); 
            });
            excludeList.push(adminUserId);
            console.log(excludeList);
            $.get(refreshUsersUrl, { searchString: query, excludeList: excludeList }, function(response) {
                var users = [];
                if (response.users && response.users.length) {
                    $.each(response.users, function(index, user) {
                        loadedUsers[user.name] = user.id;
                        users.push(user.name);
                    });
                }    
                callback(users);
            });
        }
    });
}
