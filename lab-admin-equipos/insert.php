<?php

include 'database.php';

$pdo = Database::connect();

$idType = 1; // Asumiendo que sabes qué idType se debe asignar.

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id']) && !empty($_POST['nombre'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $estado = 1; // Estado inicial es 0.
    $fechaR = "2024-03-20"; // Fecha actual.
    $tiempoUsoTotal = 0.0; // Tiempo de uso total inicial.

    $sql0 = "SELECT * FROM CRUD_Maquinas WHERE id = ?";
    $stmt = $pdo->prepare($sql0);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        echo "El ID ya está en uso. Por favor, elija otro";
    }
    else {

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO CRUD_Maquinas (idType, id, nombre, estado, fechaRegistro, tiempoUsoTotal) values(?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($idType, $id, $nombre, $estado, $fechaR, $tiempoUsoTotal));
        echo "Maquina agregada exitosamente";

    }
}
Database::disconnect();

?>