<?php

require_once "sql_main.php";

function register_user($login, $password) {
    $sql_link = connect();

    if (!call_procedure($sql_link, "register_user(?, ?)", "ss", $login, $password)) {
        mysqli_close($sql_link);
        return false;
    }

    mysqli_close($sql_link);
    return true;
}

function remove_user($login) {
    $sql_link = connect();

    if (!call_procedure($sql_link, "remove_user(?)", "s", $login)) {
        mysqli_close($sql_link);
        return false;
    }

    mysqli_close($sql_link);
    return true;
}

function get_user_password($login) {
    $sql_link = connect();

    $result = false;
    if ($procedure_result = call_procedure($sql_link, "get_password(?)", "s", $login)) {
        $result = $procedure_result[0]['user_password'];
    }

    mysqli_close($sql_link);
    return $result;
}

function insert_log($hash, $user_id, $user_agent) {
    $sql_link = connect();

    call_procedure($sql_link, "insert_log(?, ?, ?)", "sis", $hash, $user_id, $user_agent);

    mysqli_close($sql_link);
}

function update_password($login, $new_password) {
    $sql_link = connect();

    call_procedure($sql_link, "update_password(?, ?)", "ss", $login, $new_password);

    mysqli_close($sql_link);
}

function get_user_id_by_login($user_login) {
    $sql_link = connect();

    $result = false;
    if ($procedure_result = call_procedure($sql_link, "get_id_by_login(?)", "s", $user_login)) {
        $result = $procedure_result[0]['user_id'];
    }

    mysqli_close($sql_link);
    return $result;
}

function find_log($user_hash, $user_id) {
    $sql_link = connect();

    $result = false;
    if ($procedure_result = call_procedure($sql_link, "find_log(?, ?, ?)", "sis", $user_hash, $user_id, $_SERVER['HTTP_USER_AGENT'])) {
        $result = $procedure_result[0]['user_login'];
    }

    mysqli_close($sql_link);
    return $result;
}

function clear_old_logs($user_id) {
    $sql_link = connect();

    call_procedure($sql_link, "clear_old_logs(?)", "i", $user_id);

    mysqli_close($sql_link);
}

function give_privileges($id) {
    $sql_link = connect();

    call_procedure($sql_link, "give_privileges(?)", "i", $id);

    mysqli_close($sql_link);
}

function take_privileges_away($id) {
    $sql_link = connect();

    call_procedure($sql_link, "take_privileges_away(?)", "i", $id);

    mysqli_close($sql_link);
}

function get_user_privileges($login) {
    $sql_link = connect();

    $result = false;
    if ($procedure_result = call_procedure($sql_link, "get_privileges_user(?)", "s", $login)) {
        if ($procedure_result[0]['admin_permissions'] == true) {
            $result = true;
        }
    }

    mysqli_close($sql_link);
    return $result;
}

//EOF