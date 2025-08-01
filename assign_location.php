<?php
require_once 'db_connect.php';

$location = $_POST['location_name'];
$user_ids = $_POST['selected_users'] ?? [];

$response = ['success' => false, 'message' => ''];

if (!$location || empty($user_ids)) {
    $response['message'] = 'Missing location or user selection.';
    echo json_encode($response);
    exit;
}

// Update each user
$placeholders = implode(',', array_fill(0, count($user_ids), '?'));
$stmt = $conn->prepare("UPDATE users SET location = ? WHERE id IN ($placeholders)");
$params = array_merge([$location], $user_ids);
$stmt->bind_param(str_repeat('s', 1) . str_repeat('i', count($user_ids)), ...$params);

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Users assigned successfully.';
} else {
    $response['message'] = 'Database error: ' . $stmt->error;
}

echo json_encode($response);
?>
