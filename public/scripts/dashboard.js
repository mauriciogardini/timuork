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
            $("#projects").empty();
            $.each(data.projects, function(index, project) {
                console.log(project.title);
                var a = $("<a href=\"/projects/overview/"+project.id+"\"/><br />").text(project.title);
                $("#projects").append(a);
            });
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
