<?php
require_once("database_includes.php");

function message_create($message) {
    $sql = "INSERT INTO messages(id, text, date_time, chat_id, user_id) VALUES(NULL, ?, ?, ?, ?)";
    $values = array($message->text, $message->date_time, $message->chat_id, $message->user_id);
    return (bool) database_query($sql, $values)->rowCount();
}

function message_by_chat_id($fn, $chat_id) {
    $sql = "SELECT * FROM messages WHERE chat_id = ?"; 
    $values = array($chat_id);
    database_iterate(database_query($sql, $values), $fn);
}
