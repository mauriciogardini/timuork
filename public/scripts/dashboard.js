function Dashboard() {
    var loadedUsers = {};

    var projectLinkTemplate = '<a href="/projects/overview/{{projectId}}">{{caption}}</a><br />';
    var modalLinkTemplate = '<p id="new-project-link"><a data-add-project-url="/projects/add" data-toggle="modal" href="{{modalId}}">{{caption}}</a></p>';
    var otherProjectsPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.</div>';
    var myProjectsPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.<p><a data-toggle="modal" href="{{modalId}}">{{caption}}</a></p></div>'
    var notificationsPlaceholderTemplate = '<div class="notification-placeholder">Não há notificações a serem exibidas.</div>';
 
    var addProjectCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.popover({ placement: "left", title: "Erro", "content": error }); div.removeClass("success").addClass("error"); }
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
            $("#title").val("");
            $("#description").val("");
        }
    }

    var updateNotificationsCallback = function(data) {
        $("#notifications").empty();
        if(data.notifications && data.notifications.length) {
            $.each(data.notifications, function(index, notification) {
                console.log("Notificações - "+notification.title);
                var a = $("<a href=\"/notifications/view/"+notification.id+"\">"+notification.title+"</a><br />");
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

    var editSettingsCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.popover({ placement: "left", title: "Erro", "content": error }); div.removeClass("success").addClass("error"); }
                else {
                    div.removeClass("error").addClass("success");
                }
            });
        }
        else {
            console.log("Sem erros");
            $(".success, .error").popover("hide");
            $(".modal-body .control-group").removeClass("error").removeClass("success");
            $("#modalSettings").modal("hide");
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
            $("#newUserDiv").popover("hide");
            $("#newUserDiv").removeClass("error");
            $("#newUser").val("");
        }
        else {
            $("#newUserDiv").popover({ placement: "right", title: "Erro",
                "content": "Usuário inexistente."});
            $("#newUserDiv").addClass("error");
        }
    }

    self.removeUser = function() {
        var index = $("#users")
        $('#users :selected').each(function(i, selected) {
            $(selected).remove();
        });
    }
  

    self.editSettings = function() {
        var editSettingsUrl = $("[data-edit-settings-url]").data("edit-settings-url");
        var username = $("[data-user-username]").data("user-username"); 
        var userId = $("[data-user-id]").data("user-id");
        var accountId = $("[data-user-account-id]").data("user-account-id");
        var data = {
            username: username,
            id: userId,
            name: $("#name").val(),
            email: $("#email").val(),
            accountType: $('#accountType option[selected="selected"]').val(),
            accountValue: $("#accountValue").val(),
            accountId: accountId,
            newPassword: $("#newPassword").val(),
            oldPassword: $("#oldPassword").val()
        }
        console.log(data);
        $.post(editSettingsUrl, data, editSettingsCallback, "json")
            .error(errorCallback);
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

    $("#settings").submit(function(e) {
        e.preventDefault(); 
        console.log("Atualizar configurações");
        self.editSettings();
    });

    $("#modalSettings").on("show", function() {
        $("#name").val($("[data-user-name]").data("user-name"));
        $("#email").val($("[data-user-email]").data("user-email"));
        $("#accountValue").val($("[data-user-account-value]").data("user-account-value"));
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
