<?php
function start_session($username) {
    if (session_id() == "") {
        session_start();
    }
    //TODO: Verificar se o usuário existe no banco.
    $_SESSION['username'] = $username;
}

function quit_session() {
    if (session_id() == "") {
        session_start();
    }
    session_destroy();
}

function check_session()
{
    if (session_id() == "") {
        session_start();
    }    
    if (isset($_SESSION['username'])) {
        return true;
    }
    else {
        return false;
    }
}
