<?php
function start_session($username) {
    $s = session_id();
    if (empty($s)) {
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
    $s = session_id();
    if (!empty($s)) {
        return true;
    }
    else {
        return false;
    }
}

function get_session() {
    return check_session() ? $_SESSION['username'] : NULL;
}
