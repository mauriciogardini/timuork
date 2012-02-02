function Home() {
    var addUserUrl = "/users/add/";
    var loginUrl = "/login";

    var addUserCallback = function(data) {
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
            twitter: $("#twitter").val(),
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
