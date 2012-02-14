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

    self.refreshUsers = function() {
        var excludeList = [];
        var userId = $("#userId").attr("id");
        var index = 0;
        $("#users option").each(function() {
            excludeList[index] = $(this).attr("id"); 
            index++;
        });
        excludeList[index] = userId;
        var excludeListString = excludeList.toString(); 
        console.log(excludeListString);
        var data = {
            excludeList : excludeListString,
            searchString : $("#newUser").val()
        };
        $.post(refreshUsersUrl, data, refreshUsersCallback, "json")
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

    self.refreshUsers = function(val, timestamp) {
        var refreshUsersUrl = $("#newUser").data("search-url");
        var excludeList = [];
        var index = 0;
        $("#users option").each(function() {
            excludeList[index] = $(this).attr("id"); 
            index++;
        });
        var excludeListString = excludeList.toString(); 
        $.post(refreshUsersUrl, {searchString: val, excludeList: excludeListString}, function(data) {
            if(timestamp > currentTimestamp) {
                currentTimestamp = timestamp;
                var loadedUsers = [];
                var loadedUsersIds = [];
                var x = 0;
                if (data.users && data.users.length) {
                    $.each(data.users, function(index, user) {
                        loadedUsers[x] = user.name;
                        loadedUsersIds[x] = user.id;
                        x++;
                    });
                    console.log("Usuários:");
                    console.log(JSON.stringify(loadedUsers));
                    $("#newUser").typeahead({ source : loadedUsers });
                    console.log("Typeahead inicializado.");
                }
                else {
                    console.log("Informação descartada.");
                }
            }
        }, "json").error(errorCallback);
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

    $("#newUser").keyup(function(e) {
        console.log("Atualizar lista");
        self.refreshUsers($(this).val(), e.timeStamp);
    });
}
