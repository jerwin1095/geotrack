<?php
// Show errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Always return JSON
header('Content-Type: application/json');

// Collect errors to send as JSON if any
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "PHP Error [$errno]: $errstr in $errfile on line $errline"
    ]);
    exit;
});

set_exception_handler(function($e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "Uncaught Exception: " . $e->getMessage()
    ]);
    exit;
});

require_once 'db_connect.php';

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location_name = $_POST['location_name'] ?? '';
    $selected_users = $_POST['selected_users'] ?? [];
    if (empty($location_name) || empty($selected_users)) {
        $response['message'] = "Please provide a location and select at least one user.";
        echo json_encode($response);
        exit;
    }

    $errors = [];
    foreach ($selected_users as $user_id) {
        // Use parameterized queries to avoid SQL injection
        $update_res = pg_query_params($conn, "UPDATE users SET location=$1 WHERE id=$2", [$location_name, $user_id]);
        if (!$update_res) {
            $errors[] = "DB error for user $user_id: " . pg_last_error($conn);
            continue;
        }
    }
    if (count($errors) === 0) {
        $response['success'] = true;
        $response['message'] = "Users assigned successfully!";
    } else {
        $response['message'] = implode("\n", $errors);
    }
    echo json_encode($response);
    exit;
}

// If not POST
$response['message'] = "Invalid request method.";
echo json_encode($response);
exit;
?>
