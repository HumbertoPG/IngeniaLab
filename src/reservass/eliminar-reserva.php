<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data['id']);

    if ($id > 0) {
        $pdo = Database::connect();
        $sql = "DELETE FROM reservas_maquina WHERE ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        Database::disconnect();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>