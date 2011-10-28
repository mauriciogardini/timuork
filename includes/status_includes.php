<?php
require_once("database_includes.php");

function status_manage($status_info) {
    if (status_exists($status_info)) {
        return status_update($status_info);
    }
    else {
        return status_create($status_info);
    }    
}

function status_update($status_info) {
    $sql = "UPDATE online_users SET last_seen_at = ? WHERE user_id = ? AND chat_id = ?";
    $values = array($status_info->timestamp, $status_info->user_id, $status_info->chat_id);
    return (bool) database_query($sql, $values)->rowCount();
}

function status_create($status_info) {
    $sql = "INSERT INTO online_users(id, chat_id, user_id, last_seen_at) VALUES(NULL, ?, ?, ?)";
    $values = array($status_info->chat_id, $status_info->user_id, $status_info->timestamp);
    return (bool) database_query($sql, $values)->rowCount();    
}

function status_exists($status_info) {
    $sql = "SELECT COUNT(*) AS count FROM online_users WHERE chat_id = ? AND user_id = ?";
    $values = array($status_info->chat_id, $status_info->user_id);
    $count = database_fetch(database_query($sql, $values))->count;
    return $count;
}

function status_list($fn, $chat_id) {
    $sql = "SELECT * FROM online_users WHERE chat_id = ?";
    $sth = database_query($sql, array($chat_id));
    database_iterate($sth, $fn);
}
