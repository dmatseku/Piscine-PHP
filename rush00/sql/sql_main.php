<?php

function init_error() {
    header("Location: /error/50x.html");
    exit;
}

function call_procedure($sql_link, $string_query, $string_args = "", ...$args) {
    $result = array();

    if ($stmt = mysqli_prepare($sql_link, "CALL ".$string_query)) {
        if ($string_args != "") {
            if (!mysqli_stmt_bind_param($stmt, $string_args, ...$args)) {
                return false;
            }
        }
        if (mysqli_stmt_execute($stmt)) {
            if ($query = mysqli_stmt_get_result($stmt)) {
                while ($row = mysqli_fetch_assoc($query)) {
                    array_push($result, $row);
                }

                mysqli_free_result($query);
            }
            while (mysqli_next_result($sql_link) && $del = mysqli_store_result($sql_link)) {
                mysqli_free_result($del);
            }
        } else {
            mysqli_close($sql_link);
            init_error();
        }
    } else {
        mysqli_close($sql_link);
        init_error();
    }

    if (empty($result)) {
        $result = false;
    }
    return $result;
}

function connect() {
    $link = "";
    $login = "";
    $password = "";
    $database = "";

    $sql_link = mysqli_connect($link, $login, $password, $database, 3306);
    if (!$sql_link) {
        init_error();
    }
    return $sql_link;
}

//EOF
