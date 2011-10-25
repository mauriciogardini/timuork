<?php
function validate_password($password) {
    if (strlen($password) <= 24 && strlen($password) >= 6) {
        return true;
    }
    else {
        return false;
    }
}

function validate_username($username) {
    if (preg_match('/^[a-zA-Z0-9_]{1,60}$/', $username)) {
        return true;
    }
    else {
        return false;
    }
}

function validate_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == $email) {
        return true;
    }
    else {
        return false;
    }
}
