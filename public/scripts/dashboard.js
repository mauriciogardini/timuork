function Dashboard(userId) {
    var addProjectUrl = "/projects/add/";
    var updateProjectsUrl = "/projects/updateProjects/";

    var addProjectCallback = function(data) {
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
            $(".input").removeClass("input-with-error");
            $('.modal-body .input-with-error').removeClass('input-with-error')
            $("#title").popover("hide");
            $("#description").popover("hide");
            $("#modalProject").modal("hide");
            $("#title").val("");
            $("#description").val("");
        }
    }

    var updateProjectsCallback = function(data) {
        if(data.projects && data.projects.length) {
            $("#myProjects").empty();
            $.each(data.projects, function(index, project) {
                console.log(project.title);
                var a = $("<a href=\"/projects/overview/"+project.id+"\"/><br />").text(project.title);
                $("#myProjects").append(a);
                var newProject = $("<p id=\"new-project-link\"><a data-toggle=\"modal\" href=\"#modalProject\">Novo Projeto</a></p>");
                $("#myProjects").append(newProject);
                var placeholder2 = $("<div class=\"project-placeholder\">Não há projetos a serem exibidos.</div>");
                var placeholder3 = $("<div class=\"notification-placeholder\">Não há notificações a serem exibidas.</div>");
                $("#otherProjects").empty();
                $("#notifications").empty();
                $("#otherProjects").append(placeholder2);
                $("#notifications").append(placeholder3);
            });
        }
        else {
            $("#myProjects").empty();
            $("#otherProjects").empty();
            $("#notifications").empty();
            var placeholder = $("<div class=\"project-placeholder\">Não há projetos a serem exibidos. <a data-toggle=\"modal\" href=\"#modalProject\">Crie um novo</a>.</div>");
            var placeholder2 = $("<div class=\"project-placeholder\">Não há projetos a serem exibidos.</div>");
            var placeholder3 = $("<div class=\"notification-placeholder\">Não há notificações a serem exibidas.</div>");
            //TODO - GetMyProjects method
            $("#myProjects").append(placeholder);
            //TODO - GetOtherProjects method
            $("#otherProjects").append(placeholder2);
            //TODO - GetNotifications methos
            $("#notifications").append(placeholder3);
        }

        setTimeout(self.getProjects, 5000);
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

    self.getProjects = function() {
        $.getJSON(updateProjectsUrl).success(updateProjectsCallback)
            .error(errorCallback);
    }

    self.getProjects();

    $("#newProject").submit(function(e) {
        console.log("Projeto");
        e.preventDefault();
        self.addProject();
    });
}
