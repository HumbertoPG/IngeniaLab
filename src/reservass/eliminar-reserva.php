<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);

    if ($id > 0) {
        $pdo = Database::connect();
        $sql = "DELETE FROM reservas_maquina WHERE ID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        Database::disconnect();
    }
}

header("Location: /TC2005B_602_01/IngeniaLab/src/views/home.php");
exit;
?>
