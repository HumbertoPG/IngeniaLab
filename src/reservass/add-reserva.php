<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/TC2005B_602_01/IngeniaLab/config/database.php';

// Obtener conexión a la base de datos
$pdo = Database::connect();

// Ruta para guardar eventos en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eventsArr'])) {
    $eventsArr = json_decode($_POST['eventsArr'], true);

    foreach ($eventsArr as $event) {
        $day = $event['day'];
        $month = $event['month'];
        $year = $event['year'];
        
        foreach ($event['events'] as $subEvent) {
            $title = $subEvent['title'];
            $time_from = $subEvent['time_from']; // Hora de inicio del evento
            $time_to = $subEvent['time_to'];     // Hora de fin del evento

            // Obtener el idUsuario de la sesión actual y el id de la máquina seleccionada
            $idUsuario = $_SESSION['idUsuario'] ?? 0;  // ID del usuario de la sesión actual
            $maquina = $_SESSION['machine_id'] ?? 0;   // ID de la máquina seleccionada

            $fechaInicio = sprintf("%04d-%02d-%02d %s:00", $year, $month, $day, $time_from); // Fecha y hora de inicio del evento
            $fechaFinal = sprintf("%04d-%02d-%02d %s:00", $year, $month, $day, $time_to);   // Fecha y hora de fin del evento
            $motivo_uso = 'Evento reservado';

            try {
                // Preparar la sentencia SQL
                $sql = "INSERT INTO Reservas_maquina (idUsuarios, fechaInicio, fechaFinal, maquina, motivo_uso, titulo, hora_inicio, hora_fin)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                
                // Preparar la sentencia
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$idUsuario, $fechaInicio, $fechaFinal, $maquina, $motivo_uso, $title, $time_from, $time_to]);

                echo "Evento guardado correctamente";
            } catch (PDOException $e) {
                echo "Error al guardar evento: " . $e->getMessage();
            }
        }
    }
}

// Ruta para obtener eventos de la base de datos
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $sql = "SELECT * FROM Reservas_maquina";
        $stmt = $pdo->query($sql);
        $eventsArr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = array(
                'day' => (int) substr($row['fechaInicio'], 8, 2),
                'month' => (int) substr($row['fechaInicio'], 5, 2),
                'year' => (int) substr($row['fechaInicio'], 0, 4),
                'events' => array(
                    array(
                        'title' => $row['titulo'],
                        'time_from' => substr($row['hora_inicio'], 0, 5),
                        'time_to' => substr($row['hora_fin'], 0, 5)
                    )
                )
            );
            $eventsArr[] = $event;
        }

        echo json_encode($eventsArr);
    } catch (PDOException $e) {
        echo "Error al obtener eventos: " . $e->getMessage();
    }
}

// Cerrar conexión
$pdo = null;
?>
