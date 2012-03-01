var editSettingsCallback = function(data) {
    if(data.errors) {
        $.each(data.errors, function(index, error) {
            var div = $("input[name=" + index + "]").parent().parent();
            if (error) {
                div.popover({ placement: "right", title: "Erro", content: error }); 
                div.removeClass("success").addClass("error"); }
            else {
                div.removeClass("error").addClass("success");
            }
        });
    }
    else {
        console.log("Sem erros");
        $("[data-user-name]").data("user-name", $("#name").val());
        $("[data-user-email]").data("user-email", $("#email").val());
        $("[data-user-account-value]").data("user-account-value", $("#accountValue").val());
        $(".success, .error").popover("hide");
        $(".modal-body .control-group").removeClass("error").removeClass("success");
        $("#modalSettings").modal("hide");
    }
}

var errorCallback = function(xhr, status, error) {
    console.log(arguments);
}

self.editSettings = function() {
    var editSettingsUrl = $("[data-edit-settings-url]").data("edit-settings-url");
    var username = $("[data-user-username]").data("user-username"); 
    var userId = $("[data-user-id]").data("user-id");
    var accountId = $("[data-user-account-id]").data("user-account-id");
    var data = {
        username: username,
        id: userId,
        name: $("#name").val(),
        email: $("#email").val(),
        accountType: $('#accountType option[selected="selected"]').val(),
        accountValue: $("#accountValue").val(),
        accountId: accountId,
        newPassword: $("#newPassword").val(),
        oldPassword: $("#oldPassword").val()
    }
    console.log(data);
    $.post(editSettingsUrl, data, editSettingsCallback, "json")
        .error(errorCallback);
}

$("#settings").submit(function(e) {
    e.preventDefault(); 
    console.log("Atualizar configurações");
    self.editSettings();
});

$("#modalSettings").on("show", function() {
    console.log($("[data-user-name]").data("user-name"));
    $(".success, .error").popover("hide");
    $(".success, .error").popover("disable");
    $(".popover").remove();
    $(".modal-body .control-group").removeClass("error").removeClass("success");
    $("#name").val($("[data-user-name]").data("user-name"));
    $("#email").val($("[data-user-email]").data("user-email"));
    $("#accountValue").val($("[data-user-account-value]").data("user-account-value"));
    $("#newPassword").val("");
    $("#oldPassword").val("");
});

$(function () {
    $('.tabs a:last').tab('show')
})
