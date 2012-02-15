function Edit() {

    var currentTimestamp = 0;
    var editProjectUrl = "/projects/edit/";

    var editProjectCallback = function(){
        //Close modal
        //Refresh page
    };

    var errorCallback = function(xhr, status, error) {
        console.log("Erro");
        console.log(arguments);
    };

    self.editProject = function() {
        var projectId = $("#projectId").CSS("id");
        var index = 0;
        var users = [];
        $("#users option").each(function() {
            users[index] = $(this).attr("id"); 
            index++;
        });
        var usersString = users.toString();
        var data = {
            users : usersString,
            projectId : projectId,
            title : $("#title").val(),
            description : $("#description").val()
        };
        $.post(editProjectUrl, data).success(editProjectCallback)
            .error(errorCallback);
    }

    self.addUser = function() {
        var user = $("#newUser").val();
        $("#users").append($("<option />", { value : user, text : user }));
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
            console.log(refreshUsersUrl);
            var excludeList = [];
            var index = 0;
            $("#users option").each(function() {
                excludeList[index] = $(this).attr("id"); 
                index++;
            });
            var excludeListString = excludeList.toString(); 
            $.get(refreshUsersUrl, { searchString: query, excludeList: excludeListString }, function(response) {
                var loadedUsers = [];
                var loadedUsersIds = [];
                var x = 0;
                if (response.users && response.users.length) {
                    $.each(response.users, function(index, user) {
                        loadedUsers[x] = user.name;
                        console.log(user.name);
                        loadedUsersIds[x] = user.id;
                        x++;
                    });
                    console.log("Usuários:");
                    console.log(JSON.stringify(loadedUsers));
                }    
                callback(loadedUsers);
            });
        }
    });
}
