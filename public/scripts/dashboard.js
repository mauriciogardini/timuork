function Dashboard(userId) {
    var addProjectUrl = "/projects/add/";
    var updateMyProjectsUrl = "/projects/updateMyProjects/";
    var updateOtherProjectsUrl = "/projects/updateOtherProjects/";
    var updateNotificationsUrl = "/projects/updateNotifications/";

    var projectLinkTemplate = '<a href="/projects/overview/{{projectId}}">{{caption}}</a><br />';
    var modalLinkTemplate = '<p id="new-project-link"><a data-toggle="modal" href="{{modalId}}">{{caption}}</a></p>';
    var projectPlaceholderTemplate = '<div class="project-placeholder">Não há projetos a serem exibidos.</div>';
    var notificationPlaceholderTemplate = '<div class="notification-placeholder">Não há notificações a serem exibidas.</div>';
 
    var addProjectCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.popover({ placement: "left", title: "Erro",
                        "content": error });
                    div.removeClass("success").addClass("error");
                }
                else {
                    div.removeClass("error").addClass("success");
                }
            });
        }
        else {
            console.log("Sem erros");
            //TODO - Os popovers precisam ser removidos para que, caso queira-se incluir mais de um
            //projeto, não sejam apresentadas informações referentes à validação de caráter 
            //duvidoso.
            //$(".success, .error").popover("hide");
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
            var placeholder = Mustache.render(notificationPlaceholderTemplate, {});
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
            var placeholder = Mustache.render(projectPlaceholderTemplate, {});
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
            var placeholder = Mustache.render(projectPlaceholderTemplate, {});
            $("#myProjects").append(placeholder);
        }

        setTimeout(self.getMyProjects, 5000);
    }

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    }

    self.addProject = function() {
        var data = {
            title: $("#title").val(),
            description: $("#description").val(),
            userId: userId 
        };

        $.post(addProjectUrl, data, addProjectCallback, "json")
            .error(errorCallback);
    }

    self.getMyProjects = function() {
        $.getJSON(updateMyProjectsUrl).success(updateMyProjectsCallback)
            .error(errorCallback);
    }
    
    self.getOtherProjects = function() {
        $.getJSON(updateOtherProjectsUrl).success(updateOtherProjectsCallback)
            .error(errorCallback);
    }
   
    self.getNotifications = function() {
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
}
