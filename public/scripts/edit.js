function Edit() {
    var loadedUsers = {};
    var currentTimestamp = 0;

    var editProjectCallback = function(data){
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
            $("#modalEdit").modal("hide");
            $("#projectTitle").text(data.project.title);
            $("#projectDescription").text(data.project.description);
        }
    };

    var errorCallback = function(xhr, status, error) {
        console.log("Erro");
        console.log(arguments);
    };

    self.editProject = function() {
        var projectId = $("[data-project-id]").data("project-id");
        var adminUserId = $("[data-admin-user-id]").data("admin-user-id");
        var editProjectUrl = $("[data-edit-project-url]").data("edit-project-url");
        var users = [];
        $("[data-select-user-id]").each(function() {
            users.push($(this).data("select-user-id")); 
        });
        users.push(adminUserId);
        var data = {
            users : users,
            projectId : projectId,
            title : $("#title").val(),
            description : $("#description").val(),
            adminUserId : adminUserId
        };
        $.post(editProjectUrl, data, editProjectCallback, "json")
            .error(errorCallback);
    }

    self.fillEditProjectModal = function() {
        //Fazer post p/ pegar os dados do modal ou pegar de 
        //alguma forma no HTML?
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

    $("#editProject").submit(function(e) {
        console.log("Edição");
        self.editProject();
        e.preventDefault();
    });

    $("#editProject").on("show", function() {
        e.preventDefault();
        console.log("Preenchendo modal");
        self.fillEditProjectModal();
    });

    $("#addUser").click(function(e) {
        console.log("Adicionar usuário");
        self.addUser();
    });

    $("#removeUser").click(function(e) {
        console.log("Remover usuário");
        self.removeUser(); 
    });

    $("#newUser").typeahead({
        source: function(query, callback) {
            var projectId = $("[data-project-id]").data("project-id");
            var adminUserId = $("[data-admin-user-id]").data("admin-user-id");
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
