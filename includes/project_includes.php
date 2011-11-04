<?php
require_once("database_includes.php");

function project_create($project) {
    if(!project_exists($project)) {
        $sql = "INSERT INTO projects(id, name, description, admin_user_id) VALUES(NULL, ?, ?, ?)";
        $values = array($project->name, $project->description, $project->admin_user_id);
        return (bool) database_query($sql, $values)->rowCount();
    }
    else {
        return false;
    }
}

function project_update($project) {
    $sql = "UPDATE projects SET name = ?, description = ? WHERE id = ?";
    $values = array($project->name, $project->description, $project->id);
    return (bool) database_query($sql, $values)->rowCount();
}

function project_exists($project) {
    $sql = "SELECT COUNT(*) AS count FROM projects WHERE name = ? AND admin_user_id = ?";
    $values = array($project->name, $project->admin_user_id);
    $count = database_fetch(database_query($sql, $values))->count;
    return $count;
}

function project_by_id($project_id) {
    $sql = "SELECT * FROM projects WHERE id = ?";
    $values = array($project_id);
    return database_fetch(database_query($sql, $values));
}

function project_by_name($project_name, $user_id) {
    $sql = "SELECT * FROM projects WHERE name = ? AND admin_user_id = ?";
    $values = array($project_name, $user_id);
    return database_fetch(database_query($sql, $values));
}
function is_project_admin($project_id, $user_id) {
    $sql = "SELECT admin_user_id FROM projects WHERE id = ?";
    $values = array($project_id);
    $result = database_fetch(database_query($sql, $values));
    if ($result->admin_user_id == $user_id) { 
        return true; 
    }
    else { 
        return false; 
    } 
}
function project_allowance_exists($project_id, $user_id) {
    $sql = "SELECT COUNT(*) AS count FROM projects_users WHERE project_id = ? AND user_id = ?";
    $values = array($project_id, $user_id);
    $count = database_fetch(database_query($sql, $values))->count;
    return $count;
}

function project_allowed_users_by_project_id($fn, $project_id) {
    $sql = "SELECT users.* FROM users JOIN projects_users ON users.id = projects_users.user_id WHERE projects_users.project_id = ?";
    $values = array($project_id);
    database_iterate(database_query($sql, $values), $fn);
}

function project_allow_user($project_id, $user_id) {
    $sql = "INSERT INTO projects_users(id, project_id, user_id) VALUES(NULL, ?, ?)";
    $values = array($project_id, $user_id);
    return (bool) database_query($sql, $values)->rowCount();
}

function project_disallow_user($project_id, $user_id) {
    $sql = "REMOVE FROM projects_users WHERE project_id = ? AND user_id = ?";
    $values = array($project_id, $user_id);
    return (bool) database_query($sql, $values)->rowCount();
}

function project_by_user_id($fn, $user_id) {
    $sql = "SELECT projects.* FROM projects JOIN projects_users ON projects.id = projects_users.project_id WHERE projects_users.user_id = ?";
    $values = array($user_id);
    database_iterate(database_query($sql, $values), $fn);
}
