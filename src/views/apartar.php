<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>Admin Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</head>

<body>

    <?php include '../common/sideBar.html'; ?>

    <div class="main-content">
        <div class="header">
            <h1>Apartar Equipos</h1>
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Buscar por nombre, correo, etc.">
            <button class="search-button">Buscar</button>
        </div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Nombre Máquina</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'].'/TC2005B_602_01/IngeniaLab/config/database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM Maquinas';
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        if ($row['estado'] == 1) {
                            echo '<td> <i class="fas fa-lightbulb"></i> Encendido</td>';
                        } else if ($row['estado'] == 0) {
                            echo '<td> <i class="far fa-lightbulb"></i> Apagado</td>';
                        }
                        echo "<td>";
                        echo "<div class='button-container'>";
                        echo "<form method='POST' action='calendar.php'>";
                        echo "<button type='submit' class='reserve-button' data-id='" . ($row['ID']) . "'><i class='fas fa-calendar-alt'></i> Apartar</button>";
                        echo "<input type='hidden' name='machine_id' value='" . htmlspecialchars($row['ID']) . "'>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay equipos para mostrar.</td></tr>";
                }
                Database::disconnect();
                ?>
            </tbody>
        </table>

        <!-- Tabla de Mesas -->

        <table class="user-table">
            <thead>
                <tr>
                    <th>Nombre Mesa</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pdo = Database::connect();
                $sql = 'SELECT * FROM Mesas';
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                        if ($row['estado'] == 1) {
                            echo '<td> <i class="fas fa-lightbulb"></i> Encendido</td>';
                        } else if ($row['estado'] == 0) {
                            echo '<td> <i class="far fa-lightbulb"></i> Apagado</td>';
                        }
                        echo "<td>";
                        echo "<div class='button-container'>";
                        echo "<form method='POST' action='calendar.php'>";
                        echo "<button type='submit' class='reserve-button' data-id='" . ($row['ID']) . "'><i class='fas fa-calendar-alt'></i> Apartar</button>";
                        echo "<input type='hidden' name='mesas_id' value='" . htmlspecialchars($row['ID']) . "'>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay mesas para mostrar.</td></tr>";
                }
                Database::disconnect();
                ?>
            </tbody>
        </table>
    </div>

    <script src="../../public/js/modal.js"></script>

</body>
</html>
