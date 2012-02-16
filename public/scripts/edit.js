function Edit() {
    var loadedUsers = {};
    var currentTimestamp = 0;
    var editProjectUrl = "/projects/edit/";

    var editProjectCallback = function(data){
        var temp = data;
        //Close modal
        //Refresh page
    };

    var errorCallback = function(xhr, status, error) {
        console.log("Erro");
        console.log(arguments);
    };

    self.editProject = function() {
        var projectId = $("#projectId").attr("value");
        var users = [];
        $("#users option").each(function() {
            users.push($(this).attr("value")); 
        });
        users.push($("#userId").attr("value"));
        var data = {
            users : users,
            projectId : projectId,
            title : $("#title").val(),
            description : $("#description").val()
        };
        $.post(editProjectUrl, data).success(editProjectCallback)
            .error(errorCallback);
    }

    self.addUser = function() {
        var user = $("#newUser").val();
        if(loadedUsers[user]) {
            $("#users").append($("<option />", { value : loadedUsers[user], text : user }));
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
            var refreshUsersUrl = $("#newUser").data("search-url");
            var excludeList = [];
            $("#users option").each(function() {
                excludeList.push($(this).attr("value")); 
            });
            excludeList.push($("#userId").attr("value"));
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
