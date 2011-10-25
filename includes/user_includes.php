<?php
require_once("database_includes.php");
require_once("security_includes.php");

function user_first($username) {
    return database_fetch(database_query("SELECT * FROM users WHERE username = ?", array($username)));
}

function user_exists($username) {
    $sql = "SELECT COUNT(*) AS count FROM users WHERE username = ?";
    $count = database_fetch(database_query($sql, array($username)))->count;
    return $count;
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
        $check = words_match($auth_user->password, $user->password);

        if ($check)
            return true;
        else
            return false;
    }
    else {
        return false;
    }
}
