<?php
/**
 * MySQL compatibility layer for PHP 8.3
 * Provides mysql_* functions using mysqli (procedural) with global $conn from db.php
 * WARNING: This layer does NOT prevent SQL injection on its own.
 * Existing code should still be refactored to use prepared statements.
 */

if (!function_exists('mysql_connect')) {
    function mysql_connect($host = null, $username = null, $password = null, $new_link = false, $client_flags = 0) {
        // Not used; connection already established in db.php
        global $conn;
        return $conn;
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database, $link_identifier = null) {
        global $conn;
        if ($link_identifier === null) {
            $link_identifier = $conn;
        }
        // Assuming $link_identifier is mysqli object; select_db not needed if already set in constructor
        return true;
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link_identifier = null) {
        global $conn;
        if ($link_identifier === null) {
            $link_identifier = $conn;
        }
        // For queries that return a result set
        $result = $link_identifier->query($query);
        if ($result === false) {
            // trigger error similar to old mysql
            // error_log("MySQL Query Error: " . $link_identifier->error);
            return false;
        }
        // For INSERT/UPDATE/DELETE, $result is true/false; for SELECT it's mysqli_result
        return $result;
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        if (!$result || !is_object($result)) {
            return null;
        }
        return $result->fetch_array($result_type);
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result) {
        if (!$result || !is_object($result)) {
            return null;
        }
        return $result->fetch_assoc();
    }
}

if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row($result) {
        if (!$result || !is_object($result)) {
            return null;
        }
        return $result->fetch_row();
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        if (!$result || !is_object($result)) {
            return 0;
        }
        return $result->num_rows;
    }
}

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($link_identifier = null) {
        global $conn;
        if ($link_identifier === null) {
            $link_identifier = $conn;
        }
        return $link_identifier->affected_rows;
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link_identifier = null) {
        global $conn;
        if ($link_identifier === null) {
            $link_identifier = $conn;
        }
        return $link_identifier->insert_id;
    }
}

if (!function_exists('mysql_result')) {
    function mysql_result($result, $row = 0, $field = 0) {
        if (!$result || !is_object($result)) {
            return null;
        }
        // Use data seek then fetch row
        $result->data_seek($row);
        $row_data = $result->fetch_array();
        if ($row_data === null) {
            return null;
        }
        if (is_int($field)) {
            return $row_data[$field];
        } else {
            return $row_data[$field];
        }
    }
}

// mysql_real_escape_string is already defined in db.php; skip redeclaration

if (!function_exists('mysql_free_result')) {
    function mysql_free_result($result) {
        if ($result && is_object($result)) {
            $result->free();
        }
    }
}

if (!function_exists('mysql_errno')) {
    function mysql_errno($link_identifier = null) {
        global $conn;
        if ($link_identifier === null) {
            $link_identifier = $conn;
        }
        return $link_identifier->errno;
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link_identifier = null) {
        global $conn;
        if ($link_identifier === null) {
            $link_identifier = $conn;
        }
        return $link_identifier->error;
    }
}
?>