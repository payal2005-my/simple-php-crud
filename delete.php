<?php
session_start();

require_once __DIR__ . '/db.php';

// Only allow POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Validate the CSRF token submitted by index.php.
$token = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['csrf_token'] ?? '';

if (
    !is_string($token) ||
    !is_string($sessionToken) ||
    $token === '' ||
    $sessionToken === '' ||
    !hash_equals($sessionToken, $token)
) {
    http_response_code(403);
    exit('Invalid request. Please return to the homepage and try again.');
}

// Validate the user ID.
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Invalid user ID.');
}

try {
    $stmt = $pdo->prepare(
        'DELETE FROM users WHERE id = :id'
    );

    $stmt->execute([
        'id' => $id
    ]);

    if ($stmt->rowCount() === 0) {
        header('Location: index.php?status=not_found');
        exit;
    }

    header('Location: index.php?status=deleted');
    exit;

} catch (PDOException $e) {
    error_log('Delete user error: ' . $e->getMessage());

    http_response_code(500);
    exit('Unable to delete the user. Please try again.');
}
