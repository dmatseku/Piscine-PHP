<?php

require_once "sql_main.php";

function get_index_content($max_count = 3) {
    $sql_link = connect();

    $result = call_procedure($sql_link, "get_limited_products(?)", "i", $max_count);

    mysqli_close($sql_link);
    return ($result);
}

function get_desired_content($category, $product) {
    $sql_link = connect();

    $result = call_procedure($sql_link, "get_desired_products(?, ?)", "ss", $category, $product);

    mysqli_close($sql_link);
    return ($result);
}

function get_orphan_content($mask) {
    $sql_link = connect();

    $result = call_procedure($sql_link, "get_orphan_products(?)", "s", $mask);

    mysqli_close($sql_link);
    return ($result);
}

function get_products_data($products) {
    $sql_link = connect();

    $result = array();
    if ($stmt = mysqli_prepare($sql_link, "CALL get_product(?)")) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        foreach ($products as $id => $count) {
            if (mysqli_stmt_execute($stmt)) {
                $query = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($query)) {
                    $result[$id] = $row;
                }

                mysqli_free_result($query);
                while (mysqli_next_result($sql_link)) {
                    mysqli_store_result($sql_link);
                }
            } else {
                mysqli_close($sql_link);
                init_error();
            }
        }
    } else {
        mysqli_close($sql_link);
        init_error();
    }

    mysqli_close($sql_link);
    return ($result);
}

function get_product($id) {
    $sql_link = connect();

    $result = call_procedure($sql_link, "get_product(?)", "i", $id)[0];

    mysqli_close($sql_link);
    return ($result);
}

function get_product_id_by_name($name) {
    $sql_link = connect();

    $result = false;
    if ($procedure_result = call_procedure($sql_link, "get_product_id_by_name(?)", "s", $name)) {
        $result = $procedure_result[0]["product_id"];
    }

    mysqli_close($sql_link);
    return ($result);
}

function product_is_exist($id) {
    $sql_link = connect();

    $result = false;
    if (call_procedure($sql_link, "product_is_exists(?)", "i", $id)) {
        $result = true;
    }

    mysqli_close($sql_link);
    return ($result);
}

function product_name_is_taken($name) {
    $sql_link = connect();

    $result = false;
    if (call_procedure($sql_link, "get_product_id_by_name(?)", "s", $name)) {
        $result = true;
    }

    mysqli_close($sql_link);
    return ($result);
}

function get_categories_list() {
    $sql_link = connect();

    $result = call_procedure($sql_link, "get_categories_list()");

    mysqli_close($sql_link);
    return ($result);
}

function get_full_categories_list() {
    $sql_link = connect();

    $result = call_procedure($sql_link, "get_full_categories_list()");

    mysqli_close($sql_link);
    return ($result);
}

function get_dependencies_for_product($id) {
    $sql_link = connect();

    $result = array();
    $procedure_result = call_procedure($sql_link, "get_dependencies_for_product(?)", "i", $id);

    if ($procedure_result) {
        foreach ($procedure_result as $k => $v) {
            array_push($result, $v['c_id']);
        }
    }

    mysqli_close($sql_link);
    return ($result);
}

function delete_dependency($p_id, $c_id) {
    $sql_link = connect();

    call_procedure($sql_link, "delete_dependency(?, ?)", "ii", $p_id, $c_id);

    mysqli_close($sql_link);
}

function create_product($product_name, $product_price, $product_image_link) {
    $sql_link = connect();

    if (!call_procedure($sql_link, "insert_new_product(?, ?, ?)", "sis", $product_name, $product_price, $product_image_link)) {
        mysqli_close($sql_link);
        return false;
    }

    mysqli_close($sql_link);
    return true;
}

function update_product($product_id, $product_name, $product_price, $product_image_link) {
    $sql_link = connect();

    call_procedure($sql_link, "update_product(?, ?, ?, ?)", "isis", $product_id, $product_name, $product_price, $product_image_link);

    mysqli_close($sql_link);
}

function delete_product($product_id) {
    $sql_link = connect();

    $result = call_procedure($sql_link, "delete_product(?)", "i", $product_id);

    mysqli_close($sql_link);
    return ($result);
}

function create_category($category_name) {
    $sql_link = connect();

    if (!call_procedure($sql_link, "insert_new_category(?)", "s", $category_name)) {
        mysqli_close($sql_link);
        return false;
    }

    mysqli_close($sql_link);
    return true;
}

function update_category_name($old_name, $new_name) {
    $sql_link = connect();

    $result = false;
    if (call_procedure($sql_link, "update_category_name(?, ?)", "ss", $old_name, $new_name)) {
        $result = true;
    }

    mysqli_close($sql_link);
    return ($result);
}

function delete_category($category_id) {
    $sql_link = connect();

    $result = call_procedure($sql_link, "delete_category(?)", "i", $category_id);

    mysqli_close($sql_link);
    return ($result);
}

function add_dependency($product_id, $category_id) {
    $sql_link = connect();

    call_procedure($sql_link, "add_dependency(?, ?)", "ii", $product_id, $category_id);

    mysqli_close($sql_link);
}

//EOF