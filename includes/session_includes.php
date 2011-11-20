<?php
function start_session($username) {
    if (session_id() == "") {
        session_start();
    }
    //TODO: Verificar se o usuário existe no banco.
    $_SESSION['username'] = $username;
}

function quit_session() {
    if (check_session()) {
        session_destroy();
    }
}

function check_session() {
    if (isset($_SESSION['username'])) {
        return true;
    }
    else {
        return false;
    }
}

function get_session() {
    return check_session() ? $_SESSION['username'] : NULL;
}
