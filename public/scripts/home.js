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

    self.addUser = function(form) {
        var form = $(form);
        var action = form.attr("action");
        var data = form.serialize();
        $.post(action, data, addUserCallback, "json").error(errorCallback);
    }

    $("#addUser").submit(function(e) {
        e.preventDefault();
        self.addUser(this);
    });
}
