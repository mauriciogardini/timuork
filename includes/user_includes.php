<?php
include_once("database_includes.php");

function user_first($username) {
    return database_fetch(database_query("SELECT * FROM users WHERE username = ?", array($username)));
}

function user_exists($username) {
    $sql = "SELECT COUNT(*) AS count FROM users WHERE username = ?";
    $count = database_fetch(database_query($sql, array($username)))->count;
    return $count;
}

function user_passwords_matches($user) {
    if ($user->password == $user->passwordagain)
        return true;
    else
        return false;
}

function user_create($user) {
    if(!user_exists($user->username)) {
        $sql = "INSERT INTO users(id, name, email, username, password) VALUES(NULL, ?, ?, ?, ?)";
        $values = array($user->name, $user->email, $user->username, $user->password);
        return (bool) database_query($sql, $values)->rowCount();
    }
    else {
        return false;
    }
}

function user_update($user) {
    $sql = "UPDATE users SET name = ?, email = ?, username = ?, password = ? WHERE id = ?";
    $values = array($user->name, $user->email, $user->username, $user->password, $user->id);
    return (bool) database_query($sql, $values)->rowCount();
}

function user_authenticate($auth_user) {
    if(user_exists($auth_user->username)) {
        $user = user_first($auth_user->username);
        if ($user->password == $auth_user->password)
            return true;
        else
            return false;
    }
    else {
        return false;
    }
}
