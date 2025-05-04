<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orderItemID'])) {
    $orderItemID = intval($_POST['orderItemID']);

    $conn = new mysqli("localhost", "root", "", "login");
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
        exit();
    }
    $query = "DELETE FROM order_items WHERE orderItemID = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $orderItemID, $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete item']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
