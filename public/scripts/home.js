function Home() {
    var addUserUrl = "/users/add/";
    var loginUrl = "/login";

    var addUserCallback = function(data) {
        if(data.errors) {
            $.each(data.errors, function(index, error) {
                if (error != null) {
                    $("#"+index+"Div").attr("rel", "popover");
                    $("#"+index+"Div").attr("title", "Erro");
                    $("#"+index+"Div").attr("data-content", error);
                    $("#"+index+"Div").attr("html", "true");
                    $("#"+index+"Div").popover();
                    $("#"+index+"Div").removeClass("success");
                    $("#"+index+"Div").addClass("error");
                }
                else {
                    $("#"+index+"Div").removeClass("error");
                    $("#"+index+"Div").addClass("success");
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
