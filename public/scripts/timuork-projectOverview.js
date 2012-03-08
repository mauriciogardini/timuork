function Edit() {
    var loadedUsers = {};
    var currentTimestamp = 0;
    var allowedUserTemplate = '<option data-select-user-id="{{userId}}">{{userName}}</option>';
    var participantUserTemplate = '<div class="participant-user" data-allowed-user-id="<{{userId}}">{{userName}}</div>';

    var editProjectCallback = function(data){
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent().parent();
                if (error) {
                    div.showPopover({ placement: "left", title: "Erro", content: error });
                    div.removeClass("success").addClass("error"); }
                else {
                    div.hidePopover();
                    div.removeClass("error").addClass("success");
                }
            });
        }
        else { 
            location.reload(); 
        }
    };

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    };

    self.updateAllowedUsers = function() {
        $("#allowedUsers").empty(); 
        var allowedUsers = $("[data-project-allowed-users]").data("project-allowed-users");
        if(allowedUsers) {
            $.each(allowedUsers, function(i, user) {
                var li = Mustache.render(participantUserTemplate, { userId : user.id, userName : user.name });
                $("#allowedUsers").append(li);
            });
        }
    }

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

    self.updateAllowedUsers();

    $("#editProject").submit(function(e) {
        self.editProject();
        e.preventDefault();
    });

    $("#modalEdit").on("show", function() {
        $("#users").empty(); 
        $("#title").val($("[data-project-title]").data("project-title"));
        var adminUserId = $("[data-admin-user-id]").data("admin-user-id"); 
        $("#description").val($("[data-project-description]").data("project-description"));
        $("#newUser").val("");
        var allowedUsers = $("[data-project-allowed-users]").data("project-allowed-users");
        if(allowedUsers) {
            $.each(allowedUsers, function(i, user) {
                if(user.id != adminUserId) {
                    var option = Mustache.render(allowedUserTemplate, { userId : user.id, userName : user.name });
                    $("#users").append(option);
                }
            });
        }
        $(".modal-body .control-group").removeClass("error").removeClass("success");
        $(".control-group").hidePopover();
    });

    $("#addUser").click(function(e) {
        self.addUser();
    });

    $("#removeUser").click(function(e) {
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
