function Dashboard() {
    var loadedUsers = {};

    var myProjectLinkTemplate = '<p class="project-link"><a class="my-project-link" href="/projects/view/{{projectId}}"><i class="icon-share-alt icon-white"></i></a><a class="my-project-link" href="/projects/overview/{{projectId}}"><i class="icon-search icon-white"></i></a>{{caption}}</p>';
    var otherProjectLinkTemplate = '<p class="project-link"><a class="other-project-link" href="/projects/view/{{projectId}}"><i class="icon-share-alt icon-white"></i></a><a class="other-project-link" href="/projects/overview/{{projectId}}"><i class="icon-search icon-white"></i></a>{{caption}}</p>';
    var modalLinkTemplate = '<p id="new-project-link"><a data-add-project-url="/projects/add" data-toggle="modal" href="{{modalId}}">{{caption}}</a></p>';
    var otherProjectsPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.</div>';
    var myProjectsPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.<p><a data-toggle="modal" href="{{modalId}}">{{caption}}</a></p></div>'
    var notificationsPlaceholderTemplate = '<div class="notification-placeholder">Não há notificações a serem exibidas.</div>';
    var notificationLinkTemplate = '<a class="notificationLink" href="#" data-notification-id="{{notificationId}}" data-notification-title="{{notificationTitle}}" data-notification-description="{{notificationDescription}}" data-notification-timestamp="{{notificationTimestamp}}" data-notification-sender-id="{{notificationSenderId}}" data-notification-sender-name="{{notificationSenderName}}" data-notification-project-id="{{notificationProjectId}}" data-notification-project-title="{{notificationProjectTitle}}" data-notification-date="{{notificationDate}}">"{{notificationTitle}}"</a> - Enviado há {{timeSinceNotification}} no projeto <a href="/projects/overview/{{notificationProjectId}}">{{notificationProjectTitle}}</a><br />';
    var notificationProjectLinkTemplate = '<a href="/projects/view/{{projectId}}">{{caption}}</a>';
    var notificationTemplate = '<div class="notification"><a class="notificationLink" href="/projects/view/{{projectId}}"></a><div class="notificationHeader"><div class="notificationTitle">{{notificationTitle}}</div><div class="notificationProjectTitle">(Projeto "{{projectTitle}}")</div><div class="notificationSender">{{notificationSender}}</div><div class="notificationTimestamp">{{timeSinceNotification}}</div></div><div class="notificationBody">{{notificationDescription}}</div></div>';

    var updateNotificationsCallback = function(data) {
        $("#notifications").empty();
        if(data.notifications && data.notifications.length) {
            $.each(data.notifications, function(index, notification) {
                var timestamp = new Date((notification.timestamp)*1000);  
                var date = 
                    timestamp.getDate().toString().replace(/^(\d)$/, "0$1") + '/' + 
                    (timestamp.getMonth() + 1).toString().replace(/^(\d)$/, "0$1") + '/' +
                    timestamp.getFullYear().toString().replace(/^(\d)$/, "0$1") + " " + 
                    timestamp.getHours().toString().replace(/^(\d)$/, "0$1") + ':' + 
                    timestamp.getMinutes().toString().replace(/^(\d)$/, "0$1") + ':' +
                    timestamp.getSeconds().toString().replace(/^(\d)$/, "0$1");
                var secondsSince = data.now - notification.timestamp;
                if (secondsSince < 60) {
                    var time = Math.floor(secondsSince.toString()) + 
                        " segundo" + ((secondsSince > 1) ? "s" : "").toString() + " atrás";
                }
                else {
                    var minutesSince = secondsSince / 60;
                    if (minutesSince < 60) {
                        var time = Math.floor(minutesSince.toString()) + 
                            " minuto" + ((minutesSince > 1) ? "s" : "").toString() + " atrás";
                    }
                    else {
                        var hoursSince = minutesSince / 60;
                        if (hoursSince < 24) {
                            var time = Math.floor(hoursSince.toString()) +
                                " hora" + ((hoursSince > 1) ? "s" : "").toString() + " atrás";
                        }
                        else {
                            var daysSince = hoursSince / 24; 
                            var time = Math.floor(daysSince.toString()) +
                                " dia" + ((daysSince > 1) ? "s" : "").toString() + " atrás";
                        }
                    }
                }

                var a = Mustache.render(notificationTemplate, {
                    notificationTitle : notification.title, 
                    notificationDescription : notification.description, 
                    notificationTimestamp : notification.timestamp, 
                    notificationSender : notification.sender_user_name,
                    projectId : notification.project_id,
                    projectTitle : notification.project_title,
                    notificationDate : date, timeSinceNotification: time });
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
                var a = Mustache.render(otherProjectLinkTemplate, {projectId: project.id, caption: project.title});
                $("#otherProjects").append(a);
            });
        }
        else {
            var placeholder = Mustache.render(otherProjectsPlaceholderTemplate, {});
            $("#otherProjects").append(placeholder);
        }
    }

    var updateMyProjectsCallback = function(data) {
        $("#myProjects").empty();
        if(data.myProjects && data.myProjects.length) {
            $.each(data.myProjects, function(index, project) {
                var a = Mustache.render(myProjectLinkTemplate, {projectId: project.id, caption: project.title});
                $("#myProjects").append(a);
            });
            var newProject = Mustache.render(modalLinkTemplate, {modalId: "#modalProject", caption: "Novo Projeto"});
            $("#myProjects").append(newProject);
        }
        else {
            var placeholder = Mustache.render(myProjectsPlaceholderTemplate, {modalId: "#modalProject", caption: "Crie um novo."});
            $("#myProjects").append(placeholder);
        }
    }

    var addProjectCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.showPopover({ placement: "right", title: "Erro", content: error });
                    div.removeClass("success").addClass("error");
                }
                else {
                    div.hidePopover();
                    div.removeClass("error").addClass("success");
                }
            });
        }
        else {
            location.reload(); 
        }
    }

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    }

    self.addUser = function() {
        var user = $("#newUser").val();
        if(loadedUsers[user]) {
            var userOption = $("<option />").attr("data-select-user-id", loadedUsers[user]).text(user);
            $("#users").append(userOption);
            $("#newUserDiv").hidePopover();
            $("#newUserDiv").removeClass("error");
            $("#newUser").val("");
        }
        else {
            $("#newUserDiv").showPopover({ placement: "right", title: "Erro", 
                content: "Usuário inexistente."}); 
            $("#newUserDiv").addClass("error");
        }
        $("#newUser").focus();
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
        $.post(addProjectUrl, data, addProjectCallback)
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
        self.addProject();
    });

    $("#addUser").click(function(e) {
        self.addUser(); 
    });

    $("#removeUser").click(function(e) {
        self.removeUser(); 
    });

    $("#modalProject").on("hide", function() { 
        $("#title").val("");
        $("#description").val("");
        $("#newUser").val("");
        $("#users option").each(function(i, selected) {
            $(selected).remove();
        });
        $(".modal-body .control-group").removeClass("error").removeClass("success");
        $(".control-group").hidePopover();
    });

    $("#modalProject").on("show", function() {
        $("#newUser").focus();
    });
    $(".div-content").on("click", ".notificationLink", function(e) {
        $("#viewNotificationModalHeaderTitle").text($(this).attr("data-notification-title"));
        var projectId = $(this).attr("data-notification-project-id");
        var a = Mustache.render(notificationProjectLinkTemplate, {projectId: projectId, caption: "Ir para o projeto"});
        $("#notificationTimestamp").text($(this).attr("data-notification-date"));
        $("#notificationTitle").text($(this).attr("data-notification-title"));
        $("#notificationSender").text($(this).attr("data-notification-sender-name"));
        $("#notificationDescription").text($(this).attr("data-notification-description"));
        $("#notificationProjectLink").text("");
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
