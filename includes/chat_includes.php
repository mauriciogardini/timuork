<?php
require_once("database_includes.php");

function chat_by_project_id($project_id) {
    $sql = "SELECT * FROM chats WHERE project_id = ? AND user_id = -1";
    $values = array($project_id);
    return database_fetch(database_query($sql, $values));
}

function chat_by_project_id_and_user_id($project_id, $user_id) {
    $sql = "SELECT * FROM chats WHERE project_id = ? AND user_id = ?";
    $values = array($project_id, $user_id);
    return database_fetch(database_query($sql, $values));
}

function chat_create($project_id, $user_id) {
    $sql = "INSERT INTO chats(id, project_id, user_id) VALUES(NULL, ?, ?)";
    $values = array($project_id, $user_id);
    return (bool) database_query($sql, $values)->rowCount();
}
