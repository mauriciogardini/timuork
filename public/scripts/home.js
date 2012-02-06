function Home() {
    var addUserUrl = "/users/add/";
    var loginUrl = "/login";

    var addUserCallback = function(data) {
        if (data.errors) {
            $.each(data.errors, function(index, error) {
                var div = $("input[name=" + index + "]").parent();
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
            $("#loginUsername").val($("#username").val());
            $("#loginPassword").val($("#password").val());
            $("#login").submit();
        }
    };

    var loginCallback = function() {};

    var errorCallback = function(xhr, status, error) {
        console.log(arguments);
    };

    self.addUser = function() {
        var data = {
            name: $("#name").val(),
            email: $("#email").val(),
            account: $("#account").val(),
            accountType: $("#accountType").val(),
            username: $("#username").val(),
            password: $("#password").val()
        };
        $.post(addUserUrl, data, addUserCallback, "json").error(errorCallback);
    }

    $("#addUser").submit(function(e) {
        e.preventDefault();
        self.addUser();
    });
}
