<?php
/**
 * Database Connection for PHP 8.3
 * Modernized from mysql_* to mysqli
 */

// Enable strict error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_host = 'localhost'; // Thay đổi nếu DB nằm ở container khác
$db_user = 'root';
$db_pass = '';
$db_name = 'avata_db'; // Ba kiểm tra lại tên DB chính xác nhé

try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// Load MySQL compatibility layer for PHP 8.3
require_once "mysql_compat.php";

// Helper function to replace mysql_real_escape_string
function mysql_real_escape_string($string) {
    global $conn;
    return mysqli_real_escape_string($conn, $string);
}
?>