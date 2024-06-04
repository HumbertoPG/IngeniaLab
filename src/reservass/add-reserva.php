<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';

// Obtener conexión a la base de datos
$pdo = Database::connect();
// Ruta para guardar eventos en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $motivo_uso = $data['motivo'];
    $time_from = $data['time_from'];
    $time_to = $data['time_to'];
    $day = $data['day'];
    $month = $data['month'];
    $year = $data['year'];

    // Obtener el idUsuario de la sesión actual y el id de la máquina seleccionada
    // $idUsuario = $_SESSION['idUsuario'] ?? 0;  // ID del usuario de la sesión actual
    
    $idUsuario = isset($_SESSION['idUsuario']);
    $idUsuario = 1;
    //$maquina = isset($_SESSION['machine_id']) ? $_SESSION['machine_id'] : 0;
    $maquina = isset($_SESSION['machine_id']);

    $fechaInicio = sprintf("%04d-%02d-%02d %s:00", $year, $month, $day, $time_from); // Fecha y hora de inicio del evento
    $fechaFinal = sprintf("%04d-%02d-%02d %s:00", $year, $month, $day, $time_to);   // Fecha y hora de fin del evento
   // $motivo_uso = 'Evento reservado'; 
   

    try {
        // Preparar la sentencia SQL
        $sql = "INSERT INTO Reservas_maquina (idUsuarios, fechaInicio, fechaFinal, maquina, motivo_uso)
                VALUES (?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $idUsuario, $fechaInicio, $fechaFinal, $maquina, $motivo_uso]);

        echo "Evento guardado correctamente";
    } catch (PDOException $e) {
        echo "Error al guardar evento: " . $e->getMessage();
    }
}

// Ruta para obtener eventos de la base de datos
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $sql = "SELECT * FROM Reservas_maquina";
        $stmt = $pdo->query($sql);
        //$eventsArr = array();

        $event = array(
                'day' => (int) substr($row['fechaInicio'], 8, 2),
                'month' => (int) substr($row['fechaInicio'], 5, 2),
                'year' => (int) substr($row['fechaInicio'], 0, 4),
                'events' => array(
                    array(
                        'motivo' => $row['motivo_uso'], 
                        'fechaInicio' => substr($row['hora_inicio'], 0, 5),
                        'fechaFinal' => substr($row['hora_fin'], 0, 5)
                    )
                )
            );
        //$eventsArr[] = $event;
        

        echo json_encode($eventsArr);
        
    } catch (PDOException $e) {
        echo "Error al obtener eventos: " . $e->getMessage();
    }
}
$pdo = null;
?>
